<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCategoryCollection;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;

class Categories extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $sequence = ServiceCategory::max('sequence');
        $request->validate([
            'parent_id' => 'required',
            'category' => 'required',
            'type' => 'required'
        ]);
        $category = new ServiceCategory();
        $category->parent_id = $request->post('parent_id');
        $category->name = $request->post('category');
        $category->sequence = intval($sequence) + 1;
        $category->type = $request->post('type');
        $category->save();

        return response()->json([
            'message' => 'Category has been created successfully.',
            'success' => true,
            'id' => $category->id,
            'entryUrl' => $category->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(ServiceCategory $category)
    {
        $category->load('parent');
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ServiceCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, ServiceCategory $category)
    {
        $request->validate([
            'id' => 'required',
            'parent_id' => 'required',
            'category' => 'required',
            'sequence' => 'required',
            'type' => 'required'
        ]);
        $category->parent_id = $request->post('parent_id');
        $category->name = $request->post('category');
        $category->sequence = $request->post('sequence');
        $category->type = $request->post('type');
        $category->save();

        // return response()->json($category);
        return response()->json([
            'message' => 'Category has been updated successfully.',
            'success' => true,
            'entryUrl' => $category->entry_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ServiceCategory $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Category deleted',
            'success' => true,
            'indexUrl' => route('admin.category.list')
        ]);
    }

    public function duplicate(ServiceCategory $category)
    {
        $newCategory = $category->replicate();
        $newCategory->name = 'Copy of ' . $category->name;
        $newCategory->save();

        // copy all related services
        $category->load('services');
        $services = $category->services;
        foreach ($services as $service) {
            $newService = $service->replicate([
                'category',
                'section'
            ]);
            $newService->category_id = $newCategory->id;
            // $newService->name = '= My Copy ' . $service->name;
            $newService->save();
        }

        // copy all sub categories
        $category->load('children');
        $categories = $category->children;
        foreach ($categories as $subCategory) {
            $newSubCategory = $subCategory->replicate([
                'category',
                'section'
            ]);
            $newSubCategory->parent_id = $newCategory->id;
            // $newSubCategory->name = '== My Copy ' . $subCategory->name;
            $newSubCategory->save();

            $subCategory->load('services');
            $services = $subCategory->services;
            foreach ($services as $service) {
                $newService = $service->replicate([
                    'category',
                    'section'
                ]);
                $newService->category_id = $newSubCategory->id;
                // $newService->name = '=== My Copy ' . $service->name;
                $newService->save();
            }
        }

        return response()->json([
            'message' => 'Category has been duplicated successfully.',
            'success' => true
        ]);
    }

    public function list(Request $request)
    {
        $records = ServiceCategory::orderBy('name', 'asc')
            ->get();

        $resourceCollection = new ServiceCategoryCollection($records);

        return $resourceCollection;
    }

    public function servicesList(ServiceCategory $category)
    {
        $data = array(
            'record' => $category
        );

        return view('components.category.service-list', $data);
    }

    public function massUpdate(Request $request)
    {
        $field = $request->post('field');   // parent, type
        $value = $request->post('value');   // id of selected item
        if ($request->has('existingItems')) {
            $existingItems = $request->post('existingItems');
        } else {
            $existingItems = array();
        }

        $valid = false;
        $delete = false;
        $type = false;
        $parentId = false;
        switch($field) {
            case 'parent_id':
                $valid = true;
                $rootCategory = ServiceCategory::whereId($value)
                    ->first();
                $type = $rootCategory->type;
                break;
            case 'type':
                switch($value) {
                    case 'T&T_NO':
                        $valid = true;
                        $rootCategoryTTNo = ServiceCategory::whereSequence(0)
                            ->whereType(ServiceCategory::TYPE_TT_NO)
                            ->first();
                        $parentId = $rootCategoryTTNo->id;
                        break;
                    case 'T&T_YES':
                        $valid = true;
                        $rootCategoryTTYes = ServiceCategory::whereSequence(0)
                            ->whereType(ServiceCategory::TYPE_TT_YES)
                            ->first();
                        $parentId = $rootCategoryTTYes->id;
                        break;
                    default:
                        break;
                }
                break;
            case 'Delete':
                $valid = true;
                $delete = true;
                break;
            default:
                break;
        }

        if (count($existingItems) == 0) {
            $valid = false;
        }

        if ($valid == true) {
            if ($delete == true) {
                ServiceCategory::whereIn('id', $existingItems)
                    ->delete();
            } else {
                $data = array($field => $value);
                if ($type !== false) {
                    $data['type'] = $type;
                }
                if ($parentId !== false) {
                    $data['parent_id'] = $parentId;
                }
                ServiceCategory::whereIn('id', $existingItems)
                    ->update($data);
            }
            return response()->json([
                'message' => 'Records updated',
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Records not updated',
                'success' => false
            ]);
        }
    }
}

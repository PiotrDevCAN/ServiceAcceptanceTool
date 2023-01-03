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
            'category' => 'required'
        ]);
        $category = new ServiceCategory();
        $category->parent_id = $request->parent_id;
        $category->name = $request->category;
        $category->sequence = intval($sequence) + 1;
        $category->type = $request->type;
        $category->save();

        return response()->json([
            'message' => 'Category has been created successfully.',
            'success' => true,
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
        $records = ServiceCategory::get();

        $resourceCollection = new ServiceCategoryCollection($records);

        return $resourceCollection;
    }
}

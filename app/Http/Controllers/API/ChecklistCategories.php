<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChecklistCategory;
use App\Models\ServiceCategory;

class ChecklistCategories extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'checklist_id' => 'required',
            'category_id' => 'required',
            'in_scope' => 'required',
            'status' => 'required'
        ]);
        $category = new ChecklistCategory();
        $category->checklist_id = $request->post('checklist_id');
        $category->category_id = $request->post('category_id');
        $category->in_scope = $request->post('in_scope');
        $category->status = $request->post('status');
        $category->save();

        return response()->json([
            'message' => 'Section has been created successfully.',
            'success' => true,
            'id' => $category->id,
            'entryUrl' => $category->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  ChecklistCategory $category
     * @return \Illuminate\Http\Response
     */
    public function show(ChecklistCategory $category)
    {
        $category->category->load('parent');
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ChecklistCategory $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChecklistCategory $category)
    {
        $request->validate([
            'id' => 'required',
            'checklist_id' => 'required',
            'category_id' => 'required',
            'in_scope' => 'required',
            'status' => 'required'
        ]);
        $category->id = $request->post('id');
        $category->checklist_id = $request->post('checklist_id');
        $category->category_id = $request->post('category_id');
        $category->in_scope = $request->post('in_scope');
        $category->status = $request->post('status');
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
     * @param  ChecklistCategory $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChecklistCategory $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Section deleted',
            'success' => true,
            'indexUrl' => route('admin.checklistCategory.list')
        ]);
    }

    public function massUpdate(Request $request)
    {
        $checklistId = $request->post('checklistId');
        $field = $request->post('field');   // in_scope, status
        $value = $request->post('value');
        if ($request->has('existingItems')) {
            $existingItems = $request->post('existingItems');
        } else {
            $existingItems = array();
        }
        if ($request->has('newItems')) {
            $newItems = $request->post('newItems');
        } else {
            $newItems = array();
        }

        $valid = false;
        $in_scope_value = ServiceCategory::IN_SCOPE_NO;
        $status_value = ServiceCategory::STATUS_NOT_COMPLETE;
        switch($field) {
            case 'in_scope':
                switch($value) {
                    case ServiceCategory::IN_SCOPE_YES:
                        $valid = true;
                        $in_scope_value = ServiceCategory::IN_SCOPE_YES;
                        break;
                    case ServiceCategory::IN_SCOPE_NO:
                        $valid = true;
                        $in_scope_value = ServiceCategory::IN_SCOPE_NO;
                        break;
                    default:
                        break;
                }
                break;
            case 'status':
                switch($value) {
                    case ServiceCategory::STATUS_COMPLETE:
                        $valid = true;
                        $status_value = ServiceCategory::STATUS_COMPLETE;
                        break;
                    case ServiceCategory::STATUS_NOT_COMPLETE:
                        $valid = true;
                        $status_value = ServiceCategory::STATUS_NOT_COMPLETE;
                        break;
                    default:
                        break;
                }
                break;
            default:
                break;
        }

        if (count($existingItems) == 0 && count($newItems) == 0) {
            $valid = false;
        }

        if ($valid == true) {

            if (count($existingItems) > 0) {
                ChecklistCategory::whereIn('id', $existingItems)
                    ->update([$field => $value]);
            }

            if (count($newItems) > 0) {
                foreach($newItems as $key => $categoryId) {
                    $category = new ChecklistCategory();
                    $category->checklist_id = $checklistId;
                    $category->category_id = $categoryId;
                    $category->in_scope = $in_scope_value;
                    $category->status = $status_value;
                    $category->save();
                }
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChecklistCategory;

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
}

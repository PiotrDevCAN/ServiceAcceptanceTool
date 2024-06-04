<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceSectionCollection;
use App\Models\ChecklistService;
use Illuminate\Http\Request;
use App\Models\ServiceSection;

class Sections extends Controller
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
            'section' => 'required'
        ]);
        $section = new ServiceSection();
        $section->name = $request->post('section');
        $section->save();

        return response()->json([
            'message' => 'Section has been created successfully.',
            'success' => true,
            'id' => $section->id,
            'entryUrl' => $section->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  ServiceSection $section
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceSection $section)
    {
        return response()->json($section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ServiceSection $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceSection $section)
    {
        $request->validate([
            'id' => 'required',
            'section' => 'required'
        ]);
        $section->name = $request->post('section');
        $section->save();

        // return response()->json($section);
        return response()->json([
            'message' => 'Section has been updated successfully.',
            'success' => true,
            'entryUrl' => $section->entry_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ServiceSection $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceSection $section)
    {
        $section->delete();
        return response()->json([
            'message' => 'Section deleted',
            'success' => true,
            'indexUrl' => route('admin.section.list')
        ]);
    }

    public function duplicate(ServiceSection $section)
    {
        $newSection = $section->replicate();
        $newSection->name = 'Copy ' . $section->name;
        $newSection->save();

        return response()->json([
            'message' => 'Section has been duplicated successfully.',
            'success' => true
        ]);
    }

    public function list(Request $request)
    {
        $records = ServiceSection::orderBy('name', 'asc')
            ->get();

        $resourceCollection = new ServiceSectionCollection($records);

        return $resourceCollection;
    }

    public function massUpdate(Request $request)
    {
        $field = $request->post('field');   // category, service
        $value = $request->post('value');   // id of selected item
        if ($request->has('existingItems')) {
            $existingItems = $request->post('existingItems');
        } else {
            $existingItems = array();
        }

        $valid = false;
        $delete = false;
        switch($field) {
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
                ServiceSection::whereIn('id', $existingItems)
                    ->delete();
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

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
        $section->name = $request->section;
        $section->save();

        return response()->json([
            'message' => 'Section has been created successfully.',
            'success' => true,
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
        $records = ServiceSection::get();

        $resourceCollection = new ServiceSectionCollection($records);

        return $resourceCollection;
    }
}

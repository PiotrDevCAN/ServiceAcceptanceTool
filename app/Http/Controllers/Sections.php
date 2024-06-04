<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceSection;
use App\Http\Resources\ServiceSectionCollection;

class Sections extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ServiceSection::class, 'section');
    }

    private function preparePredicates($request)
    {
        $predicates = array();

        if ($request->filled('competency')) {
            $predicates[] = array('competency', '=', $request->input('competency'));
        };
        if ($request->filled('approver')) {
            $predicates[] = array('approver', '=', $request->input('approver'));
        };

        return $predicates;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $records = ServiceSection::orderBy('name', 'asc')
            ->get();
        $model = new ServiceSection();

        $data = array(
            'records' => $records,
            'record' => $model
        );

        return view('components.section.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new ServiceSection();

        $data = array(
            'record' => $model
        );

        return view('components.section.create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceSection $section
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceSection $section)
    {
        $data = array(
            'record' => $section
        );

        return view('components.section.edit', $data);
    }

    public function exportList()
    {
        $fileName = 'sections.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Name', 'Created At', 'Updated At');

        $records = ServiceSection::all();
        $resourceCollection = new ServiceSectionCollection($records);

        $callback = function() use($resourceCollection, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resourceCollection as $resource) {
                fputcsv($file, array(
                    $resource->id,
                    $resource->name,
                    $resource->created_at,
                    $resource->updated_at,
                ));

                // fputcsv($file, (array) $resource);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

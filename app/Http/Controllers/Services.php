<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use App\Http\Resources\ServiceCollection;

class Services extends Controller
{
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
        $recordsYes = Service::has('categoryTTYes')
            ->get();

        $recordsNo = Service::has('categoryTTNo')
            ->get();

        $model = new Service();

        $data = array(
            'recordsYes' => $recordsYes,
            'recordsNo' => $recordsNo,
            'record' => $model,
        );

        return view('components.service.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Service();

        $data = array(
            'record' => $model,
        );

        return view('components.service.create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $data = array(
            'record' => $service,
        );

        return view('components.service.edit', $data);
    }

    public function exportList()
    {
        $fileName = 'services.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Category Id', 'Section Id', 'Name', 'Created At', 'Updated At');

        $records = Service::all();
        $resourceCollection = new ServiceCollection($records);

        $callback = function() use($resourceCollection, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resourceCollection as $resource) {
                fputcsv($file, array(
                    $resource->id,
                    $resource->category_id,
                    $resource->section_id,
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

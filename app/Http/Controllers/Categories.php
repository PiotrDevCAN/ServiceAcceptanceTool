<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Http\Resources\ServiceCategoryCollection;

class Categories extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(ServiceCategory::class, 'category');
    }

    private function preparePredicates($request)
    {
        $predicates = array();

        if ($request->filled('id')) {
            $predicates[] = array('id', '=', $request->input('id'));
        };
        if ($request->filled('name')) {
            $predicates[] = array('name', '=', $request->input('name'));
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
        $model = new ServiceCategory();

        $rootCategoryTTYes = ServiceCategory::whereSequence(0)
            ->whereType(ServiceCategory::TYPE_TT_YES)
            ->first();

        $rootCategoryTTNo = ServiceCategory::whereSequence(0)
            ->whereType(ServiceCategory::TYPE_TT_NO)
            ->first();

        $categoriesTTYes = ServiceCategory::with(['parent', 'children', 'services'])
            ->whereParentId($rootCategoryTTYes->id)
            ->whereType(ServiceCategory::TYPE_TT_YES)
            ->orderBy('name', 'asc')
            ->get();

        $categoriesTTNo = ServiceCategory::with(['parent', 'children', 'services'])
            ->whereParentId($rootCategoryTTNo->id)
            ->whereType(ServiceCategory::TYPE_TT_NO)
            ->orderBy('name', 'asc')
            ->get();

        $categories = ServiceCategory::with(['parent', 'children'])->get();

        $types = ServiceCategory::TYPES;

        $data = array(
            'recordsYes' => $categoriesTTYes,
            'recordsNo' => $categoriesTTNo,
            'record' => $model,
            'categories' => $categories,
            'types' => $types
        );

        return view('components.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new ServiceCategory();

        $data = array(
            'record' => $model
        );

        return view('components.category.create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ServiceCategory $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceCategory $category)
    {
        $data = array(
            'record' => $category
        );

        return view('components.category.edit', $data);
    }

    public function exportList()
    {
        $fileName = 'categories.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Parent Id', 'Name', 'Sequence', 'Created At', 'Updated At');

        $records = ServiceCategory::all();
        $resourceCollection = new ServiceCategoryCollection($records);

        $callback = function() use($resourceCollection, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resourceCollection as $resource) {
                fputcsv($file, array(
                    $resource->id,
                    $resource->parent_id,
                    $resource->name,
                    $resource->sequence,
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCollection;
use Illuminate\Http\Request;
use App\Models\Service;

class Services extends Controller
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
            'category_id' => 'required',
            'section_id' => 'required',
            'service' => 'required'
        ]);
        $service = new service();
        $service->category_id = $request->category_id;
        $service->section_id = $request->section_id;
        $service->name = $request->service;
        $service->save();

        return response()->json([
            'message' => 'Service has been created successfully.',
            'success' => true,
            'entryUrl' => $service->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $service->category_id = $request->post('category_id');
        $service->section_id = $request->post('section_id');
        $service->name = $request->post('service');
        $service->save();

        // return response()->json($service);
        return response()->json([
            'message' => 'Service has been updated successfully.',
            'success' => true,
            'entryUrl' => $service->entry_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Service deleted',
            'success' => true,
            'indexUrl' => route('admin.service.list')
        ]);
    }

    public function duplicate(Service $service)
    {
        $newService = $service->replicate([
            'category',
            'category_count',
            'section',
            'section_count'
        ]);
        $newService->name = 'Copy ' . $service->name;
        $newService->save();

        return response()->json([
            'message' => 'Service has been duplicated successfully.',
            'success' => true
        ]);
    }

    public function list(Request $request)
    {
        $records = Service::get();

        $resourceCollection = new ServiceCollection($records);

        return $resourceCollection;
    }
}

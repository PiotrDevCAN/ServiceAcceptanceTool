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
        $service->category_id = $request->post('category_id');
        $service->section_id = $request->post('section_id');
        $service->name = $request->post('service');
        $service->save();

        return response()->json([
            'message' => 'Service has been created successfully.',
            'success' => true,
            'id' => $service->id,
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
        $service->category->load('parent');
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
        $request->validate([
            'id' => 'required',
            'category_id' => 'required',
            'section_id' => 'required',
            'service' => 'required'
        ]);
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
        $records = Service::orderBy('name', 'asc')
            ->get();

        $resourceCollection = new ServiceCollection($records);

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
            case 'category_id':
                $valid = true;
                break;
            case 'section_id':
                $valid = true;
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
                Service::whereIn('id', $existingItems)
                    ->delete();
            } else {
                Service::whereIn('id', $existingItems)
                    ->update([$field => $value]);
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\ChecklistService;
use DateTime;

class ChecklistServices extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'checklist_id' => 'required',
            'service_id' => 'required',
            'status' => 'required',
            'evidence' => 'required',
            'user_input' => 'required',
            'completition_date' => 'required'
        ]);
        $service = new ChecklistService();
        $service->checklist_id = $request->post('checklist_id');
        $service->service_id = $request->post('service_id');
        $service->status = $request->post('status');
        $service->evidence = $request->post('evidence');
        $service->user_input = $request->post('user_input');
        $completition_date = DateTime::createFromFormat('d/m/Y', $request->post('completition_date'));
        $service->completition_date = $completition_date->format("Y-m-d H:i:s");
        $service->save();

        return response()->json([
            'message' => 'Section has been created successfully.',
            'success' => true,
            'entryUrl' => $service->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  ChecklistService $service
     * @return \Illuminate\Http\Response
     */
    public function show(ChecklistService $service)
    {
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ChecklistService $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChecklistService $service)
    {
        $service->id = $request->post('id');
        $service->checklist_id = $request->post('checklist_id');
        $service->service_id = $request->post('service_id');
        $service->status = $request->post('status');
        $service->evidence = $request->post('evidence');
        $service->user_input = $request->post('user_input');
        $service->completition_date = $request->post('completition_date');
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
     * @param  ChecklistService $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChecklistService $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Section deleted',
            'success' => true,
            'indexUrl' => route('admin.checklistService.list')
        ]);
    }
}

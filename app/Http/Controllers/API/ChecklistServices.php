<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;
use App\Models\ChecklistService;
use App\Models\Service;
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
            // 'evidence' => 'required',
            // 'user_input' => 'required',
            // 'completition_date' => 'required'
            // 'owner' => 'required',
            // 'owner_notes_id' => 'required',
            // 'owner_intranet_id' => 'required'
        ]);
        $service = new ChecklistService();
        $service->checklist_id = $request->post('checklist_id');
        $service->service_id = $request->post('service_id');
        $service->status = $request->post('status');
        $service->evidence = $request->post('evidence');
        $service->user_input = $request->post('user_input');
        // $completition_date = DateTime::createFromFormat('d/m/Y', $request->post('completition_date'));
        // $service->completition_date = $completition_date->format("Y-m-d H:i:s");
        $service->completition_date = $request->post('completition_date');
        $service->owner = $request->post('owner');
        $service->owner_notes_id = $request->post('owner_notes_id');
        $service->owner_intranet_id = $request->post('owner_intranet_id');
        $service->save();

        return response()->json([
            'message' => 'Section has been created successfully.',
            'success' => true,
            'id' => $service->id,
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
        $service->service->category->load('parent');
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
        $request->validate([
            'id' => 'required',
            'checklist_id' => 'required',
            'service_id' => 'required',
            'status' => 'required',
            // 'evidence' => 'required',
            // 'user_input' => 'required',
            // 'completition_date' => 'required'
            // 'owner' => 'required',
            // 'owner_intranet_id' => 'required',
            // 'owner_notes_id' => 'required'
        ]);
        $service->id = $request->post('id');
        $service->checklist_id = $request->post('checklist_id');
        $service->service_id = $request->post('service_id');
        $service->status = $request->post('status');
        $service->evidence = $request->post('evidence');
        $service->user_input = $request->post('user_input');
        // $completition_date = DateTime::createFromFormat('d/m/Y', $request->post('completition_date'));
        // $service->completition_date = $completition_date->format("Y-m-d H:i:s");
        $service->completition_date = $request->post('completition_date');
        $service->owner = $request->post('owner');
        $service->owner_notes_id = $request->post('owner_notes_id');
        $service->owner_intranet_id = $request->post('owner_intranet_id');
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
        $status_value = Service::IN_SCOPE_NOT_IN_SCOPE;
        switch($field) {
            case 'status':
                switch($value) {
                    case Service::IN_SCOPE_YES:
                        $valid = true;
                        $status_value = Service::IN_SCOPE_YES;
                        break;
                    case Service::IN_SCOPE_NO:
                        $valid = true;
                        $status_value = Service::IN_SCOPE_NO;
                        break;
                    case Service::IN_SCOPE_NOT_IN_SCOPE:
                        $valid = true;
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
                ChecklistService::whereIn('id', $existingItems)
                    ->update([$field => $value]);
            }

            if (count($newItems) > 0) {
                foreach($newItems as $key => $serviceId) {
                    $service = new ChecklistService();
                    $service->checklist_id = $checklistId;
                    $service->service_id = $serviceId;
                    $service->status = $status_value;
                    $service->save();
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

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Facades\BlueGroups;
use App\Facades\BlueGroupsManage;
use App\Http\Resources\AccessRequestCollection;
use App\Models\AccessRequest;

class AccessRequests extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (AccessRequest::where('employee_intranet_id', $request->employee_intranet_id)->exists()) {
            // request already exists
            return response()->json([
                'message' => 'Access Request has been already requested',
                'success' => false
            ]);
        } else {
            // Get the currently authenticated user...
            $user = Auth::user();
            $userMail = $user->mail[0];

            $request->validate([
                'employee' => 'required',
            ]);
            $access = new AccessRequest();
            $access->employee = $request->employee;
            $access->employee_notes_id = $request->employee_notes_id;
            $access->employee_intranet_id = $request->employee_intranet_id;
            $access->status = AccessRequest::STATUS_PENDING;
            $access->type = AccessRequest::TYPE_ADMIN;
            $access->created_by = $userMail;
            $access->save();

            return response()->json([
                'message' => 'Access Request has been created successfully.',
                'success' => true,
                'entryUrl' => $access->entry_url
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param AccessRequest $access
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AccessRequest $access)
    {
        return response()->json($access);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  AccessRequest $access
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AccessRequest $access)
    {
        $access->employee = $request->input('employee');
        $access->employee_notes_id = $request->input('employee_notes_id');
        $access->employee_intranet_id = $request->input('employee_intranet_id');
        $access->status = $request->input('status');
        $access->type = $request->input('type');
        $access->created_by = $request->input('created_by');
        $access->save();

        // return response()->json($account);
        return response()->json([
            'message' => 'Access Request has been updated successfully.',
            'success' => true,
            'entryUrl' => $access->entry_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AccessRequest $access
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(AccessRequest $access)
    {
        $access->delete();
        return response()->json([
            'message' => 'Access Request deleted',
            'success' => true,
            'indexUrl' => route('admin.access.pending')
        ]);
    }

    public function approve(AccessRequest $access)
    {
        $access->status = AccessRequest::STATUS_APPROVED;
        $access->save();

        $userMail = $access->employee_intranet_id;
        $adminBg = app()->config['app']['adminBg'];
        $auth = BlueGroups::groupAuth($userMail, $adminBg);

        if ($auth) {
            return response()->json([
                'message' => 'Employee is already member of the '.$adminBg.' Blue Group.',
                'success' => false
            ]);
        } else {
            BlueGroupsManage::addMember($adminBg, $userMail);
        }

        // return response()->json($account);
        return response()->json([
            'message' => 'Access Request has been approved successfully.',
            'success' => true
        ]);
    }

    public function reject(AccessRequest $access)
    {
        $access->status = AccessRequest::STATUS_REJECTED;
        $access->save();

        $userMail = $access->employee_intranet_id;
        $adminBg = app()->config['app']['adminBg'];
        $auth = BlueGroups::groupAuth($userMail, $adminBg);

        if ($auth) {
            BlueGroupsManage::deleteMember($adminBg, $userMail);
        } else {
            return response()->json([
                'message' => 'Employee is not a member of the '.$adminBg.' Blue Group.',
                'success' => false
            ]);
        }

        return response()->json([
            'message' => 'Access Request has been rejected successfully.',
            'success' => true
        ]);
    }

    public function list(Request $request)
    {
        $records = AccessRequest::get();

        $resourceCollection = new AccessRequestCollection($records);

        return $resourceCollection;
    }
}

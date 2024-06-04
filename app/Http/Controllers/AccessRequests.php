<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use Illuminate\Http\Request;
use App\Services\Contracts\BlueGroupsManageServiceInterface;

class AccessRequests extends Controller
{
    public $blueGroupsManage;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(BlueGroupsManageServiceInterface $blueGroupsManage)
    {
        $this->blueGroupsManage = $blueGroupsManage;

        $this->authorizeResource(AccessRequest::class, 'accessRequest');
    }

    public function users(Request $request)
    {
        $group = app()->config['app']['userBg'];

        if (is_null($group)) {
            $records = array();
            $model = new AccessRequest();
        } else {
            $records = $this->blueGroupsManage->listMembers($group);
            $model = new AccessRequest();
        }

        $data = array(
            'records' => $records,
            'record' => $model
        );

        return view('components.access.users', $data);
    }

    public function admins(Request $request)
    {
        $group = app()->config['app']['adminBg'];

        $records = $this->blueGroupsManage->listMembers($group);
        $model = new AccessRequest();

        $data = array(
            'records' => $records,
            'record' => $model
        );

        return view('components.access.admins', $data);
    }

    public function requestForAccess(Request $request)
    {
        // $group = app()->config['app']['adminBg'];
        $model = new AccessRequest();

        $data = array(
            'record' => $model
        );

        return view('components.access.request', $data);
    }

    public function pendingRequests(Request $request)
    {
        $pending = AccessRequest::where('status', '=', AccessRequest::STATUS_PENDING)
            ->get();

        $approved = AccessRequest::where('status', '=', AccessRequest::STATUS_APPROVED)
            ->get();

        $rejected = AccessRequest::where('status', '=', AccessRequest::STATUS_REJECTED)
            ->get();

        $model = new AccessRequest();

        $data = array(
            'pending' => $pending,
            'approved' => $approved,
            'rejected' => $rejected,
            'record' => $model
        );

        return view('components.access.pending', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new AccessRequest();

        $data = array(
            'record' => $model
        );

        return view('components.access.create', $data);
    }

    /**
    * Display the specified resource.
    *
    * @param  AccessRequest $access
    * @return \Illuminate\Http\Response
    */
    public function show(AccessRequest $access)
    {
    return view('components.access.show',compact('access'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AccessRequest $access
     * @return \Illuminate\Http\Response
     */
    public function edit(AccessRequest $access)
    {
        $data = array(
            'record' => $access
        );

        return view('components.access.edit', $data);
    }
}

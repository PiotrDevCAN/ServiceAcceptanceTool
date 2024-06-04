<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Resources\AccountCollection;

class Accounts extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Account::class, 'account');
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
        $predicates = $this->preparePredicates($request);

        $records = Account::getWithPredicates($predicates);
        $model = new Account();

        $data = array(
            'records' => $records,
            'record' => $model
        );

        return view('components.account.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Account();

        $data = array(
            'record' => $model
        );

        return view('components.account.create', $data);
    }

    /**
    * Display the specified resource.
    *
    * @param  Account $account
    * @return \Illuminate\Http\Response
    */
    public function show(Account $account)
    {
    return view('components.account.show',compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Account $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $data = array(
            'record' => $account
        );

        return view('components.account.edit', $data);
    }

    public function exportList()
    {
        $fileName = 'accounts.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Name', 'Transition State', 'Go Live Date', 'Account DPE', 'TT Focal', 'Created At', 'Updated At', 'Created By');

        $records = Account::all();
        $resourceCollection = new AccountCollection($records);

        $callback = function() use($resourceCollection, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resourceCollection as $resource) {
                fputcsv($file, array(
                    $resource->id,
                    $resource->name,
                    $resource->transition_state,
                    $resource->go_live_date,
                    $resource->account_dpe,
                    $resource->account_dpe_notes_id,
                    $resource->account_dpe_intranet_id,
                    $resource->tt_focal,
                    $resource->tt_focal_notes_id,
                    $resource->tt_focal_intranet_id,
                    $resource->created_at,
                    $resource->updated_at,
                    $resource->created_by,
                ));

                // fputcsv($file, (array) $resource);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

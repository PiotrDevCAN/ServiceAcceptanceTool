<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCollection;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $userMail = $user->mail[0];

        $request->validate([
            'account' => 'required',
            'transition_state' => 'required',
            'go_live_date' => 'required',
            'account_dpe' => 'required',
            'account_dpe_notes_id' => 'required',
            'account_dpe_intranet_id' => 'required',
            'tt_focal' => 'required',
            'tt_focal_notes_id' => 'required',
            'tt_focal_intranet_id' => 'required'
        ]);
        $account = new Account();
        $account->name = $request->post('account');
        $account->transition_state = $request->post('transition_state');
        $account->go_live_date = $request->post('go_live_date');
        $account->account_dpe = $request->post('account_dpe');
        $account->account_dpe_notes_id = $request->post('account_dpe_notes_id');
        $account->account_dpe_intranet_id = $request->post('account_dpe_intranet_id');
        $account->tt_focal = $request->post('tt_focal');
        $account->tt_focal_notes_id = $request->post('tt_focal_notes_id');
        $account->tt_focal_intranet_id = $request->post('tt_focal_intranet_id');
        $account->created_by = $userMail;
        $account->save();

        return response()->json([
            'message' => 'Account has been created successfully.',
            'success' => true,
            'id' => $account->id,
            'entryUrl' => $account->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Account $account)
    {
        return response()->json($account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'id' => 'required',
            'account' => 'required',
            'transition_state' => 'required',
            'go_live_date' => 'required',
            'account_dpe' => 'required',
            'account_dpe_notes_id' => 'required',
            'account_dpe_intranet_id' => 'required',
            'tt_focal' => 'required',
            'tt_focal_notes_id' => 'required',
            'tt_focal_intranet_id' => 'required',
            'created_by' => 'required'
        ]);

        $account->name = $request->post('account');
        $account->transition_state = $request->post('transition_state');
        $account->go_live_date = $request->post('go_live_date');
        $account->account_dpe = $request->post('account_dpe');
        $account->account_dpe_notes_id = $request->post('account_dpe_notes_id');
        $account->account_dpe_intranet_id = $request->post('account_dpe_intranet_id');
        $account->tt_focal = $request->post('tt_focal');
        $account->tt_focal_notes_id = $request->post('tt_focal_notes_id');
        $account->tt_focal_intranet_id = $request->post('tt_focal_intranet_id');
        $account->created_by = $request->post('created_by');
        $account->save();

        // return response()->json($account);
        return response()->json([
            'message' => 'Account has been updated successfully.',
            'success' => true,
            'entryUrl' => $account->entry_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Account $account
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Account $account)
    {
        $account->delete();
        return response()->json([
            'message' => 'Account deleted',
            'success' => true,
            'indexUrl' => route('admin.account.list')
        ]);
    }

    public function duplicate(Account $account)
    {
        $newAccount = $account->replicate([
            'checklists',
            'checklists_count'
        ]);
        $newAccount->name = 'Copy ' . $account->name;
        $newAccount->save();

        return response()->json([
            'message' => 'Account has been duplicated successfully.',
            'success' => true
        ]);
    }

    public function list(Request $request)
    {
        $records = Account::orderBy('name', 'asc')
            ->get();

        $resourceCollection = new AccountCollection($records);

        return $resourceCollection;
    }
}

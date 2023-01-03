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
            // 'account_dpe_notes_id' => 'required',
            // 'account_dpe_intranet_id' => 'required',
            'tt_focal' => 'required',
            // 'tt_focal_notes_id' => 'required',
            // 'tt_focal_intranet_id' => 'required'
        ]);
        $account = new Account();
        $account->name = $request->account;
        $account->transition_state = $request->transition_state;
        $account->go_live_date = $request->go_live_date;
        $account->account_dpe = $request->account_dpe;
        $account->account_dpe_notes_id = $request->account_dpe_notes_id;
        $account->account_dpe_intranet_id = $request->account_dpe_intranet_id;
        $account->tt_focal = $request->tt_focal;
        $account->tt_focal_notes_id = $request->tt_focal_notes_id;
        $account->tt_focal_intranet_id = $request->tt_focal_intranet_id;
        $account->created_by = $userMail;
        $account->save();

        return response()->json([
            'message' => 'Account has been created successfully.',
            'success' => true,
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
        $account->name = $request->input('account');
        $account->transition_state = $request->input('transition_state');
        $account->go_live_date = $request->input('go_live_date');
        $account->account_dpe = $request->input('account_dpe');
        $account->account_dpe_notes_id = $request->input('account_dpe_notes_id');
        $account->account_dpe_intranet_id = $request->input('account_dpe_intranet_id');
        $account->tt_focal = $request->input('tt_focal');
        $account->tt_focal_notes_id = $request->input('tt_focal_notes_id');
        $account->tt_focal_intranet_id = $request->input('tt_focal_intranet_id');
        $account->created_by = $request->input('created_by');
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
        $records = Account::get();

        $resourceCollection = new AccountCollection($records);

        return $resourceCollection;
    }
}

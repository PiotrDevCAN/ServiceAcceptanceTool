<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChecklistCollection;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\ChecklistCategory;
use App\Models\ChecklistService;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\View\Components\Checklist\AccountStatus;
use Illuminate\Support\Facades\Auth;

class Checklists extends Controller
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
            'account_id' => 'required',
        ]);

        // create new account or update existing one
        if (!empty($request->input('account_id'))) {
            $accountId = $request->input('account_id');
            $account = Account::where('id', $accountId)->first();
        } else {
            $account = new Account();
            $account->name = $request->input('account');
            $account->created_by = $userMail;
        }
        $account->transition_state = $request->input('transition_state');
        $account->go_live_date = $request->input('go_live_date');
        $account->account_dpe = $request->input('account_dpe');
        $account->account_dpe_notes_id = $request->input('account_dpe_notes_id');
        $account->account_dpe_intranet_id = $request->input('account_dpe_intranet_id');
        $account->tt_focal = $request->input('tt_focal');
        $account->tt_focal_notes_id = $request->input('tt_focal_notes_id');
        $account->tt_focal_intranet_id = $request->input('tt_focal_intranet_id');
        $account->save();

        $accountId = $account->id;

        // create new checklist
        $checklist = new Checklist();
        $checklist->account_id = $accountId;
        $checklist->name = $request->input('checklist_name');
        $checklist->type = $request->input('checklist_type');
        $checklist->created_by = $userMail;
        $checklist->save();

        return response()->json([
            'message' => 'Checklist has been created successfully.',
            'success' => true,
            'entryUrl' => $checklist->entry_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Checklist $checklist
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Checklist $checklist)
    {
        return response()->json($checklist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Checklist $checklist
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Checklist $checklist)
    {
        $checklist = new Checklist();
        $checklist->id = $request->input('checklist_id');
        $checklist->account_id = $request->input('account_id');
        $checklist->name = $request->input('checklist_name');
        $checklist->type = $request->input('checklist_type');
        $checklist->created_by = $request->input('created_by');

        if ($request->input('checklist_type') !== $request->input('checklist_type_old')) {
            // Delete Checklist Services
            $checklist->checklistServices->each->delete();

            // Delete Checklist Categories
            $checklist->checklistCategories->each->delete();
        }

        // return response()->json($checklist);
        return response()->json([
            'message' => 'Checklist has been updated successfully.',
            'success' => true,
            'entryUrl' => $checklist->entry_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Checklist $checklist
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Checklist $checklist)
    {
        $checklist->delete();
        return response()->json([
            'message' => 'Checklist deleted',
            'success' => true,
            'indexUrl' => route('admin.checklist.list')
        ]);
    }

    public function duplicate(Checklist $checklist)
    {
        $newChecklist = $checklist->replicate();
        $newChecklist->name = 'Copy ' . $checklist->name;
        $newChecklist->duplicated_from = $checklist->id;
        $newChecklist->save();

        return response()->json([
            'message' => 'Checklist has been duplicated successfully.',
            'success' => true
        ]);
    }

    public function calculation(Checklist $checklist)
    {
        $accountStatus = new AccountStatus($checklist);

        $record = $accountStatus->record;

        $record->loadCount('inScopeYes', 'inScopeNo', 'notInScope');

        $calculation = $accountStatus->mainCategoriesCalculation;

        return response()->json([
            'record' => $record,
            'calculation' => $calculation
        ]);
    }

    public function list(Request $request)
    {
        $records = Checklist::get();

        $resourceCollection = new ChecklistCollection($records);

        return $resourceCollection;
    }
}

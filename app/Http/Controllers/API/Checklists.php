<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChecklistCollection;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\ServiceCategory;
use App\Services\MainCategoriesService;
use App\View\Components\Checklist\AccountStatus;

class Checklists extends Controller
{
    private $mainCategoriesService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(MainCategoriesService $mainCategoriesService)
    {
        $this->mainCategoriesService = $mainCategoriesService;
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
            'checklist_id' => 'present',
            'checklist_name' => 'required',
            'checklist_type' => 'required',
            'created_by' => 'present',

            'account_id' => 'present',
            'account_created_by' => 'present',
            'account' => 'required',

            'transition_state' => 'required',
            'go_live_date' => 'required',

            'account_dpe' => 'required',
            'account_dpe_intranet_id' => 'required',
            'account_dpe_notes_id' => 'required',

            'tt_focal' => 'exclude_if:has_appointment,false|required',
            'tt_focal_intranet_id' => 'exclude_if:checklist_type,T&T_NO|required',
            'tt_focal_notes_id' => 'exclude_if:checklist_type,T&T_NO|required'
        ]);

        // create new account or update existing one
        if (!empty($request->post('account_id'))) {
            $accountId = $request->post('account_id');
            $account = Account::where('id', $accountId)->first();
        } else {
            $account = new Account();
            $account->name = $request->post('account');
            $account->created_by = $userMail;
        }
        $account->transition_state = $request->post('transition_state');
        $account->go_live_date = $request->post('go_live_date');
        $account->account_dpe = $request->post('account_dpe');
        $account->account_dpe_notes_id = $request->post('account_dpe_notes_id');
        $account->account_dpe_intranet_id = $request->post('account_dpe_intranet_id');
        $account->tt_focal = $request->post('tt_focal');
        $account->tt_focal_notes_id = $request->post('tt_focal_notes_id');
        $account->tt_focal_intranet_id = $request->post('tt_focal_intranet_id');
        $account->save();

        $accountId = $account->id;

        // create new checklist
        $checklist = new Checklist();
        $checklist->account_id = $accountId;
        $checklist->name = $request->post('checklist_name');
        $checklist->type = $request->post('checklist_type');
        $checklist->created_by = $userMail;
        $checklist->save();

        return response()->json([
            'message' => 'Checklist has been created successfully.',
            'success' => true,
            'id' => $checklist->id,
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
        $request->validate([
            'checklist_id' => 'present',
            'checklist_name' => 'required',
            'checklist_type' => 'required',
            'checklist_type_old' => 'required',
            'created_by' => 'present',

            'account_id' => 'present',
            'account_created_by' => 'present',
            'account' => 'required',

            'transition_state' => 'required',
            'go_live_date' => 'required',

            'account_dpe' => 'required',
            'account_dpe_intranet_id' => 'required',
            'account_dpe_notes_id' => 'required',

            'tt_focal' => 'exclude_if:has_appointment,false|required',
            'tt_focal_intranet_id' => 'exclude_if:checklist_type,T&T_NO|required',
            'tt_focal_notes_id' => 'exclude_if:checklist_type,T&T_NO|required'
        ]);

        $checklist = new Checklist();
        $checklist->id = $request->post('checklist_id');
        $checklist->account_id = $request->post('account_id');
        $checklist->name = $request->post('checklist_name');
        $checklist->type = $request->post('checklist_type');
        $checklist->created_by = $request->post('created_by');

        if ($request->post('checklist_type') !== $request->post('checklist_type_old')) {
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

        $referer = request()->headers->get('referer');
        $adminSection = Str::contains($referer, 'admin');

        if ($adminSection) {
            $routeName = 'admin.checklist.list';
        } else {
            $routeName = 'checklist.list';
        }
        $route = route($routeName);

        return response()->json([
            'message' => 'Checklist deleted',
            'success' => true,
            'indexUrl' => $route
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
        $records = Checklist::orderBy('name', 'asc')
            ->get();

        $resourceCollection = new ChecklistCollection($records);

        return $resourceCollection;
    }

    public function categoriesList(Checklist $checklist)
    {
        $data = array(
            'checklist' => $checklist
        );

        return view('components.checklist.category-list', $data);
    }

    public function servicesList(Checklist $checklist)
    {
        $data = array(
            'record' => $checklist
        );

        return view('components.checklist.service-list', $data);
    }

    public function servicesByCategoryList(Checklist $checklist, ServiceCategory $category)
    {
        $mainCategoriesData = $this->mainCategoriesService->prepareMainCategories($checklist, $category);
        list(
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        $data = array(
            'mainCategories' => $mainCategories
        );

        return view('components.checklist.service-by-category-list', $data);
    }

    public function servicesSummary(Checklist $checklist, ServiceCategory $category)
    {
        $mainCategoriesData = $this->mainCategoriesService->prepareMainCategories($checklist, $category);
        list(
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        return response()->json([
            'services_in_scope_yes' => $mainCategories[0]->services_in_scope_yes,
            'services_in_scope_no' => $mainCategories[0]->services_in_scope_no,
            'services_not_in_scope' => $mainCategories[0]->services_not_in_scope,
            'ready_to_complete' => $mainCategories[0]->ready_to_complete
        ]);
    }
}

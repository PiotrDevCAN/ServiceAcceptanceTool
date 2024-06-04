<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChecklistCollection;
use App\Services\MainCategoriesService;

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
        $this->authorizeResource(Checklist::class, 'checklist');
    }

    private function preparePredicates($request)
    {
        $predicates = array();

        if ($request->filled('id')) {
            $predicates[] = array('id', '=', $request->input('id'));
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
        // Get the currently authenticated user...
        $user = Auth::user();
        $userMail = $user->mail[0];

        $records = Account::where('account_dpe_intranet_id', '=', $userMail)
            ->orWhere('tt_focal_intranet_id', '=', $userMail)
            ->orderBy('name', 'asc')
            ->get();

        $data = array(
            'records' => $records
        );

        return view('components.checklist.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin(Request $request)
    {
        // $this->authorize('viewAnyAdmin', Checklist::class);

        $records = Account::orderBy('name', 'asc')
            ->get();

        $data = array(
            'records' => $records
        );

        return view('components.checklist.admin-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $model = new Checklist();

        $data = array(
            'record' => $model
        );

        return view('components.checklist.create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Checklist $checklist
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Checklist $checklist)
    {
        $data = array(
            'record' => $checklist
        );

        return view('components.checklist.edit', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceOverview(Request $request)
    {
        // $this->authorize('serviceOverview', Checklist::class);

        // Get the currently authenticated user...
        $user = Auth::user();
        $userMail = $user->mail[0];

        $records = Account::where('account_dpe_intranet_id', '=', $userMail)
            ->orWhere('tt_focal_intranet_id', '=', $userMail)
            ->orderBy('name', 'asc')
            ->get();

        $data = array(
            'records' => $records
        );

        return view('components.checklist.service-overview-account', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceOverviewAdmin(Request $request)
    {
        // $this->authorize('serviceOverviewAdmin', Checklist::class);

        $records = Account::orderBy('name', 'asc')
            ->get();

        $data = array(
            'records' => $records
        );

        return view('components.checklist.admin-service-overview-account', $data);
    }

    public function serviceOverviewExport(Checklist $checklist)
    {
        $mainCategoriesData = $this->mainCategoriesService->prepareMainCategories($checklist);
        list(
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        $fileName = 'servicesOverview.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Name', 'Transition State', 'Go Live Date', 'Account DPE', 'TT Focal', 'Created At', 'Updated At', 'Created By');

        $records = $mainCategories;
        $resourceCollection = new ChecklistCollection($records);

        $callback = function() use($resourceCollection, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resourceCollection as $resource) {
                fputcsv($file, array(
                    $resource->id,
                    $resource->parent_id,
                    $resource->name,
                    $resource->created_at,
                    $resource->updated_at,
                    $resource->sequence,
                    $resource->pivot_id,
                    $resource->status,
                    $resource->in_scope,
                ));

                // fputcsv($file, (array) $resource);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function pendingExport(Checklist $checklist)
    {
        // load required relations
        $checklist->load('inScopeNo');

        $pendingServices = $checklist->inScopeNo;

        $fileName = 'pendingItems.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Name', 'Transition State', 'Go Live Date', 'Account DPE', 'TT Focal', 'Created At', 'Updated At', 'Created By');

        $records = $pendingServices;
        $resourceCollection = new ChecklistCollection($records);

        $callback = function() use($resourceCollection, $columns) {

            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resourceCollection as $resource) {
                fputcsv($file, array(
                    $resource->id,
                    $resource->category_id,
                    $resource->section_id,
                    $resource->name,
                    $resource->created_at,
                    $resource->updated_at,
                ));

                // fputcsv($file, (array) $resource);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checklistForAccount(Account $account)
    {
        $data = array(
            'record' => $account,
            'records' => $account->checklists,
            'types' => ServiceCategory::TYPES
        );

        return view('components.checklist.account-checklist-overview', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checklistForAccountAdmin(Account $account)
    {
        $data = array(
            'record' => $account,
            'records' => $account->checklists,
            'types' => ServiceCategory::TYPES
        );

        return view('components.checklist.account-checklist-overview', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceOverviewForChecklist(Checklist $checklist, Request $request)
    {
        // $this->authorize('serviceOverviewForChecklist', $checklist);

        $mainCategoriesData = $this->mainCategoriesService->prepareMainCategories($checklist);
        list(
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        $data = array(
            'types' => ServiceCategory::TYPES,
            'record' => $checklist,
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        );

        return view('components.checklist.category-overview', $data);
    }

    public function serviceOverviewForChecklistExport(Checklist $checklist)
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function serviceOverviewForChecklistAdmin(Checklist $checklist)
    {
        // $this->authorize('serviceOverviewForChecklistAdmin', $checklist);

        $mainCategoriesData = $this->mainCategoriesService->prepareMainCategories($checklist);
        list(
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        $data = array(
            'types' => ServiceCategory::TYPES,
            'record' => $checklist,
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        );

        return view('components.checklist.admin-category-overview', $data);
    }

    public function serviceOverviewForChecklistExportAdmin(Checklist $checklist)
    {

    }

    public function exportList()
    {
        $fileName = 'checklists.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Name', 'Transition State', 'Go Live Date', 'Account DPE', 'TT Focal', 'Created At', 'Updated At', 'Created By');

        $records = Checklist::all();
        $resourceCollection = new ChecklistCollection($records);

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

    public function servicesList(Checklist $checklist, ServiceCategory $category)
    {
        // $this->authorize('serviceOverviewForChecklistAdmin', $checklist);

        $mainCategoriesData = $this->mainCategoriesService->prepareMainCategories($checklist);
        list(
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        $data = array(
            'types' => ServiceCategory::TYPES,
            'record' => $checklist,
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        );

        return view('components.checklist.admin-category-overview', $data);
    }
}

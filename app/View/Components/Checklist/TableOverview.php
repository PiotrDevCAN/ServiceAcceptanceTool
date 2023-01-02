<?php

namespace App\View\Components\Checklist;

use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\Component;

class TableOverview extends Component
{
    public $name;
    public $record;
    public $records;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $checklistId = $record->id;
        $mainCategories = ServiceCategory::with(['services', 'checklists'])
            ->with(['checklists' => function ($query) use($checklistId) {
                $query->where('checklist_categories.checklist_id', $checklistId);
            }])
            ->whereType($record->type)
            ->orderBy('sequence', 'asc')
            ->get();

        // an existing checklist should have assigned categories
        $checklistCategories = $record->categories;

        // an existing checklist should have assigned services
        $checklistServices = $record->services;

        // check if a specific main category is assigned to current checklist
        $mainCategories->each(function ($mainCategory, $key) use ($checklistCategories) {

            if ($checklistCategories->contains($mainCategory)) {
                // dump('object found');
                $checklistCategory = $checklistCategories->find($mainCategory);
                $mainCategory->pivot_id = $checklistCategory->pivot->id;
                $mainCategory->status = $checklistCategory->pivot->status;
                $mainCategory->in_scope = $checklistCategory->pivot->in_scope;
            } else {
                // dump('object not found');
                $mainCategory->pivot_id = '';
                $mainCategory->status = ServiceCategory::STATUS_NOT_COMPLETE;
                $mainCategory->in_scope = ServiceCategory::IN_SCOPE_NO;
            }
        });

        // check if a specific main category is assigned to current checklist
        $mainCategories->each(function ($mainCategory, $key) use ($checklistServices) {

            $mainCategoryServices = $mainCategory->services;
            $mainCategoryServices->each(function ($mainCategoryService, $key) use ($checklistServices) {

                if ($checklistServices->contains($mainCategoryService)) {
                    // dump('object found');
                    $checklistCategoryService = $checklistServices->find($mainCategoryService);
                    $mainCategoryService->pivot_id = $checklistCategoryService->pivot->id;
                    $mainCategoryService->status = $checklistCategoryService->pivot->status;
                    $mainCategoryService->evidence = $checklistCategoryService->pivot->evidence;
                    $mainCategoryService->completition_date = $checklistCategoryService->pivot->completition_date;
                    $mainCategoryService->user_input = $checklistCategoryService->pivot->user_input;
                } else {
                    // dump('object not found');
                    $mainCategoryService->pivot_id = '';
                    $mainCategoryService->status = Service::IN_SCOPE_NO;
                    $mainCategoryService->evidence = '';
                    $mainCategoryService->completition_date = '';
                    $mainCategoryService->user_input = '';
                }

            });
        });

        $this->name = 'servicesOverviewTable';
        $this->record = $record;
        $this->records = $mainCategories;
        $this->checklistCategories = $checklistCategories;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.table-overview');
    }
}

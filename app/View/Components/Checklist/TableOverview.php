<?php

namespace App\View\Components\Checklist;

use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Services\MainCategoriesService;
use Illuminate\View\Component;

class TableOverview extends Component
{
    public $name;
    public $record;
    public $records;
    public $checklistCategories;
    public $checklistServices;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record, MainCategoriesService $mainCategoriesService)
    {
        $mainCategoriesData = $mainCategoriesService->prepareMainCategories($record);
        list(
            'checklistCategories' => $checklistCategories,
            'checklistServices' => $checklistServices,
            'mainCategories' => $mainCategories
        ) = $mainCategoriesData;

        $this->name = 'servicesOverviewTable';
        $this->record = $record;
        $this->records = $mainCategories;
        $this->checklistCategories = $checklistCategories;
        $this->checklistServices = $checklistServices;
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

<?php

namespace App\View\Components\Checklist;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\Component;

class AccountStatus extends Component
{
    public $record;
    public $mainCategoriesCalculation;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $mainCategoriesCalculation = ServiceCategory

        // ::with(['services', 'checklists'])
        // ->with(['checklists' => function ($query) use($checklistId) {
            // $query->where('checklist_categories.checklist_id', $checklistId);
        // }])

        // ->with([
        //     'checklists as related_checklists' => function ($query) use($checklistId) {
        //     $query->where('checklist_categories.checklist_id', $checklistId);
        // }])

        ::withCount([
            'services as services_completed' => function (Builder $query) use ($record) {
                $query->join('checklist_services', 'checklist_services.service_id', '=', 'services.id');
                $query->where('checklist_services.status', Service::IN_SCOPE_YES);
                $query->where('checklist_services.checklist_id', $record->id);
            },
            'services as services_not_completed' => function (Builder $query) use ($record) {
                $query->join('checklist_services', 'checklist_services.service_id', '=', 'services.id');
                $query->where('checklist_services.status', Service::IN_SCOPE_NO);
                $query->where('checklist_services.checklist_id', $record->id);
            },
            'services as services_not_in_scope' => function (Builder $query) use ($record) {
                $query->join('checklist_services', 'checklist_services.service_id', '=', 'services.id');
                $query->where('checklist_services.status', Service::IN_SCOPE_NOT_IN_SCOPE);
                $query->where('checklist_services.checklist_id', $record->id);
            }
        ])
        ->whereType($record->type)
        ->orderBy('sequence', 'asc')
        ->get();

        // load required relations
        if (!empty($record->id)) {
            $record->loadCount('inScopeNo', 'inScopeYes', 'notInScope');
        }

        $this->record = $record;
        $this->mainCategoriesCalculation = $mainCategoriesCalculation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.account-status');
    }
}

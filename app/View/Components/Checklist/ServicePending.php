<?php

namespace App\View\Components\Checklist;

use App\Models\Account;
use App\Models\Checklist;
use Illuminate\View\Component;

class ServicePending extends Component
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
        $pendingServices = $record->inScopeNo;

        $this->name = 'pendingServicesTable';
        $this->record = $record;
        $this->records = $pendingServices;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.service-pending');
    }
}

<?php

namespace App\View\Components\Checklist;

use App\Models\ServiceCategory;
use Illuminate\View\Component;

class ServiceOverview extends Component
{
    public $name;
    public $records;
    public $types;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->name = 'servicesTable_'.$record->id;
        $this->records = $record->services;
        $this->types = ServiceCategory::TYPES;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.service-overview');
    }
}

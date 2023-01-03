<?php

namespace App\View\Components\Checklist;

use Illuminate\View\Component;

class CategoryOverview extends Component
{
    public $name;
    public $records;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->name = 'servicesTable_'.$record->id;
        $this->records = $record->services;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.category-overview');
    }
}

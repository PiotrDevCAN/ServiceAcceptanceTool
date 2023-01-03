<?php

namespace App\View\Components\Checklist;

use Illuminate\View\Component;
use App\Models\ServiceCategory;

class ChecklistFormCard extends Component
{
    public $record;
    public $types;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->record = $record;
        $this->types = ServiceCategory::TYPES;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.checklist-form-card');
    }
}

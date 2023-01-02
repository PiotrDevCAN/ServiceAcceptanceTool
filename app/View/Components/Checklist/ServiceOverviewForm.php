<?php

namespace App\View\Components\Checklist;

use App\Models\Account;
use App\Models\Checklist;
use Illuminate\View\Component;

class ServiceOverviewForm extends Component
{
    public $name;
    public $record;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record)
    {
        $this->name = 'categoryForm';
        $this->record = $record;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.service-overview-form');
    }
}

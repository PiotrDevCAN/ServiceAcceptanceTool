<?php

namespace App\View\Components\Checklist;

use Illuminate\View\Component;

class AccountForm extends Component
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
        $this->name = 'checklistAccountForm';
        $this->record = $record;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.account-form');
    }
}

<?php

namespace App\View\Components\Account;

use App\Models\Account;
use Illuminate\View\Component;

class Form extends Component
{
    public $name;
    public $record;
    public $states;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $record)
    {
        $this->name = $name;
        $this->record = $record;
        $this->states = Account::STATES;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.account.form');
    }
}

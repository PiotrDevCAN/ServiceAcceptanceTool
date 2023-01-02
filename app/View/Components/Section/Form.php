<?php

namespace App\View\Components\Section;

use Illuminate\View\Component;

class Form extends Component
{
    public $name;
    public $record;

    /**
     * Create the component instance.
     *
     * @param  string  $name
     * @param  string  $record
     * @return void
     */
    public function __construct($name, $record)
    {
        $this->name = $name;
        $this->record = $record;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.section.form');
    }
}

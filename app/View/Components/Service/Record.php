<?php

namespace App\View\Components\Service;

use Illuminate\View\Component;

class Record extends Component
{
    public $record;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record = null)
    {
        $this->record = $record;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.service.record');
    }
}

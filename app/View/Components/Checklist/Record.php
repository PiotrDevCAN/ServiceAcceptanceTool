<?php

namespace App\View\Components\Checklist;

use App\Models\Checklist;
use Illuminate\View\Component;

class Record extends Component
{
    public $categories;
    public $record;
    public $newRecord;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($record = null)
    {
        $this->record = $record;

        $newRecord = new Checklist();
        $newRecord->id = 'new';
        $this->newRecord = $newRecord;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.record');
    }
}

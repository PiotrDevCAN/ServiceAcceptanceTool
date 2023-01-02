<?php

namespace App\View\Components\Checklist;

use App\Models\Account;
use App\Models\Checklist;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\View\Component;

class TableShowHide extends Component
{
    public $name;
    public $record;
    public $records;
    public $types;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $records)
    {
        $this->name = $name;
        $this->records = $records;
        $this->types = ServiceCategory::TYPES;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checklist.table-show-hide');
    }
}

<?php

namespace App\View\Components\Service;

use App\Models\ServiceCategory;
use App\Models\ServiceSection;
use Illuminate\View\Component;

class Form extends Component
{
    public $name;
    public $record;
    public $categories;
    public $sections;

    /**
     * Create the component instance.
     *
     * @param  string  $name
     * @param  string  $record
     * @return void
     */
    public function __construct($name, $record)
    {
        $categories = ServiceCategory::all();
        $sections = ServiceSection::all();

        $this->name = $name;
        $this->record = $record;
        $this->categories = $categories;
        $this->sections = $sections;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.service.form');
    }
}

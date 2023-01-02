<?php

namespace App\View\Components\Category;

use App\Models\ServiceCategory;
use Illuminate\View\Component;

class Form extends Component
{
    public $name;
    public $record;
    public $categories;
    public $types;

    /**
     * Create the component instance.
     *
     * @param  string  $name
     * @param  string  $records
     * @return void
     */
    public function __construct($name, $record)
    {
        $categories = ServiceCategory::with(['parent', 'children'])->get();

        $this->name = $name;
        $this->record = $record;
        $this->categories = $categories;
        $this->types = ServiceCategory::TYPES;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.category.form');
    }
}

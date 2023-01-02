<?php

namespace App\View\Components\IbmV18Form;

use Illuminate\View\Component;

class Input extends Component
{
    public $fieldName;
    public $label;
    public $selectedValue;
    public $disabled;
    public $readonly;
    public $required;
    public $placeholder;
    public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($fieldName = null, $label = null, $value = null, $disabled = false, $readonly = false, $required = false, $placeholder = null)
    {
        $this->fieldName = $fieldName;
        $this->label = $label;
        $this->selectedValue = $value;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->options = array(
            // 'size' => '40',
            'id' => $fieldName,
            'class' => 'ibm-fullwidth',
            'placeholder' => $placeholder,
            'disabled' => $disabled,
            'readonly' => $readonly,
            'required' => $required
        );

        // dump($this);

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ibmv18form.input');
    }
}

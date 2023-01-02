<?php

namespace App\View\Components\IbmV18Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public $fieldName;
    public $label;
    public $value;
    public $disabled;
    public $readonly;
    public $required;
    public $placeholder;
    public $options;
    public $labelOptions;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldName = null, $label = null, $value = null, $disabled = false, $readonly = false, $required = false, $placeholder = null)
    {
        $this->fieldName = $fieldName;
        $this->label = $label;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->readonly = $readonly;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->options = array(
            'rows' => '20',
            'cols' => '100',
            'class' => 'form-control',
            'id' => $fieldName,
            'maxLength' => '500',
            'placeholder' => $placeholder,
            'disabled' => $disabled,
            'readonly' => $readonly,
            'required' => $required
        );
        $this->labelOptions = array(
            'class' => 'ibm-column-field-label'
        );
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.ibmv18form.textarea');
    }
}

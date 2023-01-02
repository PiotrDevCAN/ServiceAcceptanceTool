{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            @include('components.form-direct-link')

            <x-ibmv18form-input field-name="section" label="Section" :value="$record->name" required="required"/>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Create the Section.</b></p>
    @include('components.form-buttons')

{{ Form::close() }}

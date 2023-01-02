{{ Form::open(['route' => [Route::currentRouteName(), $record], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            <input type="hidden" id="status" name="status" value="{{ $record->status }}"/>
            <input type="hidden" id="type" name="type" value="{{ $record->type }}"/>
            <input type="hidden" id="created_by" name="created_by" value="{{ $record->created_by }}"/>

            @include('components.form-direct-link')

            <p>
                <label for="employee">Employee <span class="ibm-required">*</span></label>
                <span>
                    <input type='text' id='employee' name='employee_notes_id' class='typeaheadNew ibm-fullwidth' value='{{ $record->employee_notes_id }}' autocomplete='off' placeholder='Start typing a name to perform a lookup' rrequired="required"/>
                </span>
            </p>
            <input type="hidden" id="employee_name" name="employee" value="{{ $record->employee }}"/>
            <input type="hidden" id="employee_intranet_id" name="employee_intranet_id" value="{{ $record->employee_intranet_id }}"/>


        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Grant the Access.</b></p>
    {{-- @empty($record->id)
        @include('components.form-buttons')
    @else --}}
        @include('components.access.form-buttons')
    {{-- @endempty --}}

{{ Form::close() }}

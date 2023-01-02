{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            <input type="hidden" id="sequence" name="sequence" value="{{ $record->sequence }}"/>

            @include('components.form-direct-link')

            <p class='ibm-form-elem-grp' id='PARENT_IDFormGroup'>
                <label for='parent_id'>Parent Category <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='parent_id'
                        id='parent_id'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    @foreach ($categories as $key => $value)
                        <option value='{{ $value->id }}' {{ $record->parent_id == $value->id ? 'selected="selected"' : '' }}>{{ $value->name }}</option>
                    @endforeach
                    </select>
                </span>
            </p>

            <x-ibmv18form-input field-name="category" label="Category" :value="$record->name" required="required"/>

            <p class='ibm-form-elem-grp' id='TYPEFormGroup'>
                <label for='type'>Type <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='type'
                        id='type'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    @foreach ($types as $key => $value)
                        <option value='{{ $value['type'] }}' {{ $record->type == $value['type'] ? 'selected="selected"' : '' }}>{{ $value['name'] }}</option>
                    @endforeach
                    </select>
                </span>
            </p>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Create the Category.</b></p>
    @include('components.form-buttons')

{{ Form::close() }}

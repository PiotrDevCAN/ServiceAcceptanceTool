{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            @include('components.form-direct-link')

            <p class='ibm-form-elem-grp' id='CATEGORY_IDFormGroup'>
                <label for='category_id'>Category <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='category_id'
                        id='category_id'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    @foreach ($categories as $key => $value)
                        <option value='{{ $value->id }}' {{ $record->category_id == $value->id ? 'selected="selected"' : '' }}>{{ $value->name }}</option>
                    @endforeach
                    </select>
                </span>
            </p>

            <p class='ibm-form-elem-grp' id='SECTION_IDFormGroup'>
                <label for='section_id'>Section <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='section_id'
                        id='section_id'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    @foreach ($sections as $key => $value)
                        <option value='{{ $value->id }}' {{ $record->section_id == $value->id ? 'selected="selected"' : '' }}>{{ $value->name }}</option>
                    @endforeach
                    </select>
                </span>
            </p>

            <x-ibmv18form-textarea field-name="service" label="Question" :value="$record->name" required="required"/>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>

    <p><b>Click Save to Create the Service.</b></p>
    @include('components.form-buttons')

{{ Form::close() }}

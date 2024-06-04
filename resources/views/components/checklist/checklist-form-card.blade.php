@isset($record->account)
    <div class="ibm-card">
        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
            <input type="hidden" id="checklist_id" name="checklist_id" value="{{ $record->id }}"/>
            <input type="hidden" id="created_by" name="created_by" value="{{ $record->created_by }}"/>

            <x-ibmv18form-input field-name="checklist_name" label="Checklist Name" :value="$record->name" required="required"/>

            <p class='ibm-form-elem-grp' id='CHECKLIST_TYPEFormGroup'>
                <label for='checklist_type'>Checklist Type <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='checklist_type'
                        id='checklist_type'
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
            <input type="hidden" id="checklist_type_old" name="checklist_type_old" value="{{ $record->type }}"/>
        </div>
    </div>
@else
    <div class="ibm-card">
        <div class="ibm-card__content ibm-padding-bottom-0 ibm-padding-border-left">
            <input type="hidden" id="checklist_id" name="checklist_id" value=""/>
            <input type="hidden" id="created_by" name="created_by" value=""/>

            <x-ibmv18form-input field-name="checklist_name" label="Checklist Name" :value="$record->name" required="required"/>

            <p class='ibm-form-elem-grp' id='CHECKLIST_TYPEFormGroup'>
                <label for='checklist_type'>Checklist Type <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='checklist_type'
                        id='checklist_type'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    @foreach ($types as $key => $value)
                        <option value='{{ $value['type'] }}'>{{ $value['name'] }}</option>
                    @endforeach
                    </select>
                </span>
            </p>
            <input type="hidden" id="checklist_type_old" name="checklist_type_old" value="{{ $record->type }}"/>
        </div>
    </div>
@endif

{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            <input type="hidden" id="service_id" name="service_id" value=""/>
            <input type="hidden" id="checklist_id" name="checklist_id" value=""/>

            <x-ibmv18form-input field-name="parent_category" label="Parent Category" value="" required="required" readonly="readonly" disabled="disabled"/>
            <x-ibmv18form-input field-name="category" label="Category" value="" required="required" readonly="readonly" disabled="disabled"/>
            <x-ibmv18form-input field-name="section" label="Section" value="" required="required" readonly="readonly" disabled="disabled"/>

            <x-ibmv18form-textarea field-name="service" label="Question" value="" required="required" readonly="readonly"/>

            <p class='ibm-form-elem-grp' id='STATUSFormGroup'>
                <label for='status'>Status <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='status'
                        id='status'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    <option value='Yes'>Yes</option>
                    <option value='No'>No</option>
                    <option value='Not in scope'>Not in scope</option>
                    </select>
                </span>
            </p>

            <x-ibmv18form-textarea field-name="evidence" label="Evidence" value=""/>
            <x-ibmv18form-textarea field-name="user_input" label="Additional Input" value=""/>

            <p>
                <label for="owner">Owner</label>
                <span>
                    <input type='text' id='owner' name='owner_notes_id' class='typeaheadNew ibm-fullwidth' value='' autocomplete='off' placeholder='Start typing a name to perform a lookup'/>
                </span>
            </p>
            <input type="hidden" id="owner_name" name="owner" value=""/>
            <input type="hidden" id="owner_intranet_id" name="owner_intranet_id" value=""/>

            <p class='ibm-form-elem-grp' id='completition_dateFormGroup'>
                <label for="completition_date">Completion Date</label>
                <span>
                    <input data-format="yyyy-mm-dd" type="text" value="" size="20" id="completition_date" name="completition_date">
                </span>
            </p>
        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="saveRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Save</a>
        <a id="updateRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
        <a href="javascript:;" id='closeEditServiceModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('editServiceModal', true);">Close</a>
    </p>
{{ Form::close() }}

{{ Form::open(['route' => [Route::currentRouteName(), $record->id], 'id' => $name, 'class'  => 'ibm-column-form' ]) }}
    <div class="ibm-fluid">
        <div class="ibm-col-12-12">
            @empty($record->id)
                <input type="hidden" id="id" name="id" value=""/>
            @else
                <input type="hidden" id="id" name="id" value="{{ $record->id }}"/>
            @endempty

            <input type="hidden" id="category_id" name="category_id" value=""/>
            <input type="hidden" id="checklist_id" name="checklist_id" value=""/>

            <x-ibmv18form-input field-name="category" label="Category" :value="$record->name" readonly="readonly" disabled="disabled"/>

            <p class='ibm-form-elem-grp' id='IN_SCOPEFormGroup'>
                <label for='in_scope'>In Scope <span class="ibm-required">*</span></label>
                <span>
                    <select
                        class='ibm-fullwidth'
                        name='in_scope'
                        id='in_scope'
                        required='required'
                        data-tags="true"
                        data-allow-clear="true"
                    >
                    <option value=''>Select</option>
                    <option value='Yes'>Yes</option>
                    <option value='No'>No</option>
                    </select>
                </span>
            </p>

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
                    <option value='Complete'>Complete</option>
                    <option value='Not Complete'>Not Complete</option>
                    </select>
                </span>
            </p>

        </div>
    </div>
    <div class="ibm-rule ibm-alternate ibm-red-50"><hr></div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="saveRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Save</a>
        <a id="updateRecord" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
        <a href="javascript:;" id='closeEditCategoryModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('editCategoryModal', true);">Close</a>
    </p>
{{ Form::close() }}

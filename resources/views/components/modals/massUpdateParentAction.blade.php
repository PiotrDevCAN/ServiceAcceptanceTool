<div class="ibm-common-overlay ibm-overlay-alt" data-widget="overlay" id="massUpdateParentActionModal">
    <h2 class="ibm-bold">Mass Update Action Parent Category</h2>
    <div id='massUpdateParentActionContent' class='ibm-padding-bottom-1'>
        <div class="msgBox"></div>
        <form class="ibm-column-form">
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
                        <option value='{{ $value->id }}'>{{ $value->name }}
                        (@switch($value->type)
                            @case('T&T_NO')
                                Non T&T
                                @break
                            @case('T&T_YES')
                                T&T
                                @break
                            @default
                        @endswitch)
                        </option>
                    @endforeach
                    </select>
                </span>
            </p>
        </form>
    </div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="performActionUpdateParent" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
        <a href="javascript:;" id='closeMassUpdateParentActionModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('massUpdateParentActionModal', true);">Close</a>
    </p>
</div>

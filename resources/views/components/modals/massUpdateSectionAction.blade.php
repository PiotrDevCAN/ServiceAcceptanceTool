<div class="ibm-common-overlay ibm-overlay-alt" data-widget="overlay" id="massUpdateSectionActionModal">
    <h2 class="ibm-bold">Mass Update Action Section</h2>
    <div id='massUpdateSectionActionModalContent' class='ibm-padding-bottom-1'>
        <div class="msgBox"></div>
        <form class="ibm-column-form">
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
                        <option value='{{ $value->id }}'>{{ $value->name }}</option>
                    @endforeach
                    </select>
                </span>
            </p>
        </form>
    </div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="performActionUpdateSection" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
        <a href="javascript:;" id='closeMassUpdateSectionActionModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('massUpdateSectionActionModal', true);">Close</a>
    </p>
</div>

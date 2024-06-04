<div class="ibm-common-overlay ibm-overlay-alt" data-widget="overlay" id="massUpdateTTTypeActionModal">
    <h2 class="ibm-bold">Mass Update Action TT Type</h2>
    <div id='massUpdateTTTypeActionModalContent' class='ibm-padding-bottom-1'>
        <div class="msgBox"></div>
        <form class="ibm-column-form">
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
                        <option value='{{ $value['type'] }}'>{{ $value['name'] }}</option>
                    @endforeach
                    </select>
                </span>
            </p>
        </form>
    </div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="performActionUpdateTTType" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
        <a href="javascript:;" id='closeMassUpdateTTTypeActionModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('massUpdateTTTypeActionModal', true);">Close</a>
    </p>
</div>

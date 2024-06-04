<div class="ibm-common-overlay ibm-overlay-alt" data-widget="overlay" id="massUpdateCategoryActionModal">
    <h2 class="ibm-bold">Mass Update Action Category</h2>
    <div id='massUpdateCategoryActionModalContent' class='ibm-padding-bottom-1'>
        <div class="msgBox"></div>
        <form class="ibm-column-form">
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
                        <option value='{{ $value->id }}'>{{ $value->name }}</option>
                    @endforeach
                    </select>
                </span>
            </p>
        </form>
    </div>
    <p class="ibm-btn-row ibm-ind-link">
        <a id="performActionUpdateCategory" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">Update</a>
        <a href="javascript:;" id='closeMassUpdateCategoryActionModal' class="ibm-close-link ibm-btn-sec ibm-btn-red-50" onclick="IBMCore.common.widget.overlay.hide('massUpdateCategoryActionModal', true);">Close</a>
    </p>
</div>

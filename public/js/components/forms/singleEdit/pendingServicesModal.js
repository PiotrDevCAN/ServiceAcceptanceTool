/*
 *
 *
 *
 */

let datePickerOptions = await cacheBustImport('../addons/datePickerOptions.js');
let textAreaOptions = await cacheBustImport('../addons/textAreaOptions.js');
let initialiseFacesTypeAheadOnForm = await cacheBustImport('../addons/facesType.js');

let getServicesSummary = await cacheBustImport('../addons/getServicesSummary.js');
let getServicesByCategoryList = await cacheBustImport('../addons/getServicesByCategoryList.js');
let getServicesList = await cacheBustImport('../addons/getServicesList.js');
let editModal = await cacheBustImport('../forms/editModal.js');

class pendingServicesModal extends editModal {

    static formId = '#serviceForm';
    static checklistFormId = 'checklistAccountForm';
    static type = 'checklist-service';
    static rootType = 'service';
    static modalId = 'editServiceModal';

    constructor() {
        console.log('+++ Function +++ pendingServicesModal.constructor');

        super(pendingServicesModal);

        console.log('--- Function --- pendingServicesModal.constructor');
    }

    beforeActions(data) {
        console.log("Remove tinyMCE");
        tinymce.remove();
    }

    additionalActions(data) {
        IBMCore.common.widget.datepicker.init("#completition_date", datePickerOptions);
    }

    afterActions(data) {
        console.log("Initialise tinyMCE");
        tinymce.init(textAreaOptions);

        initialiseFacesTypeAheadOnForm("serviceForm");
    }

    afterSaveActions(data) {

        console.log('DATAAA_PENDING_SERVICES');
        console.log(this.recordData);

        var checklistId = $('#checklist_id').val();
        var categoryId = this.recordData.category_id;
        if (typeof (categoryId) !== 'undefined') {
            getServicesSummary(checklistId, categoryId);
            getServicesByCategoryList(checklistId, categoryId);
        } else {
            getServicesList(checklistId);
        }

        // hide the overlay
        IBMCore.common.widget.overlay.hide(pendingServicesModal.modalId, true);
    }

    populateRecordData(data) {

        $('#' + pendingServicesModal.modalId + ' #id').val(data.id);
        $('#' + pendingServicesModal.modalId + ' #service_id').val(data.service_id);
        $('#' + pendingServicesModal.modalId + ' #checklist_id').val(data.checklist_id);

        $('#' + pendingServicesModal.modalId + ' #parent_category').val(data.service.category.parent.name);
        $('#' + pendingServicesModal.modalId + ' #category').val(data.service.category.name);
        $('#' + pendingServicesModal.modalId + ' #section').val(data.service.section.name);
        $('#' + pendingServicesModal.modalId + ' #service').val(data.service.name);

        $('#' + pendingServicesModal.modalId + ' #evidence').val(data.evidence);
        $('#' + pendingServicesModal.modalId + ' #user_input').val(data.user_input);

        $('#' + pendingServicesModal.modalId + ' #owner').val(data.owner);
        $('#' + pendingServicesModal.modalId + ' #owner_name').val(data.owner_notes_id);
        $('#' + pendingServicesModal.modalId + ' #owner_intranet_id').val(data.owner_intranet_id);

        $('#' + pendingServicesModal.modalId + ' #completition_date').val(data.completition_date);
        $('#' + pendingServicesModal.modalId + ' #status').select2().val(data.status).trigger("change");
    }

    populateRecordRootData(data) {

        $('#' + pendingServicesModal.modalId + ' #id').val('');
        $('#' + pendingServicesModal.modalId + ' #service_id').val(data.id);
        var checklistId = $('#' + pendingServicesModal.checklistFormId + ' #checklist_id').val();
        $('#' + pendingServicesModal.modalId + ' #checklist_id').val(checklistId);

        $('#' + pendingServicesModal.modalId + ' #parent_category').val(data.category.parent.name);
        $('#' + pendingServicesModal.modalId + ' #category').val(data.category.name);
        $('#' + pendingServicesModal.modalId + ' #section').val(data.section.name);
        $('#' + pendingServicesModal.modalId + ' #service').val(data.name);

        $('#' + pendingServicesModal.modalId + ' #evidence').val('');
        $('#' + pendingServicesModal.modalId + ' #user_input').val('');

        $('#' + pendingServicesModal.modalId + ' #owner').val('');
        $('#' + pendingServicesModal.modalId + ' #owner_name').val('');
        $('#' + pendingServicesModal.modalId + ' #owner_intranet_id').val('');

        $('#' + pendingServicesModal.modalId + ' #completition_date').val('');
        $('#' + pendingServicesModal.modalId + ' #status').select2().val('Not in scope').trigger("change");
    }
}

const PendingServicesModal = new pendingServicesModal();

export { PendingServicesModal as default };

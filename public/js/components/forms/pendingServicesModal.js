/*
 *
 *
 *
 */

import datePickerOptions from "../addons/datePickerOptions.js";
import textAreaOptions from "../addons/textAreaOptions.js";
import editModal from "./editModal.js";

class pendingServicesModal extends editModal {

    static formId = '#serviceForm';
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

    populateRecordData(data) {
        $('#' + pendingServicesModal.modalId + ' #id').val(data.id);
        $('#' + pendingServicesModal.modalId + ' #service_id').val(data.service_id);
        $('#' + pendingServicesModal.modalId + ' #checklist_id').val(data.checklist_id);

        $('#' + pendingServicesModal.modalId + ' #category').val(data.service.category.name);
        $('#' + pendingServicesModal.modalId + ' #section').val(data.service.section.name);
        $('#' + pendingServicesModal.modalId + ' #service').val(data.service.name);

        $('#' + pendingServicesModal.modalId + ' #evidence').val(data.evidence);
        $('#' + pendingServicesModal.modalId + ' #user_input').val(data.user_input);

        $('#' + pendingServicesModal.modalId + ' #owner').val('TBD');
        $('#' + pendingServicesModal.modalId + ' #completition_date').val(data.completition_date);
        $('#' + pendingServicesModal.modalId + ' #status').select2().val(data.status).trigger("change");
    }

    populateRecordRootData(data) {

        $('#' + pendingServicesModal.modalId + ' #id').val('');
        $('#' + pendingServicesModal.modalId + ' #service_id').val(data.id);
        var checklistId = $('#accountForm #checklist_id').val();
        $('#' + pendingServicesModal.modalId + ' #checklist_id').val(checklistId);

        $('#' + pendingServicesModal.modalId + ' #category').val(data.category.name);
        $('#' + pendingServicesModal.modalId + ' #section').val(data.section.name);
        $('#' + pendingServicesModal.modalId + ' #service').val(data.name);

        $('#' + pendingServicesModal.modalId + ' #evidence').val('');
        $('#' + pendingServicesModal.modalId + ' #user_input').val('');

        $('#' + pendingServicesModal.modalId + ' #owner').val('TBD');
        $('#' + pendingServicesModal.modalId + ' #completition_date').val('');
        $('#' + pendingServicesModal.modalId + ' #status').select2().val('Not in scope').trigger("change");
    }

    additionalActions(data) {
        IBMCore.common.widget.datepicker.init("#completition_date", datePickerOptions);
    }

    afterActions(data) {
        console.log("Initialise tinyMCE");
        tinymce.init(textAreaOptions);
    }
}

const PendingServicesModal = new pendingServicesModal();

export { PendingServicesModal as default };

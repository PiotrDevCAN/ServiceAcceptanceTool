/*
 *
 *
 *
 */

import editModal from "./editModal.js";

class servicesOverviewModal extends editModal {

    static formId = '#categoryForm';
    static type = 'checklist-category';
    static rootType = 'category';
    static modalId = 'editCategoryModal';

    constructor() {
        console.log('+++ Function +++ servicesOverviewModal.constructor');

        super(servicesOverviewModal);

        console.log('--- Function --- servicesOverviewModal.constructor');
    }

    populateRecordData(data) {

        $('#' + servicesOverviewModal.modalId + ' #id').val(data.id);
        $('#' + servicesOverviewModal.modalId + ' #category_id').val(data.category_id);
        $('#' + servicesOverviewModal.modalId + ' #checklist_id').val(data.checklist_id);

        $('#' + servicesOverviewModal.modalId + ' #category').val(data.category.name);
        $('#' + servicesOverviewModal.modalId + ' #in_scope').select2().val(data.in_scope).trigger("change");
        $('#' + servicesOverviewModal.modalId + ' #status').select2().val(data.status).trigger("change");
    }

    populateRecordRootData(data) {

        $('#' + servicesOverviewModal.modalId + ' #id').val('');
        $('#' + servicesOverviewModal.modalId + ' #category_id').val(data.id);
        var checklistId = $('#accountForm #checklist_id').val();
        $('#' + servicesOverviewModal.modalId + ' #checklist_id').val(checklistId);

        $('#' + servicesOverviewModal.modalId + ' #category').val(data.name);
        $('#' + servicesOverviewModal.modalId + ' #in_scope').select2().val('No').trigger("change");
        $('#' + servicesOverviewModal.modalId + ' #status').select2().val('Not Complete').trigger("change");
    }

    additionalActions(data) {

    }
}

const ServicesOverviewModal = new servicesOverviewModal();

export { ServicesOverviewModal as default };

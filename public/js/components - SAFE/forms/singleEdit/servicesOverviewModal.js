/*
 *
 *
 *
 */

let getCategoriesList = await cacheBustImport('../addons/getCategoriesList.js');
let editModal = await cacheBustImport('../forms/editModal.js');

class servicesOverviewModal extends editModal {

    static formId = '#categoryForm';
    static checklistFormId = 'checklistAccountForm';
    static type = 'checklist-category';
    static rootType = 'category';
    static modalId = 'editCategoryModal';

    constructor() {
        console.log('+++ Function +++ servicesOverviewModal.constructor');

        super(servicesOverviewModal);

        console.log('--- Function --- servicesOverviewModal.constructor');
    }

    afterSaveActions(data) {
        var checklistId = $('#checklist_id').val();
        getCategoriesList(checklistId);

        // hide the overlay
        IBMCore.common.widget.overlay.hide(servicesOverviewModal.modalId, true);
    }

    populateRecordData(data) {

        $('#' + servicesOverviewModal.modalId + ' #id').val(data.id);
        $('#' + servicesOverviewModal.modalId + ' #category_id').val(data.category_id);
        $('#' + servicesOverviewModal.modalId + ' #checklist_id').val(data.checklist_id);

        $('#' + servicesOverviewModal.modalId + ' #parent_category').val(data.category.parent.name);
        $('#' + servicesOverviewModal.modalId + ' #category').val(data.category.name);
        $('#' + servicesOverviewModal.modalId + ' #in_scope').select2().val(data.in_scope).trigger("change");
        $('#' + servicesOverviewModal.modalId + ' #status').select2().val(data.status).trigger("change");
    }

    populateRecordRootData(data) {

        $('#' + servicesOverviewModal.modalId + ' #id').val('');
        $('#' + servicesOverviewModal.modalId + ' #category_id').val(data.id);
        var checklistId = $('#' + servicesOverviewModal.checklistFormId + ' #checklist_id').val();
        $('#' + servicesOverviewModal.modalId + ' #checklist_id').val(checklistId);

        $('#' + servicesOverviewModal.modalId + ' #parent_category').val(data.parent.name);
        $('#' + servicesOverviewModal.modalId + ' #category').val(data.name);
        $('#' + servicesOverviewModal.modalId + ' #in_scope').select2().val('No').trigger("change");
        $('#' + servicesOverviewModal.modalId + ' #status').select2().val('Not Complete').trigger("change");
    }
}

const ServicesOverviewModal = new servicesOverviewModal();

export { ServicesOverviewModal as default };

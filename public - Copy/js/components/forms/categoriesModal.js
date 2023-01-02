/*
 *
 *
 *
 */

import editModal from "./editModal.js";

class categoriesModal extends editModal {

    static formId = '#categoryForm';
    static type = 'category';

    constructor() {
        console.log('+++ Function +++ categoriesModal.constructor');

        super(categoriesModal);

        console.log('--- Function --- categoriesModal.constructor');
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        $('#parent_id').select2().val(data.parent_id).trigger("change");
        $('#category').val(data.name);
        $('#sequence').val(data.sequence);
        $('#type').select2().val(data.type).trigger("change");
    }
}

const CategoriesModal = new categoriesModal();

export { CategoriesModal as default };

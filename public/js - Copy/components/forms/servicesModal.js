/*
 *
 *
 *
 */

import editModal from "./editModal.js";

class servicesModal extends editModal {

    static formId = '#serviceForm';
    static type = 'service';

    constructor() {
        console.log('+++ Function +++ servicesModal.constructor');

        super(servicesModal);

        console.log('--- Function --- servicesModal.constructor');
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        $('#category_id').select2().val(data.category_id).trigger("change");
        $('#section_id').select2().val(data.section_id).trigger("change");
        $('#service').val(data.name);
    }
}

const ServicesModal = new servicesModal();

export { ServicesModal as default };

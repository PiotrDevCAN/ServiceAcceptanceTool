/*
 *
 *
 *
 */

import editModal from "./editModal.js";

class sectionsModal extends editModal {

    static formId = '#sectionForm';
    static type = 'section';

    constructor() {
        console.log('+++ Function +++ sectionsModal.constructor');

        super(sectionsModal);

        console.log('--- Function --- sectionsModal.constructor');
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        $('#section').val(data.name);
    }
}

const SectionsModal = new sectionsModal();

export { SectionsModal as default };

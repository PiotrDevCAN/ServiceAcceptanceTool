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
        $('#DIRECT_LINKFormGroup a').attr('href', data.entry_url).show();
        $('#section').val(data.name);
    }
}

// if ($(sectionsModal.formId).length != 0) {
    const SectionsModal = new sectionsModal();
// } else {
//     console.log('skip sectionsModal.constructor');
// }

export { SectionsModal as default };

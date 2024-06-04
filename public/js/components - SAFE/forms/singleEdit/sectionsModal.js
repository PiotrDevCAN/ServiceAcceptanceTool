/*
 *
 *
 *
 */

let editModal = await cacheBustImport('../forms/editModal.js');

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
        var paragraph = $('#DIRECT_LINKFormGroup');
        paragraph.find('a').attr('href', data.entry_url);
        paragraph.removeClass('ibm-hide');
        $('#section').val(data.name);
    }
}

const SectionsModal = new sectionsModal();

export { SectionsModal as default };

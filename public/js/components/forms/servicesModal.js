/*
 *
 *
 *
 */

import textAreaOptions from "../addons/textAreaOptions.js";
import editModal from "./editModal.js";

class servicesModal extends editModal {

    static formId = '#serviceForm';
    static type = 'service';

    constructor() {
        console.log('+++ Function +++ servicesModal.constructor');

        super(servicesModal);

        console.log('--- Function --- servicesModal.constructor');
    }

    beforeActions(data) {
        console.log("Remove tinyMCE");
        tinymce.remove();
    }

    initialiseForm() {
        console.log("Initialise tinyMCE");
        tinymce.init(textAreaOptions);
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        var paragraph = $('#DIRECT_LINKFormGroup');
        paragraph.find('a').attr('href', data.entry_url);
        paragraph.removeClass('ibm-hide');
        $('#category_id').select2().val(data.category_id).trigger("change");
        $('#section_id').select2().val(data.section_id).trigger("change");
        $('#service').val(data.name);
    }

    afterActions(data) {
        console.log("Initialise tinyMCE");
        tinymce.init(textAreaOptions);
    }
}

const ServicesModal = new servicesModal();

export { ServicesModal as default };

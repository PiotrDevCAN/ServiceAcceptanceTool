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

    initialiseForm() {
        console.log("Initialise tinyMCE");
        tinymce.init({
            forced_root_block : "",
            selector: 'textarea',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
            ],
            toolbar1: 'fullscreen | undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        });
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        $('#DIRECT_LINKFormGroup a').attr('href', data.entry_url).show();
        $('#category_id').select2().val(data.category_id).trigger("change");
        $('#section_id').select2().val(data.section_id).trigger("change");
        $('#service').val(data.name);
    }
}

// if ($(servicesModal.formId).length != 0) {
    const ServicesModal = new servicesModal();
// } else {
//     console.log('skip servicesModal.constructor');
// }

export { ServicesModal as default };

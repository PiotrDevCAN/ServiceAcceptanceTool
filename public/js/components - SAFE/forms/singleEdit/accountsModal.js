/*
 *
 *
 *
 */

let datePickerOptions = await cacheBustImport('../addons/datePickerOptions.js');
let initialiseFacesTypeAheadOnForm = await cacheBustImport('../addons/facesType.js');
let editModal = await cacheBustImport('../forms/editModal.js');

class accountModal extends editModal {

    static formId = '#accountForm';
    static type = 'account';

    constructor() {
        console.log('+++ Function +++ accountModal.constructor');

        super(accountModal);

        console.log('--- Function --- accountModal.constructor');
    }

    initialiseForm() {
        initialiseFacesTypeAheadOnForm("accountForm");

        IBMCore.common.widget.datepicker.init("#go_live_date", datePickerOptions);
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        var paragraph = $('#DIRECT_LINKFormGroup');
        paragraph.find('a').attr('href', data.entry_url);
        paragraph.removeClass('ibm-hide');
        $('#account').val(data.name);

        $('#transition_state').val(data.transition_state).trigger('change');
        $('#go_live_date').val(data.go_live_date);

        $('#account_dpe').val(data.account_dpe_notes_id);
        $('#account_dpe_intranet_id').val(data.account_dpe_intranet_id);
        $('#account_dpe_name').val(data.account_dpe);

        $('#tt_focal').val(data.tt_focal_notes_id);
        $('#tt_focal_intranet_id').val(data.tt_focal_intranet_id);
        $('#tt_focal_name').val(data.tt_focal);

        $('#created_by').val(data.created_by);
    }

    afterActions(data) {
        initialiseFacesTypeAheadOnForm("accountForm");
    }
}

const AccountModal = new accountModal();

export { AccountModal as default };

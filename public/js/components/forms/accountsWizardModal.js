/*
 *
 *
 *
 */

import datePickerOptions from "../addons/datePickerOptions.js";
import initialiseFacesTypeAheadOnForm from "../addons/facesType.js";
import editModal from "./editModal.js";

class accountsWizardModal extends editModal {

    static formId = '#createAccountForm';
    static type = 'account';
    initialised = false;

    constructor() {
        console.log('+++ Function +++ accountsWizardModal.constructor');

        super(accountsWizardModal);

        this.listenForNewAccountWizard();

        console.log('--- Function --- accountsWizardModal.constructor');
    }

    initialiseForm() {
        initialiseFacesTypeAheadOnForm("createAccountForm");

        IBMCore.common.widget.datepicker.init("#go_live_date", datePickerOptions);
    }

    makeRedirection() {

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

    listenForSaveRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #createAccountRecord', function (e) {
            e.preventDefault();
            $this.submitFormWithValidation();
        });
    }

    listenForNewAccountWizard() {
        var $this = this;
        $(document).on('click', '#createAccountWizard', function (e) {
            e.preventDefault();

            //show the overlay
            IBMCore.common.widget.overlay.show('createAccountModal');

            if ($this.initialised === false) {
                $this.initialised = true;
                $this.initialiseForm();
            }
        });
    }
}

const AccountsWizardModal = new accountsWizardModal();

export { AccountsWizardModal as default };

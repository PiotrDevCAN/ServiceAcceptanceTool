/*
 *
 *
 *
 */

let datePickerOptions = await cacheBustImport('../addons/datePickerOptions.js');
let initialiseFacesTypeAheadOnForm = await cacheBustImport('../addons/facesType.js');
let editModal = await cacheBustImport('../forms/editModal.js');
let accountNameSelect = await cacheBustImport('../selects/accountName.js');

class accountsWizardModal extends editModal {

    static formId = '#createAccountForm';
    static type = 'account';
    static recordId = 'account_id';
    static overlayId = 'createAccountModal';
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

    async afterSaveActions(data) {
        //hide the overlay
        IBMCore.common.widget.overlay.hide(accountsWizardModal.overlayId, true);

        await accountNameSelect.prepareDataForSelect();
        $('#account').val(data.id).change();
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
            IBMCore.common.widget.overlay.show(accountsWizardModal.overlayId);

            if ($this.initialised === false) {
                $this.initialised = true;
                $this.initialiseForm();
            }
        });
    }
}

const AccountsWizardModal = new accountsWizardModal();

export { AccountsWizardModal as default };

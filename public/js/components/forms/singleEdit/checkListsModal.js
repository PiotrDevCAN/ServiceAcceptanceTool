/*
 *
 *
 *
 */

let isNumeric = await cacheBustImport('../addons/isNumeric.js');
let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let datePickerOptions = await cacheBustImport('../addons/datePickerOptions.js');
let initialiseFacesTypeAheadOnForm = await cacheBustImport('../addons/facesType.js');
let editModal = await cacheBustImport('../forms/editModal.js');
let accountsWizardModal = await cacheBustImport('../forms/singleEdit/accountsWizardModal.js');

let accountNameSelect = await cacheBustImport('../selects/accountName.js');

class checkListsModal extends editModal {

    static formId = '#checklistAccountForm';
    static type = 'checklist';
    static recordId = 'checklist_id';

    constructor() {
        console.log('+++ Function +++ checkListsModal.constructor');

        super(checkListsModal);

        this.listenForChecklistTypeChange();
        this.listenForChecklistTypeApproval();
        this.listenForChecklistTypeCancellation();

        this.listenForAccountNameChange();

        console.log('--- Function --- checkListsModal.constructor');
    }

    initialiseForm() {
        initialiseFacesTypeAheadOnForm("checklistAccountForm");

        IBMCore.common.widget.datepicker.init("#go_live_date", datePickerOptions);
    }

    populateRecordData(data) {
        $('#account_id').val(data.id);
        $('#account_created_by').val(data.created_by);

        $('#transition_state')
            .val(data.transition_state)
            .trigger('change');
        $('#go_live_date').val(data.go_live_date);

        $('#account_dpe').val(data.account_dpe_notes_id);
        $('#account_dpe_intranet_id').val(data.account_dpe_intranet_id);
        $('#account_dpe_name').val(data.account_dpe);

        $('#tt_focal').val(data.tt_focal_notes_id);
        $('#tt_focal_intranet_id').val(data.tt_focal_intranet_id);
        $('#tt_focal_name').val(data.tt_focal);
    }

    updateTTFocalField() {
        var typeField = $("#checklist_type");
        var type = typeField.val();
        var asterix = $("[for='tt_focal']").find(".ibm-required");
        var input = $("#tt_focal");
        var inputName = $("#tt_focal_name");
        var inputIntrnetId = $("#tt_focal_intranet_id");
        switch (type) {
            case 'T&T_YES':
                asterix.removeClass('ibm-hide');
                input.attr('required');
                break;
            case 'T&T_NO':
                asterix.addClass('ibm-hide');
                input.removeAttr('required');
                input.val('');
                inputName.val('');
                inputIntrnetId.val('');
                break;
            default:
                asterix.removeClass('ibm-hide');
                input.attr('required');
                break;
        }
    }

    revokeTTFocalFieldUpdate() {
        var typeField = $("#checklist_type");
        var type = typeField.val();
        switch (type) {
            case 'T&T_YES':
                typeField.val('T&T_NO')
                    .trigger('change');
                break;
            case 'T&T_NO':
                typeField.val('T&T_YES')
                    .trigger('change');
                break;
            default:
                break;
        }
    }

    listenForChecklistTypeChange() {
        var $this = this;
        $(document).on('change', 'select#checklist_type', function (event) {
            var checklist_id = $('#checklist_id').val();
            if (checklist_id !== '') {
                //show the overlay
                IBMCore.common.widget.overlay.show('changeChecklistTypeModal');
            } else {
                $this.updateTTFocalField();
            }
        });
    }

    listenForChecklistTypeApproval() {
        var $this = this;
        $(document).on('click', '#makeTypeChangeRecord', function (e) {
            e.preventDefault();
            $this.updateTTFocalField();
            //hide the overlay
            IBMCore.common.widget.overlay.hide('changeChecklistTypeModal', true);
        });
    }

    listenForChecklistTypeCancellation() {
        var $this = this;
        $(document).on('click', '#cancelTypeChangeRecord', function (e) {
            e.preventDefault();
            $this.revokeTTFocalFieldUpdate();
            //hide the overlay
            IBMCore.common.widget.overlay.hide('changeChecklistTypeModal', true);
        });
    }

    listenForAccountNameChange() {
        var $this = this;
        $(document).on('change', 'select#account', function (event) {
            var id = $(this).val();
            if (id !== '') {
                if (isNumeric(id)) {

                    showHideSpinner('show');

                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: window.appUrl + '/api/account/show/' + id,
                        data: { id: id },
                        success: function (responseObj) {
                            console.log(responseObj);

                            $this.populateRecordData(responseObj);

                            $('#saveRecord').prop("disabled", false);
                            $('#saveRecord').next().prop("disabled", false);
                        },
                        complete: function () {
                            showHideSpinner('hide');
                        }
                    });
                } else {
                    console.log('new account');
                }
            } else {
                $('#checklistAccountForm')[0].reset();

                var dataObj = {
                    id: '',
                    created_by: '',
                    transition_state: '',
                    go_live_date: '',
                    account_dpe: '',
                    account_dpe_notes_id: '',
                    account_dpe_intranet_id: '',
                    tt_focal: '',
                    tt_focal_notes_id: '',
                    tt_focal_intranet_id: ''
                };

                $this.populateRecordData(dataObj);

                $('#saveRecord').prop("disabled", false);
                $('#saveRecord').next().prop("disabled", false);
            }
        });
    }

    afterSaveActions(data) {
        // refresh current page
        // location.reload();

        // redirect to entry page
        super.makeRedirection(data);
    }
}

const CheckListsModal = new checkListsModal();

export { CheckListsModal as default };

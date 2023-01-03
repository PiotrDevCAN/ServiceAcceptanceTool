/*
 *
 *
 *
 */

import isNumeric from "../addons/isNumeric.js";
import showHideSpinner from "../addons/spinner.js";
import datePickerOptions from "../addons/datePickerOptions.js";
import initialiseFacesTypeAheadOnForm from "../addons/facesType.js";
import editModal from "../forms/editModal.js";
import accountsWizardModal from "./accountsWizardModal.js";

import accountNameSelect from "../selects/accountName.js";

class checkListsModal extends editModal {

    static formId = '#accountForm';
    static type = 'checklist';

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
        initialiseFacesTypeAheadOnForm("accountForm");

        IBMCore.common.widget.datepicker.init("#go_live_date", datePickerOptions);
    }

    populateRecordData(data) {
        $('#account_id').val(data.id);
        $('#account').val(data.name);

        $('#transition_state').val(data.transition_state).trigger('change');
        $('#go_live_date').val(data.go_live_date);

        $('#account_dpe').val(data.account_dpe_notes_id);
        $('#account_dpe_intranet_id').val(data.account_dpe_intranet_id);
        $('#account_dpe_name').val(data.account_dpe);

        $('#tt_focal').val(data.tt_focal_notes_id);
        $('#tt_focal_intranet_id').val(data.tt_focal_intranet_id);
        $('#tt_focal_name').val(data.tt_focal);

        $('#account_created_by').val(data.created_by);
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
            } else{
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
            IBMCore.common.widget.overlay.hide('changeChecklistTypeModal',true);
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
                $('#accountForm')[0].reset();
                $('#id').val('');
                $('#checklist_id').val('');
                $('#account_id').val('');
                $('#transition_state')
                    .val('')
                    .trigger('change');
                $('#saveRecord').prop("disabled", false);
                $('#saveRecord').next().prop("disabled", false);
            }
        });
    }
}

const CheckListsModal = new checkListsModal();

export { CheckListsModal as default };

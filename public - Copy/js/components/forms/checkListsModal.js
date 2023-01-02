/*
 *
 *
 *
 */

import isNumeric from "../addons/isNumeric.js";
import showHideSpinner from "../addons/spinner.js";
import options from "../addons/datePickerOptions.js";
import initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew from "../addons/facesType.js";
import editModal from "../forms/editModal.js";

class checkListsModal extends editModal {

    static formId = '#accountForm';
    static type = 'checklist';

    constructor() {
        console.log('+++ Function +++ checkListsModal.constructor');

        super(checkListsModal);

        this.listenForChecklistTypeChange();
        this.listenForAccountNameChange();

        console.log('--- Function --- checkListsModal.constructor');
    }

    initialiseForm() {
        var typeaheadInputs = $('input.typeaheadNew:visible');
        for (var n = 0; n < typeaheadInputs.length; n++) {
            var id = typeaheadInputs.eq(n).attr('id');
            initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew(id, "accountForm");
        }

        IBMCore.common.widget.datepicker.init("#go_live_date", options);
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

    listenForChecklistTypeChange() {
        var $this = this;
        $(document).on('change', 'select#checklist_type', function (event) {
            var message = 'Warning, changing a new T&T type will cause wipe out all currently assigned categories and services.';
            // populate the div or span in the overlay
            document.getElementById("overlayInfoContent").innerHTML = message;
            //show the overlay
            IBMCore.common.widget.overlay.show('overlayInfo');
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
                        url: "/ServiceAcceptanceTool/api/account/show/" + id,
                        data: { id: id },
                        success: function (responseObj) {
                            console.log(responseObj);

                            CheckListsModal.populateRecordData(responseObj);

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

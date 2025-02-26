/*
 *
 *
 *
 */

let initialiseFacesTypeAheadOnForm = await cacheBustImport('../addons/facesType.js');
let OverlayInfoModal = await cacheBustImport('../forms/overlayInfoModal.js');
let editModal = await cacheBustImport('../forms/editModal.js');

class accessesModal extends editModal {

    static formId = '#accessForm';
    static type = 'access';

    constructor() {
        console.log('+++ Function +++ accessesModal.constructor');

        super(accessesModal);

        this.listenForApproveRecord();
        this.listenForRejectRecord();

        console.log('--- Function --- accessesModal.constructor');
    }

    initialiseForm() {
        initialiseFacesTypeAheadOnForm("accessForm");
    }

    listenForApproveRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #approveRecord', function (e) {
            e.preventDefault();
            $this.performActionRecordAjax('approve');
        });
    }

    listenForRejectRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #rejectRecord', function (e) {
            e.preventDefault();
            $this.performActionRecordAjax('reject');
        });
    }

    populateRecordData(data) {
        $('#id').val(data.id);
        var paragraph = $('#DIRECT_LINKFormGroup');
        paragraph.find('a').attr('href', data.entry_url);
        paragraph.removeClass('ibm-hide');

        $('#employee').val(data.employee_notes_id);
        $('#employee_intranet_id').val(data.employee_intranet_id);
        $('#employee_name').val(data.employee);

        $('#status').val(data.status);
        $('#type').val(data.type);

        $('#created_by').val(data.created_by);
    }

    restrictFormButtons() {
        var formData = new FormData(this.formElement);
        var id = formData.get('id');
        var status = formData.get('status');

        var saveButton = document.querySelector(this.formId + ' #saveRecord');
        var updateButton = document.querySelector(this.formId + ' #updateRecord');
        var resetRecord = document.querySelector(this.formId + ' #resetRecord');

        var approveButton = document.querySelector(this.formId + ' #approveRecord');
        var rejectButton = document.querySelector(this.formId + ' #rejectRecord');
        var deleteButton = document.querySelector(this.formId + ' #deleteRecord');

        if (saveButton) {
            saveButton.style.display = 'none';
        }
        if (updateButton) {
            updateButton.style.display = 'none';
        }
        if (resetRecord) {
            resetRecord.style.display = 'none';
        }

        if (approveButton) {
            approveButton.style.display = 'none';
        }
        if (rejectButton) {
            rejectButton.style.display = 'none';
        }
        if (deleteButton) {
            deleteButton.style.display = 'none';
        }

        if (id === "") {
            if (saveButton) {
                saveButton.style.display = 'inline-block';
            }
        } else {
            switch (status) {
                case "Approved":
                    if (rejectButton) {
                        rejectButton.style.display = 'inline-block';
                    }
                    if (deleteButton) {
                        deleteButton.style.display = 'inline-block';
                    }
                    break;
                case "Rejected":
                    if (approveButton) {
                        approveButton.style.display = 'inline-block';
                    }
                    if (deleteButton) {
                        deleteButton.style.display = 'inline-block';
                    }
                    break;
                default:
                    if (approveButton) {
                        approveButton.style.display = 'inline-block';
                    }
                    if (rejectButton) {
                        rejectButton.style.display = 'inline-block';
                    }
                    if (deleteButton) {
                        deleteButton.style.display = 'inline-block';
                    }
                    break;
            }
        }
    }

    performActionRecordAjax(action) {
        var formData = new FormData(this.formElement);
        var id = formData.get('id');
        var $this = this;
        $.ajax({
            type: "POST",
            url: window.apiUrl + $this.type + "/" + action + "/" + id,
            data: formData,
            // These must be set to false to allow file uploading ++
            contentType: false,
            processData: false,
            success: function (responseObj) {
                console.log(responseObj);
                if (responseObj.success) {
                    var message = "<p>Action on the record has been made</p>";
                } else {
                    var message = "<p>Delete has encountered a problem</p><p>" +
                        responseObj.message +
                        "</p>";
                }

                OverlayInfoModal.setContent(message);
                OverlayInfoModal.show();

                // refresh current page
                location.reload();
            }
        });
    }

    afterActions(data) {
        initialiseFacesTypeAheadOnForm("accessForm");
    }
}

const AccessesModal = new accessesModal();

export { AccessesModal as default };

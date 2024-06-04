/*
 *
 *
 *
 */

let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let handleError = await cacheBustImport('../addons/handleError.js');

let validateForm = await cacheBustImport('../addons/validateForm.js');
let OverlayInfoModal = await cacheBustImport('../forms/overlayInfoModal.js');

class editModal {

    formId;
    formElement;
    type;
    rootType;
    modalId = 'editModal';
    recordId = 'id';

    recordData;     // data from selected table row

    constructor(child) {
        console.log('+++ Function +++ editModal.constructor');

        this.formId = child.formId;
        this.formElement = document.querySelector(this.formId);
        if (typeof (child.recordId) !== 'undefined') {
            this.recordId = child.recordId;
        }
        this.type = child.type;
        if (typeof (child.rootType) !== 'undefined') {
            this.rootType = child.rootType;
        }
        if (typeof (child.modalId) !== 'undefined') {
            this.modalId = child.modalId;
        }

        this.initialiseForm();

        this.listenForSubmitForm();

        this.listenForSaveRecord();
        this.listenForUpdateRecord();
        this.listenForResetRecord();
        this.listenForDuplicateRecord();
        this.listenForDeleteRecord();
        this.listenForConfirmDeleteRecord();

        this.restrictFormButtons();

        console.log('--- Function --- editModal.constructor');
    }

    /**
     *
     */
    // populateRecordData(data) {

    // }

    // populateRecordRootData(data) {

    // }

    // beforeActions(data) {

    // }

    // additionalActions(data) {

    // }

    // afterActions(data) {

    // }

    // beforeSaveActions() {

    // }

    // afterSaveActions(data) {

    //     // refresh current page
    //     // location.reload();

    //     // redirect to entry page
    //     // this.makeRedirection(data);

    //     // hide the overlay
    //     // IBMCore.common.widget.overlay.hide(this.modalId, true);
    // }
    /**
     *
     */

    submitFormWithValidation() {
        try {
            tinyMCE.triggerSave();
        } catch (e) { }
        validateForm(this, this.submitForm);
    }

    submitForm(modal) {

        try {
            tinyMCE.triggerSave();
        } catch (e) { }

        var formElement = modal.formElement;
        var formData = new FormData(formElement);
        var id = formData.get(modal.recordId);

        if (id === "") {
            var action = 'store';
        } else {
            var action = 'update/' + id;
        }

        showHideSpinner('show');

        var $this = modal;
        $.ajax({
            type: "post",
            dataType: "json",
            url: window.apiUrl + modal.type + "/" + action,
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (jqXHR, settings) {
                if (typeof ($this.beforeSaveActions) !== 'undefined') {
                    $this.beforeSaveActions();
                }
            },
            success: function (responseObj) {
                console.log(responseObj);
                if (responseObj.success) {
                    if (responseObj.message) {
                        var message = "<p>" + responseObj.message + "</p>";
                    } else {
                        var message = "<p>Record Saved</p>";
                    }
                } else {
                    var message = "<p>Save has encountered a problem</p><p>" +
                        responseObj.message +
                        "</p>";
                }

                OverlayInfoModal.setContent(message);
                OverlayInfoModal.show();

                if (typeof ($this.afterSaveActions) !== 'undefined') {
                    $this.afterSaveActions(responseObj);
                }
            },
            error: function (data) {
                var message = handleError(data);
                OverlayInfoModal.setContent(message);
                OverlayInfoModal.show();
            },
            complete: function () {
                showHideSpinner('hide');
            }
        });
    }

    initialiseForm() {
        // alert(this.formId);
    }

    makeRedirection(responseObj) {
        // redirect to index page
        window.location.replace(responseObj.entryUrl);
    }

    listenForSubmitForm() {
        var $this = this;
        $(document).on('submit', $this.formId, function (event) {
            event.preventDefault();
        });
    }

    listenForSaveRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #saveRecord', function (e) {
            e.preventDefault();
            $this.submitFormWithValidation();
        });
    }

    listenForUpdateRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #updateRecord', function (e) {
            e.preventDefault();
            $this.submitFormWithValidation();
        });
    }

    listenForResetRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #resetRecord', function (e) {
            e.preventDefault();

            document.querySelector($this.formId).reset();

            $($this.formId).find('select').each(function () {
                $(this).val(null).change();
            });
        });
    }

    listenForDuplicateRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #duplicateRecord', function (e) {
            e.preventDefault();
            $this.performDuplicateRecordAjax();
        });
    }

    performDuplicateRecordAjax() {
        var formData = new FormData(this.formElement);
        var id = formData.get(this.recordId);
        var $this = this;

        showHideSpinner('show');

        $.ajax({
            type: "POST",
            url: window.apiUrl + $this.type + "/duplicate/" + id,
            data: formData,
            // These must be set to false to allow file uploading ++
            contentType: false,
            processData: false,
            success: function (responseObj) {
                console.log(responseObj);
                if (responseObj.success) {
                    var message = "<p>Record Duplicated</p>";
                } else {
                    var message = "<p>Duplication has encountered a problem</p><p>" +
                        responseObj.message +
                        "</p>";
                }

                OverlayInfoModal.setContent(message);
                OverlayInfoModal.show();

                // refresh current page
                location.reload();
            },
            complete: function () {
                showHideSpinner('hide');
            }
        });
    }

    listenForDeleteRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #deleteRecord', function (e) {
            e.preventDefault();

            // this is a delete safeguard mechanism that just calls performDelete if
            // the user clicks the button again
            document.getElementById("deleteRecord").outerHTML = '<button type="button" id="confirmDeleteRecord" class="ibm-btn-pri ibm-btn-red-50">Click Again To Confirm Delete</button>';
        });
    }

    listenForConfirmDeleteRecord() {
        var $this = this;
        $(document).on('click', $this.formId + ' #confirmDeleteRecord', function (e) {
            e.preventDefault();

            // this is a delete safeguard mechanism that just calls performDelete if
            // the user clicks the button again
            // document.getElementById("deleteRecord").outerHTML='<button type="button" id="confirmDeleteRecord" class="ibm-btn-pri ibm-btn-red-50" onclick="cookbookRecord.performConfirmDeleteRecord();">Click Again To Confirm Delete</button>';
            $this.performConfirmDeleteRecordAjax();
        });
    }

    performConfirmDeleteRecordAjax() {
        var formData = new FormData(this.formElement);
        var id = formData.get(this.recordId);
        var $this = this;

        showHideSpinner('show');

        $.ajax({
            type: "POST",
            url: window.apiUrl + $this.type + "/destroy/" + id,
            data: formData,
            // These must be set to false to allow file uploading ++
            contentType: false,
            processData: false,
            success: function (responseObj) {
                console.log(responseObj);
                if (responseObj.success) {
                    var message = "<p>Record Deleted</p>";
                } else {
                    var message = "<p>Delete has encountered a problem</p><p>" +
                        responseObj.message +
                        "</p>";
                }

                OverlayInfoModal.setContent(message);
                OverlayInfoModal.show();

                document.getElementById("confirmDeleteRecord").outerHTML = '<button type="button" id="deleteRecord" class="ibm-btn-pri ibm-btn-red-50">Delete</button>';

                // redirect to index page
                window.location.replace(responseObj.indexUrl);
            },
            complete: function () {
                showHideSpinner('hide');
            }
        });
    }

    restrictFormButtons() {
        var formData = new FormData(this.formElement);
        var id = formData.get(this.recordId);

        var saveButton = document.querySelector(this.formId + ' #saveRecord');
        var updateButton = document.querySelector(this.formId + ' #updateRecord');
        var duplicateRecord = document.querySelector(this.formId + ' #duplicateRecord');
        var deleteButton = document.querySelector(this.formId + ' #deleteRecord');

        if (saveButton) {
            saveButton.style.display = 'none';
        }
        if (updateButton) {
            updateButton.style.display = 'none';
        }
        if (duplicateRecord) {
            duplicateRecord.style.display = 'none';
        }
        if (deleteButton) {
            deleteButton.style.display = 'none';
        }

        if (id === "") {
            if (saveButton) {
                saveButton.style.display = 'inline-block';
            }
        } else {
            if (updateButton) {
                updateButton.style.display = 'inline-block';
            }
            if (duplicateRecord) {
                duplicateRecord.style.display = 'inline-block';
            }
            if (deleteButton) {
                deleteButton.style.display = 'inline-block';
            }
        }
    }

    makeShowFormCall(type, urlId, id, root) {
        var $this = this;
        $.ajax({
            type: "post",
            dataType: "json",
            url: window.apiUrl + type + "/show/" + urlId,
            data: {
                id: id
            },
            success: function (responseObj) {
                console.log(responseObj);

                if (typeof ($this.beforeActions) !== 'undefined') {
                    $this.beforeActions(responseObj);
                }

                if (typeof (root) == 'undefined') {
                    if (typeof ($this.populateRecordData) !== 'undefined') {
                        $this.populateRecordData(responseObj);
                    }
                } else {
                    if (typeof ($this.populateRecordRootData) !== 'undefined') {
                        $this.populateRecordRootData(responseObj);
                    }
                }

                $this.restrictFormButtons();

                if (typeof ($this.additionalActions) !== 'undefined') {
                    $this.additionalActions(responseObj);
                }

                //show the overlay
                IBMCore.common.widget.overlay.show($this.modalId);

                if (typeof ($this.afterActions) !== 'undefined') {
                    $this.afterActions(responseObj);
                }
            },
            complete: function () {
                showHideSpinner('hide');
            }
        });
    }

    showForm(data) {

        showHideSpinner('show');

        // store data in object
        this.recordData = data;

        if (typeof (data.pivot_id) == 'undefined') {
            this.makeShowFormCall(this.type, data.id, data.id);
        } else {
            if (data.pivot_id === '') {
                this.makeShowFormCall(this.rootType, data.id, data.id, true);
            } else {
                this.makeShowFormCall(this.type, data.pivot_id, data.id);
            }
        }
    }
}

export { editModal as default };

/*
 *
 *
 *
 */

import isNull from "../addons/isNull.js";
import initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew from "../addons/facesType.js";
import showHideSpinner from "../addons/spinner.js";
import validateForm from "../addons/validateForm.js";

class editModal {

    formId;
    formElement;
    type;
    rootType;
    modalId = 'editModal';
    static apiUrl = '/ServiceAcceptanceTool/api/';

    constructor(child) {
        console.log('+++ Function +++ editModal.constructor');

        this.formId = child.formId;
        this.formElement = document.querySelector(this.formId);
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

    submitFormWithValidation() {
        validateForm(this, this.submitForm);
    }

    submitForm(modal) {

        try {
            tinyMCE.triggerSave();
        } catch (e) { }

        var formElement = modal.formElement;
        var formData = new FormData(formElement);
        var id = formData.get('id');

        if (id === "") {
            var action = 'store';
        } else {
            var action = 'update/' + id;
        }

        showHideSpinner('show');

        var $this = this;
        $.ajax({
            type: "post",
            dataType: "json",
            url: editModal.apiUrl + modal.type + "/" + action,
            data: formData,
            processData: false,
            contentType: false,
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

                // populate the div or span in the overlay
                document.getElementById("overlayInfoContent").innerHTML = message;

                //show the overlay
                IBMCore.common.widget.overlay.show('overlayInfo');

                // redirect to index page
                window.location.replace(responseObj.entryUrl);
            },
            error: function (data) {
                switch(data.status) {
                    case 422:
                        var responseObj = data.responseJSON;
                        var message = responseObj.message;
                        var errors = responseObj.errors;
                        $.each(errors, function (key, value) {
                            // $('#' + key).parent().addClass('error');
                            console.log(' key ' + key + ' value ' + value);
                        });

                        // populate the div or span in the overlay
                        document.getElementById("overlayInfoContent").innerHTML = message;

                        //show the overlay
                        IBMCore.common.widget.overlay.show('overlayInfo');

                        break;
                    case 500:
                        var message = 'Internal Server Error';

                        // populate the div or span in the overlay
                        document.getElementById("overlayInfoContent").innerHTML = message;

                        //show the overlay
                        IBMCore.common.widget.overlay.show('overlayInfo');

                        break;
                    default:
                        break;
                }
            },
            complete: function () {
                showHideSpinner('hide');
            }
        });
    }

    initialiseForm() {
        // alert(this.formId);
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
            // $this.submitFormWithValidation();
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
        if (!isNull(this.formElement)) {
            var formData = new FormData(this.formElement);
            var id = formData.get('id');
            var $this = this;
            $.ajax({
                type: "POST",
                url: editModal.apiUrl + $this.type + "/duplicate/" + id,
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

                    // populate the div or span in the overlay
                    document.getElementById("overlayInfoContent").innerHTML = message;
                    //show the overlay
                    IBMCore.common.widget.overlay.show('overlayInfo');

                    // refresh current page
                    location.reload();
                }
            });
        }
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
        if (!isNull(this.formElement)) {
            var formData = new FormData(this.formElement);
            var id = formData.get('id');
            var $this = this;
            $.ajax({
                type: "POST",
                url: editModal.apiUrl + $this.type + "/destroy/" + id,
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

                    // populate the div or span in the overlay
                    document.getElementById("overlayInfoContent").innerHTML = message;
                    //show the overlay
                    IBMCore.common.widget.overlay.show('overlayInfo');

                    document.getElementById("confirmDeleteRecord").outerHTML = '<button type="button" id="deleteRecord" class="ibm-btn-pri ibm-btn-red-50">Delete</button>';

                    // redirect to index page
                    window.location.replace(responseObj.indexUrl);
                }
            });
        }
    }

    beforeActions(data) {

    }

    populateRecordData(data) {

    }

    populateRecordRootData(data) {

    }

    restrictFormButtons() {
        if (!isNull(this.formElement)) {
            var formData = new FormData(this.formElement);
            var id = formData.get('id');

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
    }

    additionalActions(data) {

    }

    afterActions(data) {

    }

    showForm(data) {

        showHideSpinner('show');

        if (typeof (data.pivot_id) == 'undefined') {
            var $this = this;
            $.ajax({
                type: "post",
                dataType: "json",
                url: editModal.apiUrl + $this.type + "/show/" + data.id,
                data: {
                    id: data.id
                },
                success: function (responseObj) {
                    console.log(responseObj);

                    $this.beforeActions(responseObj);

                    $this.populateRecordData(responseObj);

                    $this.restrictFormButtons();

                    $this.additionalActions(responseObj);

                    $this.afterActions(responseObj);

                    //show the overlay
                    IBMCore.common.widget.overlay.show($this.modalId);

                    var typeaheadInputs = $('input.typeaheadNew:not(".tt-input, .tt-hint")');
                    for (var n = 0; n < typeaheadInputs.length; n++) {
                        var id = typeaheadInputs.eq(n).attr('id');
                        initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew(id, "accountForm");
                    }
                },
                complete: function () {
                    showHideSpinner('hide');
                }
            });
        } else {
            if (data.pivot_id === '') {

                var $this = this;
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: editModal.apiUrl + $this.rootType + "/show/" + data.id,
                    data: {
                        id: data.id
                    },
                    success: function (responseObj) {
                        console.log(responseObj);

                        $this.beforeActions(responseObj);

                        $this.populateRecordRootData(responseObj);

                        $this.restrictFormButtons();

                        $this.additionalActions(responseObj);

                        $this.afterActions(responseObj);

                        //show the overlay
                        IBMCore.common.widget.overlay.show($this.modalId);

                        var typeaheadInputs = $('input.typeaheadNew:not(".tt-input, .tt-hint")');
                        for (var n = 0; n < typeaheadInputs.length; n++) {
                            var id = typeaheadInputs.eq(n).attr('id');
                            initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew(id, "accountForm");
                        }
                    },
                    complete: function () {
                        showHideSpinner('hide');
                    }
                });
            } else {
                var $this = this;
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: editModal.apiUrl + $this.type + "/show/" + data.pivot_id,
                    data: {
                        id: data.id
                    },
                    success: function (responseObj) {
                        console.log(responseObj);

                        $this.beforeActions(responseObj);

                        $this.populateRecordData(responseObj);

                        $this.restrictFormButtons();

                        $this.additionalActions(responseObj);

                        $this.afterActions(responseObj);

                        //show the overlay
                        IBMCore.common.widget.overlay.show($this.modalId);

                        var typeaheadInputs = $('input.typeaheadNew:not(".tt-input, .tt-hint")');
                        for (var n = 0; n < typeaheadInputs.length; n++) {
                            var id = typeaheadInputs.eq(n).attr('id');
                            initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew(id, "accountForm");
                        }
                    },
                    complete: function () {
                        showHideSpinner('hide');
                    }
                });
            }
        }
    }
}

export { editModal as default };

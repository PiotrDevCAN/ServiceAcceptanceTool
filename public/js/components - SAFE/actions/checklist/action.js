/*
 *
 *
 *
 *
 *
 */

let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let handleError = await cacheBustImport('../addons/handleError.js');

let OverlayInfoModal = await cacheBustImport('../forms/overlayInfoModal.js');
let MassActionModal = await cacheBustImport('../forms/massUpdate/massActionModal.js');

class action {

    infoModal;
    Container;
    typeOfAction;
    url;
    buttonClass;
    modal;

    field;
    value;

    /*
        Container,
        actionType,
        singleAction,
    */
    constructor(Container, actionType, singleAction) {
        this.infoModal = OverlayInfoModal;
        this.Container = Container;
        this.typeOfAction = actionType;
        // URL of a backend listener to handle the action
        this.url = this.typeOfAction.url;
        this.buttonClass = singleAction.buttonClass;
        this.modal = MassActionModal;

        // In Scope, Status for Categories
        // Status for Services
        this.field = singleAction.field;

        // Complete, Not Complete, Yes, No for Categories
        // Yes, No, Not in scope for Services
        this.value = singleAction.value;

        this.listenForAction();
    }

    listenForAction() {
        var $this = this;
        var wrapperId = $this.Container.getWrapperId();
        $(document).on('click', wrapperId + ' ' + $this.buttonClass, function (e) {
            e.preventDefault();

            $this.startAction();
        });
    }

    startAction() {
        var selectedItems = this.Container.getSelectedItemsMap();
        var createItems = this.Container.getCreateItemsMap();
        if (selectedItems.length || createItems.length) {
            var message = '<p>' + selectedItems.length + ' item(s) will be updated</p>';
            message += '<p>' + createItems.length + ' item(s) will be inserted</p>';

            this.modal.setContent(message);

            // set action in modal
            this.modal.assignAction(this);

            this.modal.show();
        } else {
            var message = 'Firstly, select all items from table below, that you would like to modify!';

            this.infoModal.setContent(message);
            this.infoModal.show();
        }
    }

    confirmAction() {
        // this is a delete safeguard mechanism that just calls performDelete if
        // the user clicks the button again
        document.getElementById("performAction").outerHTML = '<button type="button" id="confirmAction" class="ibm-btn-pri ibm-btn-red-50" onclick="#">Click Again To Confirm Action</button>';
    }

    performAction() {
        var $this = this;
        $.ajax({
            type: "post",
            dataType: "json",
            url: $this.url,
            data: {
                checklistId: $("#checklist_id").val(),
                field: $this.field,
                value: $this.value,
                existingItems: $this.Container.getSelectedItemsMap(),
                newItems: $this.Container.getCreateItemsMap(),
            },
            // processData: false,
            // contentType: false,
            beforeSend: function (jqXHR, settings) {
                showHideSpinner('show');
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

                $this.infoModal.setContent(message);
                $this.infoModal.show();
            },
            error: function (data) {
                var message = handleError(data);
                $this.infoModal.setContent(message);
                $this.infoModal.show();
            },
            complete: function () {
                $this.modal.setDefaultButton();
                showHideSpinner('hide');

                // refresh current page
                location.reload();
            }
        });
    }
}

export { action as default };

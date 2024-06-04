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
let MassActionModal = await cacheBustImport('../forms/massActionModal.js');

class action {

    infoModal;
    Container;
    typeOfAction;
    url;
    buttonId;
    modal;

    field;
    // value;
    actionType;

    /*
        Container,
        actionType,
        singleAction,
    */
    constructor(Container, actionType, singleAction, modal) {
        this.infoModal = OverlayInfoModal;
        this.Container = Container;
        this.typeOfAction = actionType;
        // URL of a backend listener to handle the action
        this.url = this.typeOfAction.url;
        this.buttonId = singleAction.buttonId;
        if (typeof (modal) !== 'undefined') {
            this.modal = modal;
        } else {
            this.modal = MassActionModal;
        }

        // parent_id, type for Categories
        // category_id, section_id for Services
        this.field = this.modal.field;

        // Update or Delete
        if (typeof (singleAction.actionType) !== 'undefined') {
            this.actionType = singleAction.actionType;
        } else {
            this.actionType = 'Update';
        }

        this.listenForAction();
    }

    listenForAction() {
        var $this = this;
        var wrapperId = $this.Container.getWrapperId();
        $(document).on('click', wrapperId + ' ' + $this.buttonId, function (e) {
            e.preventDefault();

            $this.startAction();
        });
    }

    startAction() {
        var selectedItems = this.Container.getSelectedItemsMap();
        if (selectedItems.length) {
            var message = '<p>' + selectedItems.length + ' item(s) will be updated</p>';

            this.modal.setMessageContent(message);

            // set action in modal
            this.modal.assignAction(this);

            this.modal.setDefaultButtonLabel(this.actionType);

            this.modal.show();
        } else {
            var message = 'Firstly, select all items from table below, that you would like to modify!';

            this.infoModal.setContent(message);
            this.infoModal.show();
        }
    }

    confirmAction() {
        // id of selected item
        if (this.actionType == 'Update') {
            this.value = this.modal.getSelectedValue();
            if (this.value !== '') {
                this.modal.setConfirmButton();
            } else {
                var message = '<p>Firstly, select an appropriate item for re-assignment.</p>';

                this.infoModal.setContent(message);
                this.infoModal.show();
            }
        } else {
            this.modal.setConfirmButton();
            this.field = this.actionType;
            this.value = true;
        }
    }

    performAction() {
        var $this = this;
        $.ajax({
            type: "post",
            dataType: "json",
            url: $this.url,
            data: {
                field: $this.field,
                value: $this.value,
                existingItems: $this.Container.getSelectedItemsMap(),
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
                $this.modal.setDefaultButton(this.actionType);
                showHideSpinner('hide');

                // refresh current page
                location.reload();
            }
        });
    }
}

export { action as default };

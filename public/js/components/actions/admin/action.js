/*
 *
 *
 *
 *
 *
 */

let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let handleError = await cacheBustImport('../addons/handleError.js');

let topAction = await cacheBustImport('../actions/action.js');

class action extends topAction {

    // parent_id, type, Delete
    field;

    // type: T&T_NO, T&T_YES
    // parent_id: id of selected item
    value;

    actionType;

    constructor(Container, actionType, singleAction, modal) {
        super(Container, actionType, singleAction, modal);

        // parent_id, type for Categories
        // category_id, section_id for Services
        this.field = this.modal.field;

        // Update or Delete
        if (typeof (singleAction.actionType) !== 'undefined') {
            this.actionType = singleAction.actionType;
        } else {
            this.actionType = 'Update';
        }

        this.value = this.modal.getSelectedValue();

        console.log('this.actionType');
        console.log(this.actionType);
    }

    startAction() {
        var selectedItems = this.Container.getSelectedItemsMap();
        if (selectedItems.length) {
            var message = '<p>' + selectedItems.length + ' ' + topAction.itemsUpdated + '</p>';

            this.modal.setMessageContent(message);

            // set action in modal
            this.modal.assignAction(this);

            this.modal.setDefaultButtonLabel(this.actionType);

            this.modal.show();
        } else {
            var message = topAction.emptyQueue;
            this.infoModal.setContent(message);
            this.infoModal.show();
        }
    }

    confirmAction() {
        // switch(this.actionType) {
        //     case 'Update':
        //         break;
        //     case 'Delete':
        //         break;
        //     default:
        //         break;
        // }
        // id of selected item
        if (this.actionType == 'Update') {
            this.value = this.modal.getSelectedValue();
            if (this.value !== '') {
                this.modal.setConfirmButton();
            } else {
                var message = '<p>' + topAction.emptyAssignmentQueue + '</p>';
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

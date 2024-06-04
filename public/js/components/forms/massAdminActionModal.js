/*
 *
 *
 *
 */

class massAdminActionModal {

    action;

    constructor(child) {
        console.log('+++ Function +++ massAdminActionModal.constructor');

        this.modalId = child.modalId;
        this.modalContentId = child.modalContentId;
        this.performActionButtonId = child.performActionButtonId;
        this.confirmActionButtonId = child.confirmActionButtonId;
        this.field = child.field;

        this.listenForPerformAction();
        this.listenForConfirmAction();

        console.log('--- Function --- massAdminActionModal.constructor');
    }

    assignAction(action) {
        this.action = action;
    }

    setMessageContent(content) {
        // populate the div or span in the overlay
        document.getElementById(this.modalContentId)
            .getElementsByClassName('msgBox')[0]
            .innerHTML = content;
    }

    setContent(content) {
        // populate the div or span in the overlay
        document.getElementById(this.modalContentId).innerHTML = content;
    }

    setDefaultButtonLabel(label) {
        if (typeof (label) === 'undefined') {
            label = 'Update';
        }
        document.getElementById(this.performActionButtonId).text = label;
    }

    setDefaultButton(label) {
        if (typeof (label) === 'undefined') {
            label = 'Update';
        }
        // this is a delete safeguard mechanism that just calls performDelete if
        // the user clicks the button again
        document.getElementById(this.confirmActionButtonId).outerHTML = '<a id="' + this.performActionButtonId + '" class="ibm-btn-pri ibm-bee-link ibm-btn-red-50" href="#">' + label + '</a>';
    }

    setConfirmButton() {
        // this is a delete safeguard mechanism that just calls performDelete if
        // the user clicks the button again
        document.getElementById(this.performActionButtonId).outerHTML = '<button type="button" id="' + this.confirmActionButtonId + '" class="ibm-btn-pri ibm-btn-red-50" onclick="#">Click Again To Confirm Action</button>';
    }

    getSelectedValue() {
        var value = $('#' + this.modalId + ' #' + this.field).val();
        return value;
    }

    show() {
        //show the overlay
        IBMCore.common.widget.overlay.show(this.modalId);
    }

    hide() {
        //hide the overlay
        IBMCore.common.widget.overlay.hide(this.modalId, true);
    }

    listenForPerformAction() {
        var $this = this;
        $(document).on('click', '#' + this.modalId + ' #' + this.performActionButtonId, function (e) {
            e.preventDefault();

            $this.action.confirmAction();
        });
    }

    listenForConfirmAction() {
        var $this = this;
        $(document).on('click', '#' + this.modalId + ' #' + this.confirmActionButtonId, function (e) {
            e.preventDefault();

            $this.hide();
            $this.action.performAction();
        });
    }
}

export { massAdminActionModal as default };

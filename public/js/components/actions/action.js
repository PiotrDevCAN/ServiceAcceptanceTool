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
let OverlayInfoModal = await cacheBustImport('../forms/overlayInfoModal.js');
let MassActionModal = await cacheBustImport('../forms/massUpdate/massActionModal.js');

class action {

    static emptyQueue = 'Firstly, select all items from table below, that you would like to modify!';
    static emptyAssignmentQueue = 'Firstly, select an appropriate item for re-assignment.';
    static itemsUpdated = 'item(s) will be updated';
    static itemsInserted = 'item(s) will be inserted';

    static actionType = 'Update';

    buttonHandler;

    infoModal;
    Container;
    typeOfAction;
    url;
    modal;

    constructor(Container, actionType, singleAction, modal) {
        this.infoModal = OverlayInfoModal;
        this.Container = Container;
        this.typeOfAction = actionType;
        // URL of a backend listener to handle the action
        this.url = this.typeOfAction.url;
        this.buttonHandler = singleAction.buttonHandler;
        if (typeof (modal) !== 'undefined') {
            this.modal = modal;
        } else {
            this.modal = MassActionModal;
        }

    }

    listenForAction() {
        var $this = this;
        var wrapperId = $this.Container.getWrapperId();
        $(document).on('click', wrapperId + ' ' + $this.buttonHandler, function (e) {
            e.preventDefault();

            $this.startAction();
        });
    }


    startAction() {

    }

    confirmAction() {

    }

    performAction() {

    }
}

export { action as default };

/*
 *
 *
 *
 */

class overlayInfoModal {

    static modalId = 'overlayInfo';
    static modalContentId = 'overlayInfoContent';

    constructor() {
        console.log('+++ Function +++ overlayInfoModal.constructor');

        console.log('--- Function --- overlayInfoModal.constructor');
    }

    setContent(content) {
        // populate the div or span in the overlay
        document.getElementById(overlayInfoModal.modalContentId).innerHTML = content;
    }

    show() {
        //show the overlay
        IBMCore.common.widget.overlay.show(overlayInfoModal.modalId);
    }

    hide() {
        //hide the overlay
        IBMCore.common.widget.overlay.hide(overlayInfoModal.modalId, true);
    }
}

const OverlayInfoModal = new overlayInfoModal();

export { OverlayInfoModal as default };

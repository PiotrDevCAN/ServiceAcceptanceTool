
let OverlayInfoModal = await cacheBustImport('../forms/overlayInfoModal.js');

function validateForm(modal, callback) {

    if (typeof modal.formElement !== 'undefined') {
        console.log('set form');
    }
    if (typeof callback !== 'undefined') {
        console.log('set successCallback');
    }

    var formElement = modal.formElement;
    if (formElement) {
        var formValid = formElement.checkValidity();
        if (formValid) {
            callback(modal);
        } else {
            var message = 'Fulfill all required fields in the form, please';

            OverlayInfoModal.setContent(message);
            OverlayInfoModal.show();
        }
    }
}

export { validateForm as default };

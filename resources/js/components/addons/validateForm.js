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
            formElement.reportValidity();
            var message = 'Fulfill all required fields in the form, please';
            // populate the div or span in the overlay
            document.getElementById("overlayInfoContent").innerHTML = message;
            //show the overlay
            IBMCore.common.widget.overlay.show('overlayInfo');
        }
    }
}

export { validateForm as default };

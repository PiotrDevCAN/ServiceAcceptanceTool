/*
 *
 *
 *
 */

let massAdminActionModal = await cacheBustImport('../forms/massAdminActionModal.js');

class massActionModal extends massAdminActionModal {

    static modalId = 'massUpdateActionModal';
    static modalContentId = 'massUpdateActionModalContent';
    static performActionButtonId = 'performAction';
    static confirmActionButtonId = 'confirmAction';
    static field = '';

    constructor() {
        console.log('+++ Function +++ massActionModal.constructor');
        super(massActionModal);
        console.log('--- Function --- massActionModal.constructor');
    }
}

const MassActionModal = new massActionModal();

export { MassActionModal as default };

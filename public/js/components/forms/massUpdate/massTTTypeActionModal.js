/*
 *
 *
 *
 */

let massAdminActionModal = await cacheBustImport('../forms/massAdminActionModal.js');

class massTTTypeActionModal extends massAdminActionModal {

    static modalId = 'massUpdateTTTypeActionModal';
    static modalContentId = 'massUpdateTTTypeActionModalContent';
    static performActionButtonId = 'performActionUpdateTTType';
    static confirmActionButtonId = 'confirmActionUpdateTTType';
    static field = 'type';

    constructor() {
        console.log('+++ Function +++ massTTTypeActionModal.constructor');
        super(massTTTypeActionModal);
        console.log('--- Function --- massTTTypeActionModal.constructor');
    }
}

const MassTTTypeActionModal = new massTTTypeActionModal();

export { MassTTTypeActionModal as default };

/*
 *
 *
 *
 */

let massAdminActionModal = await cacheBustImport('../forms/massAdminActionModal.js');

class massParentActionModal extends massAdminActionModal {

    static modalId = 'massUpdateParentActionModal';
    static modalContentId = 'massUpdateParentActionContent';
    static performActionButtonId = 'performActionUpdateParent';
    static confirmActionButtonId = 'confirmActionUpdateParent';
    static field = 'parent_id';

    constructor() {
        console.log('+++ Function +++ massParentActionModal.constructor');
        super(massParentActionModal);
        console.log('--- Function --- massParentActionModal.constructor');
    }
}

const MassParentActionModal = new massParentActionModal();

export { MassParentActionModal as default };

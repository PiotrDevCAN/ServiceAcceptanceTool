/*
 *
 *
 *
 */

let massAdminActionModal = await cacheBustImport('../forms/massAdminActionModal.js');

class massSectionActionModal extends massAdminActionModal {

    static modalId = 'massUpdateSectionActionModal';
    static modalContentId = 'massUpdateSectionActionModalContent';
    static performActionButtonId = 'performActionUpdateSection';
    static confirmActionButtonId = 'confirmActionUpdateSection';
    static field = 'section_id';

    constructor() {
        console.log('+++ Function +++ massSectionActionModal.constructor');
        super(massSectionActionModal);
        console.log('--- Function --- massSectionActionModal.constructor');
    }
}

const MassSectionActionModal = new massSectionActionModal();

export { MassSectionActionModal as default };

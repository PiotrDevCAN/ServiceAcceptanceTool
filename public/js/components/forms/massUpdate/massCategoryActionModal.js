/*
 *
 *
 *
 */

let massAdminActionModal = await cacheBustImport('../forms/massAdminActionModal.js');

class massCategoryActionModal extends massAdminActionModal {

    static modalId = 'massUpdateCategoryActionModal';
    static modalContentId = 'massUpdateCategoryActionModalContent';
    static performActionButtonId = 'performActionUpdateCategory';
    static confirmActionButtonId = 'confirmActionUpdateCategory';
    static field = 'category_id';

    constructor() {
        console.log('+++ Function +++ massCategoryActionModal.constructor');
        super(massCategoryActionModal);
        console.log('--- Function --- massCategoryActionModal.constructor');
    }
}

const MassCategoryActionModal = new massCategoryActionModal();

export { MassCategoryActionModal as default };

/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/admin/actionsContainer.js');

let changeCategory = await cacheBustImport('../actions/admin/service/TTYes/changeCategory.js');
let changeSection = await cacheBustImport('../actions/admin/service/TTYes/changeSection.js');
let deleteSelected = await cacheBustImport('../actions/admin/service/TTYes/delete.js');

class TTYesActionsContainer extends actionsContainer {

    constructor(wrapperId, action1Modal, action2Modal) {
        super(wrapperId);
        const ChangeCategory = new changeCategory(this, action1Modal);
        const ChangeService = new changeSection(this, action2Modal);
        const DeleteSelected = new deleteSelected(this);
    }
}

export { TTYesActionsContainer as default };

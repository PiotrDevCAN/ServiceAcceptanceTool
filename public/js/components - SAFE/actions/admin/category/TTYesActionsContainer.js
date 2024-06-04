/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/admin/actionsContainer.js');

let changeParent = await cacheBustImport('../actions/admin/category/changeParentTTYes.js');
let changeTTType = await cacheBustImport('../actions/admin/category/changeTTTypeTTYes.js');
let deleteSelected = await cacheBustImport('../actions/admin/category/deleteTTYes.js');

class TTYesActionsContainer extends actionsContainer {

    selectedItemsMap = new Array();

    constructor(wrapperId, action1Modal, action2Modal) {
        super(wrapperId);
        const ChangeParent = new changeParent(this, action1Modal);
        const ChangeTTType = new changeTTType(this, action2Modal);
        const DeleteSelected = new deleteSelected(this);
    }
}

export { TTYesActionsContainer as default };

/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/admin/actionsContainer.js');

let changeParent = await cacheBustImport('../actions/admin/category/changeParentTTNo.js');
let changeTTType = await cacheBustImport('../actions/admin/category/changeTTTypeTTNo.js');
let deleteSelected = await cacheBustImport('../actions/admin/category/deleteTTNo.js');

class TTNoActionsContainer extends actionsContainer {

    selectedItemsMap = new Array();

    constructor(wrapperId, action1Modal, action2Modal) {
        super(wrapperId);
        const ChangeParent = new changeParent(this, action1Modal);
        const ChangeTTType = new changeTTType(this, action2Modal);
        const DeleteSelected = new deleteSelected(this);
    }
}

export { TTNoActionsContainer as default };

/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/admin/actionsContainer.js');

let changeParent = await cacheBustImport('../actions/admin/category/TTNo/changeParent.js');
let changeTTType = await cacheBustImport('../actions/admin/category/TTNo/changeType.js');
let deleteSelected = await cacheBustImport('../actions/admin/category/TTNo/delete.js');

class TTNoActionsContainer extends actionsContainer {

    constructor(wrapperId, action1Modal, action2Modal) {
        super(wrapperId);
        const ChangeParent = new changeParent(this, action1Modal);
        const ChangeTTType = new changeTTType(this, action2Modal);
        const DeleteSelected = new deleteSelected(this);
    }
}

export { TTNoActionsContainer as default };

/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/admin/actionsContainer.js');

let changeCategory = await cacheBustImport('../actions/admin/service/changeCategoryTTNo.js');
let changeSection = await cacheBustImport('../actions/admin/service/changeSectionTTNo.js');
let deleteSelected = await cacheBustImport('../actions/admin/service/deleteTTNo.js');

class TTNoActionsContainer extends actionsContainer {

    selectedItemsMap = new Array();

    constructor(wrapperId, action1Modal, action2Modal) {
        super(wrapperId);
        const ChangeCategory = new changeCategory(this, action1Modal);
        const ChangeService = new changeSection(this, action2Modal);
        const DeleteSelected = new deleteSelected(this);
    }
}

export { TTNoActionsContainer as default };

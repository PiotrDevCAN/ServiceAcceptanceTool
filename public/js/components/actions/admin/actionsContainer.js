/*
 *
 *
 *
 */

let topActionsContainer = await cacheBustImport('../actions/actionsContainer.js');

class actionsContainer extends topActionsContainer {

    constructor(wrapperId) {
        super(wrapperId);
    }

    setDataForAction(data) {
        this.value = data.id;
        this.list = this.getSelectedItemsMap();
    }
}

export { actionsContainer as default };

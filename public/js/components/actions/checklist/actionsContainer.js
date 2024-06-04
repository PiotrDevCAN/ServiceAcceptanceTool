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
        if (typeof (data.pivot_id) == 'undefined' || data.pivot_id === '') {
            this.value = data.id;
            this.list = this.getCreateItemsMap();
        } else {
            this.value = data.pivot_id;
            this.list = this.getSelectedItemsMap();
        }
    }
}

export { actionsContainer as default };

/*
 *
 *
 *
 */

class actionsContainer {

    wrapperId;
    list;
    value;

    createItemsMap = new Array();
    selectedItemsMap = new Array();

    constructor(wrapperId) {
        this.wrapperId = wrapperId;
    }

    getWrapperId() {
        return this.wrapperId;
    }

    getCreateItemsMap() {
        return this.createItemsMap;
    }

    getSelectedItemsMap() {
        return this.selectedItemsMap;
    }

    setDataForAction(data) {

    }

    addToList(data) {
        this.setDataForAction(data);
        this.list.push(this.value);
    }

    removeFromList(data) {
        this.setDataForAction(data);
        var index = this.list.indexOf(this.value);
        this.list.splice(index, 1);
    }
}

export { actionsContainer as default };

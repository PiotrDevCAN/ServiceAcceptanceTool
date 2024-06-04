/*
 *
 *
 *
 */

class actionsContainer {

    list;
    value;
    wrapperId;

    selectedItemsMap;

    constructor(wrapperId) {
        this.wrapperId = wrapperId;
    }

    getWrapperId() {
        return this.wrapperId;
    }

    getSelectedItemsMap() {
        return this.selectedItemsMap;
    }

    setActionForData(data) {
        this.value = data.id;
        this.list = this.selectedItemsMap;
    }

    addToList(data) {
        this.setActionForData(data);
        this.list.push(this.value);
    }

    removeFromList(data) {
        this.setActionForData(data);
        var index = this.list.indexOf(this.value);
        this.list.splice(index, 1);
    }
}

export { actionsContainer as default };

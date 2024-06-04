/*
 *
 *
 *
 */

class actionsContainer {

    list = 'assigned in setActionForData';
    value = 'assigned in setActionForData';
    wrapperId = 'assigned in constructor';

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

    setActionForData(data) {
        if (typeof (data.pivot_id) == 'undefined' || data.pivot_id === '') {
            this.value = data.id;
            this.list = this.createItemsMap;
        } else {
            this.value = data.pivot_id;
            this.list = this.selectedItemsMap;
        }
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

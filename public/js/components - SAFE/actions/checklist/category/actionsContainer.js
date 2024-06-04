/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/checklist/actionsContainer.js');

let markCompleted = await cacheBustImport('../actions/checklist/category/markCompleted.js');
let markNotCompleted = await cacheBustImport('../actions/checklist/category/markNotCompleted.js');
let markInScope = await cacheBustImport('../actions/checklist/category/markInScope.js');
let markNotInScope = await cacheBustImport('../actions/checklist/category/markNotInScope.js');

class categoriesActionsContainer extends actionsContainer {

    createItemsMap = new Array();
    selectedItemsMap = new Array();

    constructor(wrapperId) {
        super(wrapperId);
        const MarkCompleted = new markCompleted(this);
        const MarkNotCompleted = new markNotCompleted(this);
        const MarkInScope = new markInScope(this);
        const MarkNotInScope = new markNotInScope(this);
    }
}

export { categoriesActionsContainer as default };

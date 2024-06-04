/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/checklist/actionsContainer.js');

let markInScopeYes = await cacheBustImport('../actions/checklist/service/markInScopeYes.js');
let markInScopeNo = await cacheBustImport('../actions/checklist/service/markInScopeNo.js');
let markNotInScope = await cacheBustImport('../actions/checklist/service/markNotInScope.js');

class servicesActionsContainer extends actionsContainer {

    createItemsMap = new Array();
    selectedItemsMap = new Array();

    constructor(wrapperId) {
        super(wrapperId);
        const MarkInScopeYes = new markInScopeYes(this);
        const MarkInScopeNo = new markInScopeNo(this);
        const MarkNotInScope = new markNotInScope(this);
    }
}

export { servicesActionsContainer as default };

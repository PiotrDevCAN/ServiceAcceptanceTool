/*
 *
 *
 *
 */

let checklistAction = await cacheBustImport('../actions/checklist/action.js');

class action extends checklistAction {

    static url = window.apiUrl + "checklist-category/mass-update";

    constructor(Container, singleAction) {
        super(Container, action, singleAction);
    }
}

export { action as default };

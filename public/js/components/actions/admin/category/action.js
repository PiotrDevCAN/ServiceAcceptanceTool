/*
 *
 *
 *
 */

let adminAction = await cacheBustImport('../actions/admin/action.js');

class action extends adminAction {

    static url = window.apiUrl + "category/mass-update";

    constructor(Container, singleAction, modal) {
        super(Container, action, singleAction, modal);
    }
}

export { action as default };

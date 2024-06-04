/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class changeTTTypeTTYes extends action {

    static buttonId = '#change_tt_type_tt_yes';

    constructor(Container, modal) {
        super(Container, changeTTTypeTTYes, modal);
    }
}

export { changeTTTypeTTYes as default };

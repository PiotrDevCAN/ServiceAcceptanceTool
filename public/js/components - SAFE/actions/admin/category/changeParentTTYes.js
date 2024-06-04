/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class changeParentTTYes extends action {

    static buttonId = '#change_parent_category_tt_yes';

    constructor(Container, modal) {
        super(Container, changeParentTTYes, modal);
    }
}

export { changeParentTTYes as default };

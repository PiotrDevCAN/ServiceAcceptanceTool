/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class changeParentTTNo extends action {

    static buttonId = '#change_parent_category_tt_no';

    constructor(Container, modal) {
        super(Container, changeParentTTNo, modal);
    }
}

export { changeParentTTNo as default };

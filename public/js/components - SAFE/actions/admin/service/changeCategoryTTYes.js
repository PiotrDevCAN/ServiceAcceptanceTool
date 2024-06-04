/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/service/action.js');

class changeCategoryTTYes extends action {

    static buttonId = '#change_category_tt_yes';

    constructor(Container, modal) {
        super(Container, changeCategoryTTYes, modal);
    }
}

export { changeCategoryTTYes as default };

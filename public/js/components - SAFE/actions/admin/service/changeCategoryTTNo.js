/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/service/action.js');

class changeCategoryTTNo extends action {

    static buttonId = '#change_category_tt_no';

    constructor(Container, modal) {
        super(Container, changeCategoryTTNo, modal);
    }
}

export { changeCategoryTTNo as default };

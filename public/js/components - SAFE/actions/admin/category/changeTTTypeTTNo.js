/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class changeTTTypeTTNo extends action {

    static buttonId = '#change_tt_type_tt_no';

    constructor(Container, modal) {
        super(Container, changeTTTypeTTNo, modal);
    }
}

export { changeTTTypeTTNo as default };

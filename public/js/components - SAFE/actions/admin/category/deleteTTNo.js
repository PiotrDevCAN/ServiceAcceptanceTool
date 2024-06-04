/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class deleteTTNo extends action {

    static buttonId = '#delete_category_tt_no';
    static actionType = 'Delete';

    constructor(Container) {
        super(Container, deleteTTNo);
    }
}

export { deleteTTNo as default };

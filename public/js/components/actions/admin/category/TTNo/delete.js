/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class deleteTTNo extends action {

    static buttonHandler = '#delete_category_tt_no';
    static actionType = 'Delete';

    constructor(Container) {
        super(Container, deleteTTNo);
    }
}

export { deleteTTNo as default };

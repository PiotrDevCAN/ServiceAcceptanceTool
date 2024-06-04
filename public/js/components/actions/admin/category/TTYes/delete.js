/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/category/action.js');

class deleteTTYes extends action {

    static buttonHandler = '#delete_category_tt_yes';
    static actionType = 'Delete';

    constructor(Container) {
        super(Container, deleteTTYes);
    }
}

export { deleteTTYes as default };

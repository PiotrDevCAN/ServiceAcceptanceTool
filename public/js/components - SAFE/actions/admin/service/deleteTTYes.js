/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/service/action.js');

class deleteTTYes extends action {

    static buttonId = '#delete_service_tt_yes';
    static actionType = 'Delete';

    constructor(Container) {
        super(Container, deleteTTYes);
    }
}

export { deleteTTYes as default };

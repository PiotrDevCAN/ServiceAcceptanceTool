/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/service/action.js');

class deleteTTNo extends action {

    static buttonHandler = '#delete_service_tt_no';
    static actionType = 'Delete';

    constructor(Container) {
        super(Container, deleteTTNo);
    }
}

export { deleteTTNo as default };

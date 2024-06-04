/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/section/action.js');

class deleteSelected extends action {

    static buttonHandler = '#delete_section';
    static actionType = 'Delete';

    constructor(Container) {
        super(Container, deleteSelected);
    }
}

export { deleteSelected as default };

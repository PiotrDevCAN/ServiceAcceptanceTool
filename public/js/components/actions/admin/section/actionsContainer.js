/*
 *
 *
 *
 */

let actionsContainer = await cacheBustImport('../actions/admin/actionsContainer.js');

let deleteSelected = await cacheBustImport('../actions/admin/section/delete.js');

class sectionsActionsContainer extends actionsContainer {

    constructor(wrapperId) {
        super(wrapperId);
        const DeleteSelected = new deleteSelected(this);
    }
}

export { sectionsActionsContainer as default };

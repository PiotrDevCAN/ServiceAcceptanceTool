/*
 *
 *
 *
 */

import AccessesModal from "./forms/accessesModal.js";
import table from "./addons/tableWithModal.js";

class accessRequests {

    constructor() {
        console.log('+++ Function +++ accessRequests.constructor');

        var dataTables = $('#accessesPendingTable, #accessesApprovedTable, #accessesRejectedTable');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, AccessesModal);
        }

        console.log('--- Function --- accessRequests.constructor');
    }
}

if ($('#accessesPendingTable, #accessesApprovedTable, #accessesRejectedTable').length != 0) {
    const AccessRequests = new accessRequests();
} else {
    console.log('skip accessRequests.constructor');
}

export { accessRequests as default };

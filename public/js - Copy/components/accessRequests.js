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

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, AccessesModal);
        }

        console.log('--- Function --- accessRequests.constructor');
    }
}

const AccessRequests = new accessRequests();

export { AccessRequests as default };

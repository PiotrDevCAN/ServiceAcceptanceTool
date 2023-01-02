/*
 *
 *
 *
 */

import table from "./addons/tableWithNotification.js";

class accessRequestsManage {

    constructor() {
        console.log('+++ Function +++ accessRequestsManage.constructor');

        var dataTables = $('#accessesTable');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId);
        }

        console.log('--- Function --- accessRequestsManage.constructor');
    }
}

if ($('#accessesTable').length != 0) {
    const AccessRequestsManage = new accessRequestsManage();
} else {
    console.log('skip accessRequestsManage.constructor');
}

export { accessRequestsManage as default };

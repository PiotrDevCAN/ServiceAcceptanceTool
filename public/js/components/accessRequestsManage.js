/*
 *
 *
 *
 */

import table from "./addons/tableWithNotification.js";

class accessRequestsManage {

    constructor() {
        console.log('+++ Function +++ accessRequestsManage.constructor');

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId);
        }

        console.log('--- Function --- accessRequestsManage.constructor');
    }
}

const AccessRequestsManage = new accessRequestsManage();

export { AccessRequestsManage as default };

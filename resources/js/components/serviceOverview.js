/*
 *
 *
 *
 */

import table from "./addons/tableWithRedirection.js";

class serviceOverview {

    constructor() {
        console.log('+++ Function +++ serviceOverview.constructor');

        var page = '/ServiceAcceptanceTool/checklist/overview/';
        var dataTables = $('#serviceOverviewAccount .ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, page);
        }

        console.log('--- Function --- serviceOverview.constructor');
    }
}

if ($('#serviceOverviewAccount').length != 0) {
    const ServiceOverview = new serviceOverview();
} else {
    console.log('skip serviceOverview.constructor');
}

export { serviceOverview as default };

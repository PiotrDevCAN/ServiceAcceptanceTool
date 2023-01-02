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
        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, page);
        }

        console.log('--- Function --- serviceOverview.constructor');
    }
}

const ServiceOverview = new serviceOverview();

export { serviceOverview as default };

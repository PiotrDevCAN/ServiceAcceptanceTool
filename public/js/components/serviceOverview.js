/*
 *
 *
 *
 */

import isAdminSection from "./addons/isAdminSection.js";
import table from "./addons/tableWithRedirection.js";

class serviceOverview {

    constructor() {
        console.log('+++ Function +++ serviceOverview.constructor');

        if (isAdminSection()) {
            var page = window.appUrl + '/admin/checklist/overview/';
        } else {
            var page = window.appUrl + '/checklist/overview/';
        }
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

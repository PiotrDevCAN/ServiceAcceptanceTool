/*
 *
 *
 *
 */

import isAdminSection from "./addons/isAdminSection.js";
import table from "./addons/tableWithRedirection.js";

class checkLists {

    constructor() {
        console.log('+++ Function +++ checkLists.constructor');

        if (isAdminSection()) {
            var page = window.appUrl + '/admin/checklist/edit/';
        } else {
            var page = window.appUrl + '/checklist/edit/';
        }
        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, page);
        }

        console.log('--- Function --- checkLists.constructor');
    }
}

const CheckLists = new checkLists();

export { checkLists as default };

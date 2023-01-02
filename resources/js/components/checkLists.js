/*
 *
 *
 *
 */

import table from "./addons/tableWithRedirection.js";

class checkLists {

    constructor() {
        console.log('+++ Function +++ checkLists.constructor');

        var page = '/ServiceAcceptanceTool/checklist/edit/';
        var dataTables = $('#checklistIndex .ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, page);
        }

        console.log('--- Function --- checkLists.constructor');
    }
}

if ($('#checklistIndex').length != 0) {
    const CheckLists = new checkLists();
} else {
    console.log('skip checkLists.constructor');
}

export { checkLists as default };

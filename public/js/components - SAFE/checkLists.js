/*
 *
 *
 *
 */

let isAdminSection = await cacheBustImport('../addons/isAdminSection.js');
let table = await cacheBustImport('../tables/tableWithRedirection.js');

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
            if (typeof (tableId) !== 'undefined') {
                var Table = new table('#' + tableId, page);
            }
        }

        console.log('--- Function --- checkLists.constructor');
    }
}

const CheckLists = new checkLists();

export { checkLists as default };

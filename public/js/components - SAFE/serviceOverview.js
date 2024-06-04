/*
 *
 *
 *
 */

let isAdminSection = await cacheBustImport('../addons/isAdminSection.js');
let table = await cacheBustImport('../tables/tableWithRedirection.js');

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
            if (typeof (tableId) !== 'undefined') {
                var Table = new table('#'+tableId, page);
            }
        }

        console.log('--- Function --- serviceOverview.constructor');
    }
}

const ServiceOverview = new serviceOverview();

export { serviceOverview as default };

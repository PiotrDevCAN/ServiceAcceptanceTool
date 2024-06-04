/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');
let AccessesModal = await cacheBustImport('../forms/singleEdit/accessesModal.js');

class accessRequests {

    constructor() {
        console.log('+++ Function +++ accessRequests.constructor');

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            if (typeof (tableId) !== 'undefined') {
                var Table = new table('#' + tableId, AccessesModal);
            }
        }

        console.log('--- Function --- accessRequests.constructor');
    }
}

const AccessRequests = new accessRequests();

export { AccessRequests as default };

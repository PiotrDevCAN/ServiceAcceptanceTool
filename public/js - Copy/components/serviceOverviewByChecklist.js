/*
 *
 *
 *
 */

// import isObjectEmpty from "./addons/isObjectEmpty.js";
// import showHideSpinner from "./addons/spinner.js";
// import options from "./addons/datePickerOptions.js";

import PendingServicesModal from "./forms/pendingServicesModal.js";
import table from "./addons/tableWithModal.js";

class serviceOverviewByChecklist {

    static formId = '#serviceForm';
    static type = 'checklist-service';
    static rootType = 'service';
    static modalId = 'editServiceModal';

    constructor() {
        console.log('+++ Function +++ serviceOverviewByChecklist.constructor');

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, PendingServicesModal);
        }

        console.log('--- Function --- serviceOverviewByChecklist.constructor');
    }
}

const ServiceOverviewByChecklist = new serviceOverviewByChecklist();

export { serviceOverviewByChecklist as default };

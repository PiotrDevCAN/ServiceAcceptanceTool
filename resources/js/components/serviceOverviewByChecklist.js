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

        var dataTables = $('#categories-overview .ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, PendingServicesModal);
        }

        console.log('--- Function --- serviceOverviewByChecklist.constructor');
    }
}

if ($('#categories-overview').length != 0) {
    const ServiceOverviewByChecklist = new serviceOverviewByChecklist();
} else {
    console.log('skip serviceOverviewByChecklist.constructor');
}

export { serviceOverviewByChecklist as default };

/*
 *
 *
 *
 */

import table from "./addons/tableWithModal.js";

import CheckListsModal from "./forms/checkListsModal.js";
import accountStatusBarChart from "./addons/accountStatusBarChart.js";
import accountStatusPieChart from "./addons/accountStatusPieChart.js";
import PendingServicesModal from "./forms/pendingServicesModal.js";
import ServicesOverviewModal from "./forms/servicesOverviewModal.js";

class checkList {

    // from DATA
    overviewtableId = '#servicesOverviewTable';

    // by ID
    pendingTableId = '#pendingServicesTable';

    constructor() {
        console.log('+++ Function +++ checkList.constructor');

        var checklist_id = $('#checklist_id').val();
        if (typeof (checklist_id) !== 'undefined') {
            const bar = new accountStatusBarChart(checklist_id);
            const pie = new accountStatusPieChart(checklist_id);
        }

        var ServiceOverviewTable = new table(this.overviewtableId, ServicesOverviewModal);
        var PendingItemsTable = new table(this.pendingTableId, PendingServicesModal);

        console.log('--- Function --- checkList.constructor');
    }
}

// if ($('#accessesPendingTable, #accessesApprovedTable, #accessesRejectedTable').length != 0) {
//     const CheckList = new checkList();
// } else {
//     console.log('skip checkList.constructor');
// }

export { checkList as default };

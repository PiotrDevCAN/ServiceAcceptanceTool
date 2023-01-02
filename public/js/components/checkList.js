/*
 *
 *
 *
 */

import table from "./addons/tableWithModal.js";

import checkListsModal from "./forms/checkListsModal.js";
import accountStatusBarChart from "./addons/accountStatusBarChart.js";
import accountStatusPieChart from "./addons/accountStatusPieChart.js";
import pendingServicesModal from "./forms/pendingServicesModal.js";
import servicesOverviewModal from "./forms/servicesOverviewModal.js";

class checkList {

    // from DATA
    overviewtableId = '#servicesOverviewTable';

    // by ID
    pendingTableId = '#pendingServicesTable';

    constructor() {
        console.log('+++ Function +++ checkList.constructor');

        var checklist_id = $('#checklist_id').val();
        if (checklist_id !== '') {
            const bar = new accountStatusBarChart(checklist_id);
            const pie = new accountStatusPieChart(checklist_id);
        }

        var ServiceOverviewTable = new table(this.overviewtableId, servicesOverviewModal);

        var PendingItemsTable = new table(this.pendingTableId, pendingServicesModal);

        console.log('--- Function --- checkList.constructor');
    }
}

const CheckList = new checkList();

export { checkList as default };

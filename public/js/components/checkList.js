/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');

let CheckListsModal = await cacheBustImport('../forms/singleEdit/checkListsModal.js');
let accountStatusBarChart = await cacheBustImport('../addons/accountStatusBarChart.js');
let accountStatusPieChart = await cacheBustImport('../addons/accountStatusPieChart.js');

let ServicesOverviewModal = await cacheBustImport('../forms/singleEdit/servicesOverviewModal.js');
let PendingServicesModal = await cacheBustImport('../forms/singleEdit/pendingServicesModal.js');

let servicesOverviewActions = await cacheBustImport('../actions/checklist/category/actionsContainer.js');
let pendingServicesActions = await cacheBustImport('../actions/checklist/service/actionsContainer.js');

class checkList {

    // from DATA
    static overviewTableId = '#servicesOverviewTable';
    static overviewTabId = '#services-overview';

    // by ID
    static pendingTableId = '#pendingServicesTable';
    static pendingTabId = '#services-pending';

    constructor() {
        console.log('+++ Function +++ checkList.constructor');

        var checklist_id = $('#checklist_id').val();
        if (checklist_id !== '') {
            const Bar = new accountStatusBarChart(checklist_id);
            const Pie = new accountStatusPieChart(checklist_id);
        }

        // pass actions to table
        const ServicesOverviewActions = new servicesOverviewActions(checkList.overviewTabId);
        var ServiceOverviewTable = new table(checkList.overviewTableId, ServicesOverviewModal, ServicesOverviewActions);

        // pass actions to table
        const PendingServicesActions = new pendingServicesActions(checkList.pendingTabId);
        var PendingItemsTable = new table(checkList.pendingTableId, PendingServicesModal, PendingServicesActions);

        this.listenForTabSelection();

        console.log('--- Function --- checkList.constructor');
    }

    listenForTabSelection() {
        var hash = window.location.hash, //get the hash from url
            cleanhash = hash.replace("#", ""); //remove the #
        if (cleanhash !== '') {
            $("[href='#" + cleanhash + "']").trigger('click');
        }
    }
}

const CheckList = new checkList();

export { checkList as default };

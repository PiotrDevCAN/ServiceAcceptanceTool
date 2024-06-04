/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');

// let alterCategoryBtn = await cacheBustImport('../buttons/alterCategoryBtn.js');

let ServicesOverviewModal = await cacheBustImport('../forms/singleEdit/servicesOverviewModal.js');
let PendingServicesModal = await cacheBustImport('../forms/singleEdit/pendingServicesModal.js');

let categoriesServicesActions = await cacheBustImport('../actions/checklist/service/actionsContainer.js');

class serviceOverviewByChecklist {

    static formId = '#serviceForm';
    static type = 'checklist-service';
    static rootType = 'service';
    static modalId = 'editServiceModal';

    constructor() {
        console.log('+++ Function +++ serviceOverviewByChecklist.constructor');

        // var AlterCategoryBtn = new alterCategoryBtn(ServicesOverviewModal);

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            if (typeof (tableId) !== 'undefined') {

                var wrapperId = '#' + tableId + '_container';

                // pass table to actions
                const CategoriesServicesActions = new categoriesServicesActions(wrapperId);

                var Table = new table('#' + tableId, PendingServicesModal, CategoriesServicesActions);
            }
        }

        this.listenForTabSelection();

        console.log('--- Function --- serviceOverviewByChecklist.constructor');
    }

    listenForTabSelection() {
        var hash = window.location.hash, //get the hash from url
            cleanhash = hash.replace("#", ""); //remove the #
        if (cleanhash !== '') {
            $("#category_heading_" + cleanhash + " a").trigger('click');
        }
    }
}

const ServiceOverviewByChecklist = new serviceOverviewByChecklist();

export { serviceOverviewByChecklist as default };

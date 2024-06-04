/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');
let ServicesModal = await cacheBustImport('../forms/singleEdit/servicesModal.js');

let MassCategoryActionModal = await cacheBustImport('../forms/massUpdate/massCategoryActionModal.js');
let MassSectionActionModal = await cacheBustImport('../forms/massUpdate/massSectionActionModal.js');

let servicesTTNoActions = await cacheBustImport('../actions/admin/service/TTNoActionsContainer.js');
let servicesTTYesActions = await cacheBustImport('../actions/admin/service/TTYesActionsContainer.js');

class services {

    constructor() {
        console.log('+++ Function +++ services.constructor');

        // pass table to actions
        const ServicesTTNoActions = new servicesTTNoActions('', MassCategoryActionModal, MassSectionActionModal);

        // pass table to actions
        const ServicesTTYesActions = new servicesTTYesActions('', MassCategoryActionModal, MassSectionActionModal);

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            if (typeof (tableId) !== 'undefined') {
                switch (tableId) {
                    case 'servicesTableNo':
                        var Table = new table('#' + tableId, ServicesModal, ServicesTTNoActions);
                        break;
                    case 'servicesTableYes':
                        var Table = new table('#' + tableId, ServicesModal, ServicesTTYesActions);
                        break;
                    default:
                        break;
                }
            }
        }

        console.log('--- Function --- services.constructor');
    }
}

const Services = new services();

export { services as default };

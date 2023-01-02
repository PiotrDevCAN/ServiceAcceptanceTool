/*
 *
 *
 *
 */

import table from "./addons/tableWithModal.js";
import ServicesModal from "./forms/servicesModal.js";

class services {

    constructor() {
        console.log('+++ Function +++ services.constructor');

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, ServicesModal);
        }

        console.log('--- Function --- services.constructor');
    }
}

const Services = new services();

export { services as default };

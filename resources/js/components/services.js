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

        var dataTables = $('#servicesTableYes, #servicesTableNo');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, ServicesModal);
        }

        console.log('--- Function --- services.constructor');
    }
}

if ($('#servicesTableYes, #servicesTableNo').length != 0) {
    const Services = new services();
} else {
    console.log('skip services.constructor');
}

export { services as default };

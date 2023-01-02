/*
 *
 *
 *
 */

import table from "./addons/tableWithModal.js";
import SectionsModal from "./forms/sectionsModal.js";

class sections {

    constructor() {
        console.log('+++ Function +++ sections.constructor');

        var dataTables = $('#sectionsTable');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, SectionsModal);
        }

        console.log('--- Function --- sections.constructor');
    }
}

if ($('#sectionsTable').length != 0) {
    const Sections = new sections();
} else {
    console.log('skip sections.constructor');
}

export { sections as default };

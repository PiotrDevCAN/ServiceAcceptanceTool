/*
 *
 *
 *
 */

import table from "./addons/tableWithModal.js";
import CategoriesModal from "./forms/categoriesModal.js";

class categories {

    constructor() {
        console.log('+++ Function +++ categories.constructor');

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, CategoriesModal);
        }

        console.log('--- Function --- categories.constructor');
    }
}

const Categories = new categories();

export { categories as default };

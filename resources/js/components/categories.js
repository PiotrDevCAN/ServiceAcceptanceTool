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

        var dataTables = $('#categoriesTableYes, #categoriesTableNo');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, CategoriesModal);
        }

        console.log('--- Function --- categories.constructor');
    }
}

if ($('#categoriesTableYes, #categoriesTableNo').length != 0) {
    const Categories = new categories();
} else {
    console.log('skip categories.constructor');
}

export { categories as default };

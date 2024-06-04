/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');
let CategoriesModal = await cacheBustImport('../forms/singleEdit/categoriesModal.js');

let MassParentActionModal = await cacheBustImport('../forms/massUpdate/massParentActionModal.js');
let MassTTTypeActionModal = await cacheBustImport('../forms/massUpdate/massTTTypeActionModal.js');

let categoriesTTNoActions = await cacheBustImport('../actions/admin/category/TTNo/actionsContainer.js');
let categoriesTTYesActions = await cacheBustImport('../actions/admin/category/TTYes/actionsContainer.js');

class categories {

    constructor() {
        console.log('+++ Function +++ categories.constructor');

        // pass actions to table
        const CategoriesTTNoActions = new categoriesTTNoActions('', MassParentActionModal, MassTTTypeActionModal);

        // pass actions to table
        const CategoriesTTYesActions = new categoriesTTYesActions('', MassParentActionModal, MassTTTypeActionModal);

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            if (typeof (tableId) !== 'undefined') {
                switch (tableId) {
                    case 'categoriesTableNo':
                        var Table = new table('#' + tableId, CategoriesModal, CategoriesTTNoActions);
                        break;
                    case 'categoriesTableYes':
                        var Table = new table('#' + tableId, CategoriesModal, CategoriesTTYesActions);
                        break;
                    default:
                        break;
                }
            }
        }

        console.log('--- Function --- categories.constructor');
    }
}

const Categories = new categories();

export { categories as default };

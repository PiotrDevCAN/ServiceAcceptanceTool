/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');
let CategoriesModal = await cacheBustImport('../forms/singleEdit/categoriesModal.js');

let MassParentActionModal = await cacheBustImport('../forms/massUpdate/massParentActionModal.js');
let MassTTTypeActionModal = await cacheBustImport('../forms/massUpdate/massTTTypeActionModal.js');

let categoriesTTNoActions = await cacheBustImport('../actions/admin/category/TTNoActionsContainer.js');
let categoriesTTYesActions = await cacheBustImport('../actions/admin/category/TTYesActionsContainer.js');

class categories {

    constructor() {
        console.log('+++ Function +++ categories.constructor');

        // pass table to actions
        const CategoriesTTNoActions = new categoriesTTNoActions('', MassParentActionModal, MassTTTypeActionModal);

        // pass table to actions
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

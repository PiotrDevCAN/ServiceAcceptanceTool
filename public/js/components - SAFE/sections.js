/*
 *
 *
 *
 */

let table = await cacheBustImport('../tables/tableWithModal.js');
let SectionsModal = await cacheBustImport('../forms/sectionsModal.js');

let sectionActions = await cacheBustImport('../actions/admin/section/actionsContainer.js');

class sections {

    constructor() {
        console.log('+++ Function +++ sections.constructor');

        // pass table to actions
        const SectionActions = new sectionActions('');

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            if (typeof (tableId) !== 'undefined') {
                var Table = new table('#' + tableId, SectionsModal, SectionActions);
            }
        }

        console.log('--- Function --- sections.constructor');
    }
}

const Sections = new sections();

export { sections as default };

/*
 *
 *
 *
 */

let isObjectEmpty = await cacheBustImport('../addons/isObjectEmpty.js');

class tableWithModal {

    tableId;
    formElement;
    action;

    constructor(tableId, form, action) {
        console.log('+++ Function +++ tableWithModal.constructor');

        this.tableId = tableId;
        this.formElement = form;
        this.action = action;

        this.listenForTableRowSelect();
        this.listenForCheckboxSelect();

        console.log('--- Function --- tableWithModal.constructor');
    }

    listenForTableRowSelect() {
        var $this = this;
        $(document).on('click', this.tableId + ' tbody tr', function (event) {
            var data = $(this).data();
            if (isObjectEmpty(data) !== true) {
                $this.formElement.showForm(data);
            }
        });
    }

    listenForCheckboxSelect() {
        var $this = this;

        $(document).on('click', this.tableId + ' tbody tr .ibm-checkbox-wrapper', function (event) {
            event.stopPropagation();
        });

        $(document).on('click', this.tableId + ' tbody tr :checkbox', function (event) {
            var row = $(this).closest("tr");
            var data = row.data();
            if ($(this).is(':checked')) {
                $this.action.addToList(data);
            } else {
                $this.action.removeFromList(data);
            }
        });
    }
}

export { tableWithModal as default };

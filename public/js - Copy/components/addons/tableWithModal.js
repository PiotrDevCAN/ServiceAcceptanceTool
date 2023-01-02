/*
 *
 *
 *
 */

// import EditModal from "../forms/editModal.js";
import isObjectEmpty from "./isObjectEmpty.js";

class tableWithModal {

    tableId;
    formElement;

    constructor(tableId, form) {
        console.log('+++ Function +++ tableWithModal.constructor');

        this.tableId = tableId;
        this.formElement = form;

        this.listenForTableRowSelect();

        console.log('--- Function --- tableWithModal.constructor');
    }

    listenForTableRowSelect() {
        var $this = this;
		$(document).on('click', this.tableId +' tbody tr', function (event) {
            var data = $(this).data();
            if (isObjectEmpty(data) !== true) {
                $this.formElement.showForm(data);
            }
		});
	}
}

export { tableWithModal as default };

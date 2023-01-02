/*
 *
 *
 *
 */

import isObjectEmpty from "./isObjectEmpty.js";

class tableWithRedirection {

    tableId;
    page;

    constructor(tableId, page) {
        console.log('+++ Function +++ tableWithRedirection.constructor');

        this.tableId = tableId;
        this.page = page;

        this.listenForTableRowSelect();

        console.log('--- Function --- tableWithRedirection.constructor');
    }

    listenForTableRowSelect() {
        var $this = this;
		$(document).on('click', $this.tableId+' tbody tr', function (event) {
            var data = $(this).data();
            if (isObjectEmpty(data) !== true) {
                location.href = $this.page+data.id;
            }
        });
    }
}

export { tableWithRedirection as default };

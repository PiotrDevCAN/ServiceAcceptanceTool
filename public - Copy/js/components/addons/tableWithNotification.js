/*
 *
 *
 *
 */

import isObjectEmpty from "./isObjectEmpty.js";

class tableWithNotification {

    tableId;

    constructor(tableId) {
        console.log('+++ Function +++ tableWithNotification.constructor');

        this.tableId = tableId;

        this.listenForTableRowSelect();

        console.log('--- Function --- tableWithNotification.constructor');
    }

    listenForTableRowSelect() {
        var $this = this;
		$(document).on('click', $this.tableId+' tbody tr', function (event) {

            var message = 'To manage listed entries please visit an appropriate page in the Admin section!';

            // populate the div or span in the overlay
            document.getElementById("overlayInfoContent").innerHTML = message;
            //show the overlay
            IBMCore.common.widget.overlay.show('overlayInfo');
        });
    }
}

export { tableWithNotification as default };

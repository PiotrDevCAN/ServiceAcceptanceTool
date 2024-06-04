/*
 *
 *
 *
 */

let OverlayInfoModal = await cacheBustImport('../forms/overlayInfoModal.js');

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
        $(document).on('click', $this.tableId + ' tbody tr', function (event) {

            var message = 'To manage listed entries please visit an appropriate page in the Admin section!';

            OverlayInfoModal.setContent(message);
            OverlayInfoModal.show();
        });
    }
}

export { tableWithNotification as default };

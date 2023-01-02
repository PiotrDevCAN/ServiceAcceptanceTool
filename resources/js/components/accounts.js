/*
 *
 *
 *
 */

import AccountsModal from "./forms/accountsModal.js";
import table from "./addons/tableWithModal.js";

class accounts {

    constructor() {
        console.log('+++ Function +++ accounts.constructor');

        var dataTables = $('#accountsTable');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, AccountsModal);
        }

        console.log('--- Function --- accounts.constructor');
    }
}


if ($('#accountsTable').length != 0) {
    const Accounts = new accounts();
} else {
    console.log('skip accounts.constructor');
}

export { accounts as default };

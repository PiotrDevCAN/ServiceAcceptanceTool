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

        var dataTables = $('.ibm-data-table');
        for (var n = 0; n < dataTables.length; n++) {
            var tableId = dataTables.eq(n).attr('id');
            var Table = new table('#'+tableId, AccountsModal);
        }

        console.log('--- Function --- accounts.constructor');
    }
}

const Accounts = new accounts();

export { accounts as default };

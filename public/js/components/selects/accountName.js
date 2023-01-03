/**
 *
 */

import setSelect2 from "./setSelect2.js";
import AccountNames from "../dataSources/accountNames.js";

class accountNamesSelect {

    id = 'account';

    constructor() {

    }

    async prepareDataForSelect() {
        var data = await AccountNames.getUnits();
        setSelect2(this.id, data);
    }
}

const AccountNamesSelect = new accountNamesSelect();
await AccountNamesSelect.prepareDataForSelect();

export { AccountNamesSelect as default };

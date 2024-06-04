/**
 *
 */

let setSelect2 = await cacheBustImport('../selects/setSelect2.js');
let AccountNames = await cacheBustImport('../dataSources/accountNames.js');

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

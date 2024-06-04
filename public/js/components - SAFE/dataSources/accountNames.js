/**
 *
 */

// let APIData = await cacheBustImport('../fetch/accountNames.js');
let mapper = await cacheBustImport('../addons/select2dataMapper.js');

class accountNames {

    names = [];

    constructor() {

    }

    async getUnits() {
        // await for API data
        // var dataRaw = await APIData.data;
        var dataRaw = await fetch(window.apiUrl + "account/list")
            .then((response) => response.json())
            // second then because .json also returns a promise
            .then((data) => {
                this.names = mapper(data.data);
            });
        return this.names;
    }
}

const AccountNames = new accountNames();

export { AccountNames as default };

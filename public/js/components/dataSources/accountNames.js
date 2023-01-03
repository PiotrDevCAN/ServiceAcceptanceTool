/**
 *
 */

import APIData from "./fetch/accountNames.js";
import mapper from "../addons/select2dataMapper.js";

class accountNames {

    names = [];

    constructor() {

    }

    async getUnits() {
        // await for API data
        var dataRaw = await APIData.data;
        var data = mapper(dataRaw);
        this.names = data;
        return this.names;
    }
}

const AccountNames = new accountNames();

export { AccountNames as default };

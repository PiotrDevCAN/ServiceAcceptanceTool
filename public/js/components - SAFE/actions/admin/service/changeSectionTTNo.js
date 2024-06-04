/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/service/action.js');

class changeSectionTTNo extends action {

    static buttonId = '#change_section_tt_no';

    constructor(Container, modal) {
        super(Container, changeSectionTTNo, modal);
    }
}

export { changeSectionTTNo as default };

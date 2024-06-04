/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/admin/service/action.js');

class changeSectionTTYes extends action {

    static buttonHandler = '#change_section_tt_yes';

    constructor(Container, modal) {
        super(Container, changeSectionTTYes, modal);
    }
}

export { changeSectionTTYes as default };

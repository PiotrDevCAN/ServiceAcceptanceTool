/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/service/action.js');

class markInScopeYes extends action {

    static buttonHandler = '.mark_service_in_scope_yes';

    static field = 'status';
    static value = 'Yes';

    constructor(Container) {
        super(Container, markInScopeYes);
    }
}

export { markInScopeYes as default };

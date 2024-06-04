/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/service/action.js');

class markInScopeNo extends action {

    static buttonClass = '.mark_service_in_scope_no';

    static field = 'status';
    static value = 'No';

    constructor(Container) {
        super(Container, markInScopeNo);
    }
}

export { markInScopeNo as default };

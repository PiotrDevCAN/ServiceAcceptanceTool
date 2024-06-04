/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/service/action.js');

class markNotInScope extends action {

    static buttonHandler = '.mark_service_not_in_scope';

    static field = 'status';
    static value = 'Not in scope';

    constructor(Container) {
        super(Container, markNotInScope);
    }
}

export { markNotInScope as default };

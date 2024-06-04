/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/category/action.js');

class markNotInScope extends action {

    static buttonClass = '.mark_category_not_in_scope';

    static field = 'in_scope';
    static value = 'No';

    constructor(Container) {
        super(Container, markNotInScope);
    }
}

export { markNotInScope as default };

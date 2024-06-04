/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/category/action.js');

class markInScope extends action {

    static buttonClass = '.mark_category_in_scope';

    static field = 'in_scope';
    static value = 'Yes';

    constructor(Container) {
        super(Container, markInScope);
    }
}

export { markInScope as default };

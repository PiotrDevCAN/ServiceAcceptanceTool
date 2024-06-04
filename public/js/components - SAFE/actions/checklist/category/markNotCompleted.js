/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/category/action.js');

class markNotCompleted extends action {

    static buttonClass = '.mark_category_not_completed';

    static field = 'status';
    static value = 'Not Complete';

    constructor(Container) {
        super(Container, markNotCompleted);
    }
}

export { markNotCompleted as default };

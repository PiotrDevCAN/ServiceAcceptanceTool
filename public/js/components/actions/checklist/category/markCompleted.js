/*
 *
 *
 *
 */

let action = await cacheBustImport('../actions/checklist/category/action.js');

class markCompleted extends action {

    static buttonHandler = '.mark_category_completed';

    static field = 'status';
    static value = 'Complete';

    constructor(Container) {
        super(Container, markCompleted);
    }
}

export { markCompleted as default };

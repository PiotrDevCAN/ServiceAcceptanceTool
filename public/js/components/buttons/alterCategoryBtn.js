/*
 *
 *
 *
 */

class alterCategoryBtn {

    modal;

    constructor(modal) {
        console.log('+++ Function +++ alterCategoryBtn.constructor');

        this.modal = modal;
        this.listenForCategoryAlter();

        console.log('--- Function --- alterCategoryBtn.constructor');
    }

    listenForCategoryAlter() {
        var $this = this;
        $(document).on('click', '.alter-category', function (e) {
            e.preventDefault();
            var data = $(this).data();

            console.log('data for showForm');
            console.log(data);

            $this.modal.showForm(data);
        });
    }
}

export { alterCategoryBtn as default };

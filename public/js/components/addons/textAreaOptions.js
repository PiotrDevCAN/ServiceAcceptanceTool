var options = {
    forced_root_block: "",
    selector: 'textarea',
    setup: function (ed) {
        if ($('#' + ed.id).prop('readonly')) {
            ed.settings.readonly = true;
        }
    }
    // plugins: [
    //     'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    //     'searchreplace wordcount visualblocks visualchars code fullscreen',
    //     'insertdatetime media nonbreaking save table contextmenu directionality',
    //     'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
    // ],
    // toolbar1: 'fullscreen | undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
    // toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
};

export { options as default };

/**
 *
 */

function setSelect2(id, data) {
    var obj = $('#'+id);
    obj.select2({
        data: data
    });
}

export { setSelect2 as default };

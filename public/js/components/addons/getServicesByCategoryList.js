let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let handleError = await cacheBustImport('../addons/handleError.js');

function getServicesByCategoryList(checklistId, categoryId) {

    var tableWrapperId = '#servicesTable_' + categoryId + '_table_container';

    showHideSpinner('show');

    var $this = this;
    $.ajax({
        type: "get",
        url: window.apiUrl + "checklist/" + checklistId + "/category/" + categoryId + "/services",
        beforeSend: function (jqXHR, settings) {
            $(tableWrapperId).html('<p>Reload this table</p');
        },
        success: function (responseObj) {
            $(tableWrapperId).html(responseObj);
        },
        error: function (data) {
            var message = handleError(data);
            $(tableWrapperId).html(message);
        },
        complete: function () {
            showHideSpinner('hide');
        }
    });
}

export { getServicesByCategoryList as default };

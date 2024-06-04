let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let handleError = await cacheBustImport('../addons/handleError.js');

function getCategoriesList(checklistId) {

    var tableWrapperId = '#servicesOverviewTable_table_container';

    showHideSpinner('show');

    var $this = this;
    $.ajax({
        type: "get",
        url: window.apiUrl + "checklist/" + checklistId + "/categories",
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

export { getCategoriesList as default };

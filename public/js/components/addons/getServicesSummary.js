let showHideSpinner = await cacheBustImport('../addons/spinner.js');
let handleError = await cacheBustImport('../addons/handleError.js');

function getServicesSummary(checklistId, categoryId) {

    var tableSummaryId = '#servicesTable_' + categoryId + '_summary';

    var $this = this;
    $.ajax({
        type: "get",
        url: window.apiUrl + "checklist/" + checklistId + "/category/" + categoryId + "/summary",
        beforeSend: function (jqXHR, settings) {
            // $(tableSummaryId).html('<p>Reload this summary</p');
        },
        success: function (responseObj) {
            $(tableSummaryId + ' .services_in_scope_yes').html(responseObj.services_in_scope_yes);
            $(tableSummaryId + ' .services_in_scope_no').html(responseObj.services_in_scope_no);
            $(tableSummaryId + ' .services_not_in_scope').html(responseObj.services_not_in_scope);
            var readyStatus = '';
            switch (responseObj.ready_to_complete) {
                case 0:
                    readyStatus = 'No';
                    break;
                case 1:
                    readyStatus = 'Yes';
                    break;
                default:
                    break;
            }
            $(tableSummaryId + ' .ready_to_complete').html(readyStatus);
        },
        error: function (data) {
            var message = handleError(data);
            $(tableSummaryId).html(message);
        },
        complete: function () {
            showHideSpinner('hide');
        }
    });
}

export { getServicesSummary as default };

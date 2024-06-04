function handleError(data) {
    var message;
    switch (data.status) {
        case 422:
            var responseObj = data.responseJSON;
            message = responseObj.message;
            var errors = responseObj.errors;
            $.each(errors, function (key, value) {
                // $(modal.formId + ' #' + key).parent().addClass('error');
                console.log(' key ' + key + ' value ' + value);
            });
            break;
        case 500:
            message = 'Internal Server Error';
            break;
        case 404:
            message = 'Page Not Found';
            break;
        case 405:
            message = 'Method Not Allowed';
            break;
        default:
            message = 'Unable to load table';
            break;
    }
    return message;
}

export { handleError as default };

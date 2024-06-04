/**
 *
 */

function map(data) {
    const mappedData = $.map(data, function (val, index) {
        return {
            id: val.id,
            text: val.name
        };
    });
    return mappedData;
}

export { map as default };

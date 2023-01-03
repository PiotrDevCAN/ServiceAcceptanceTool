function initialiseFacesTypeAheadOnForm(formId) {
    var typeaheadInputs = $('#' + formId + ' input.typeaheadNew:visible');
    for (var n = 0; n < typeaheadInputs.length; n++) {
        var id = typeaheadInputs.eq(n).attr('id');
        initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew(id, formId);
    }
}

function initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew(id, formName) {
    console.log("initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew: " + id + " " + formName);

    if (typeof (bluepages) == 'undefined') {
        var bluepages = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            identify: function (obj) {
                console.log(obj);
                return obj;
            },
            remote: {
                url: 'https://w3-unifiedprofile-search.dal1a.cirrus.ibm.com/search?query=%QUERY&searchConfig=optimized_search',
                wildcard: '%QUERY',
                filter: function (data) {
                    var dataObject = $.map(data.results, function (obj) {
                        // console.log(obj.mail);
                        var mail = typeof (obj.mail) == 'undefined' ? 'unknown' : obj.mail[0];
                        return { value: obj.nameFull, role: obj.role, preferredIdentity: obj.preferredIdentity, cnum: obj.id, notesEmail: obj.notesEmail, mail: mail };
                    });
                    // console.log(dataObject);
                    return dataObject;
                },
            }
        });
    }

    console.log('Initialising New FacesTypahead on ' + id + " " + formName);
    var thisForm = document.getElementById(formName);

    $('#' + formName + ' #' + id + '.typeaheadNew').typeahead(null, {
        limit: 3,
        name: 'bluepages',
        display: 'notesEmail',
        displayKey: 'notesEmail',
        source: bluepages,
        templates: {
            empty: [
                '<div class="empty-message">',
                'unable to find any IBMers that match the current query',
                '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile('<div> <img src="https://w3-unifiedprofile-api.dal1a.cirrus.ibm.com/v3/image/{{cnum}}?type=bp&def=blue&s=50" alt="Profile" height="42" width="42"> <strong>{{value}}</strong><br/><small>{{preferredIdentity}}<br/>{{role}}</small></div>')
        }
    });

    $('#' + formName + ' #' + id + '.typeaheadNew').on('typeahead:select', function (ev, suggestion) {

        var intranet = thisForm.elements[id + '_intranet_id'];
        if (typeof (intranet) !== 'undefined') {
            intranet.value = suggestion.mail;
        }

        var notesid = thisForm.elements[id + '_notes_id'];
        if (typeof (notesid) !== 'undefined') {
            notesid.value = suggestion.notesEmail;
        }

        var name = thisForm.elements[id + '_name'];
        if (typeof (name) !== 'undefined') {
            name.value = suggestion.value;
        }

        var uid = thisForm.elements[id + '_uid'];
        if (typeof (uid) !== 'undefined') {
            uid.value = suggestion.cnum;
        }

        var phone = thisForm.elements[id + '_phone'];
        if (typeof (phone) !== 'undefined') {
            phone.value = suggestion.telephone_office;
        }
    });
}

// export { initialiseFacesTypeAheadOnDynamicallyCreatedFieldNew as default };
export { initialiseFacesTypeAheadOnForm as default };

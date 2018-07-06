



$(document).ready(function () {

    var entity = 'City';
    var route = '/a3commun-ui-load_ajax';  //url
    var primary = 'id';
    var textProperty = 'nom';
    var searchProperty = 'nom';

    //Initialisation autocomplete
    $('#ad_city.autocomplete').select2({
        ajax: {
            url: route,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    entity : entity,
                    primary : primary,
                    textProperty : textProperty,
                    searchProperty : searchProperty,
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
        },
    });

});
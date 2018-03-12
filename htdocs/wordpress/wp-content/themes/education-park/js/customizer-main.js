jQuery(document).on('change', '#customize-control-first_post', function (e) {
    var last_valid_selection = null;
    var test = education_park_objectL10n.response;
    jQuery('#customize-control-first_post select').change(function (event) {

        if (jQuery(this).val().length > 3) {

            jQuery(this).val(last_valid_selection);
            alert(test);
        } else {
            last_valid_selection = jQuery(this).val();

        }
    });
});
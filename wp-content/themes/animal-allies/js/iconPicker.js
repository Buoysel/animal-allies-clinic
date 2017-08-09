/**
 * Created by Andrew on 4/5/2017.
 */
var aa_fa_current_value;
//var aa_fa_current_color;

// changes icon when the user selects a new item in the select box
jQuery(document).on('change',
    'select#acf-field-icon', function() {
        var value = jQuery("select#acf-field-icon").val();
        jQuery("#show-fa-icon").removeClass(aa_fa_current_value).addClass('fa-' + value);
        aa_fa_current_value = 'fa-' + value;
    });

// on page load insert html of icon currently selected
jQuery(function() {
    var value = jQuery("select#acf-field-icon").val();
    // aa_fa_current_color = jQuery("#acf-field-icon_color").val()
    jQuery("select#acf-field-icon").before(
        '<p>'
        + '<span class="fa-stack fa-4x">'
        + '<i id="show-fa-circle" class="fa fa-circle fa-stack-2x" '
        + 'style="color:' + '#8e1618' + '"></i>'
        + '<i id="show-fa-icon" class="fa fa-' + value + ' fa-stack-1x fa-inverse"></i>'
        + '</span></p>'
    );
    aa_fa_current_value = 'fa-' + value;

});
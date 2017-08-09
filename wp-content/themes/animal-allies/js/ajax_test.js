
jQuery(document).ready(function(){
    jQuery.ajax({
        type: "post",
        url: aa_ajax_object.ajax_url,
        data: {
            action: 'my_action',
            _ajax_nonce: aa_ajax_object._ajax_nonce,
        },
        beforeSend: function() {
            jQuery("#loading").show("slow");}, //show loading just when link is clicked

        complete: function() {
            jQuery("#loading").hide("fast");}, //stop showing loading when the process is complete

        success: function(html){ //so, if data is retrieved, store it in html
            jQuery("#helloworld").html(html); //show the html inside helloworld div
            jQuery("#helloworld").show("slow"); //animation
        }
    }); //close jQuery.ajax(
})
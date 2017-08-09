/*
  Jquery Validation using jqBootstrapValidation
   example is taken from jqBootstrapValidation docs 
  */

// simple javascript to keep track of captcha_is_filled
captcha_is_filled = false;
// called by google once the captcha is filled
function captcha_filled() {
    captcha_is_filled = true;
    $("#gcaptcha-help").html('');  // remove any error messages
}
// called by google if captcha is expired
function captcha_expired() {
    captcha_is_filled = false;
}

$(function() {

    $("#contactForm input,#contactForm textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function($form, event, errors) {
            // add checking for the gcaptcha if the form submit is an error, if recaptcha is enabled in options
            if ( captcha_is_filled == false && aa_ajax_object.enable_recaptcha == 'yes') {
                // then display an error message
                $("#gcaptcha-help").html('<ul role="alert"><li>Please confirm you are not a robot.</li></ul>');
               // $("#gcaptcha-help > ul").css('color', '#a94442');
            }
        },
        submitSuccess: function($form, event) {
            event.preventDefault(); // prevent default submit behaviour
            // get values from FORM
            var name = $("input#name").val();
            var phone = $("input#phone").val();
            var email = $("input#email").val();
            var message = $("textarea#message").val();
            var g_recaptcha_response

            // get the recpatcha value if enabled
            if ( aa_ajax_object.enable_recaptcha == 'yes') {
                g_recaptcha_response = $("#g-recaptcha-response").val();  // response from reCaptcha results
            }
            else {
                g_recaptcha_response = '';
            }


            // if the captcha isnt filled and we have it enabled
            // (this isn't checked by jqBootstrapValidation currently)
            if ( captcha_is_filled == false && aa_ajax_object.enable_recaptcha == 'yes' ) {
                // then display an error message
                $("#gcaptcha-help").html('<ul role="alert"><li>Please confirm you are not a robot.</li></ul>');
                $("#gcaptcha-help > ul").css('color', '#a94442');
                // and exit
                return;
            }
            var firstName = name; // For Success/Failure Message
            // Check for white space in name for Success/Fail message
            if (firstName.indexOf(' ') >= 0) {
                firstName = name.split(' ').slice(0, -1).join(' ');
            }
            $.ajax({
                url: aa_ajax_object.ajax_url,
                type: "POST",
                dataType: 'json',
                data: {
                    name: name,
                    phone: phone,
                    email: email,
                    message: message,
                    action : 'aa_process_contact_form',
                    _ajax_nonce: aa_ajax_object._ajax_nonce,
                    recaptcha: g_recaptcha_response

                },
                cache: false,
                // do this just before sending AJAX request
                beforeSend: function() {

                },
                // Server responded with a message
                success: function(jsonResponse, textStatus, jqXHR) {
                    // if recaptcha is enabled
                    if ( aa_ajax_object.enable_recaptcha == 'yes' ) {
                        grecaptcha.reset()  // reset the google captcha
                    }

                    // if the form was processed successfully
                    if (jsonResponse.is_success) {
                        // Success message
                        $('#success').html("<div class='alert alert-success'>");
                        $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                        $('#success > .alert-success')
                            .append("<strong>Thank you, " + firstName + ". " + jsonResponse.message + "</strong>");
                        $('#success > .alert-success')
                            .append('</div>');
                    }
                    else {
                        // begin Fail Message
                        $('#success').html("<div class='alert alert-danger'>");
                        $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                        // customize message based upon failure
                        $('#success > .alert-danger').append(jsonResponse.message + '</div>');

                        // 403-error-Forbidden
                        //clear all fields
                        $('#contactForm').trigger("reset");

                    }

                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
                // Problem with HTTP request itself, e.g. (server timeout, not found, etc.)
                error: function(jqXHR, textStatus, errorThrown) {
                    // if recaptcha is enabled
                    if (aa_ajax_object.enable_recaptcha == 'yes') {
                        grecaptcha.reset(); //reset the google captcha
                    }
                    // begin Fail Message
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    // customize message based upon failure

                    var errorString = "<strong>Sorry " + firstName + ", there was a problem sending your message: "
                        + "(" + jqXHR.status + " " + errorThrown + ")</strong>"
                        + " Sorry for the inconvenience!."
                        ;

                    $('#success > .alert-danger').append(errorString + '</div>');

                    // 403-error-Forbidden
                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
            })
        },
        filter: function() {
            return $(this).is(":visible");
        },
    });

    $("a[data-toggle=\"tab\"]").click(function(e) {
        e.preventDefault();
        $(this).tab("show");
    });
});


/*When clicking on Full hide fail/success boxes */
$('#name').focus(function() {
    $('#success').html('');
});

/* custom code to require reCAPTCHA */

$

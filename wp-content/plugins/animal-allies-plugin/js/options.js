jQuery(function() {
    // recaptcha yes/no
    var enableCaptcha = jQuery("input[type=radio]#AAFieldEnableCaptcha:checked").val();

    var siteKey     = jQuery("#AAFieldCaptchaSiteKey");
    var secretKey   = jQuery("#AAFieldCaptchaSecretKey");
    var siteKeyTR   = jQuery(".AAFieldCaptchaSecretKeyTR");
    var secretKeyTR = jQuery(".AAFieldCaptchaSiteKeyTR");
    var email       = jQuery("#AAFieldContactFormEmail");
    var emailTR     = jQuery(".AAFieldContactFormEmailTR");

    var emailPattern      = email.attr('pattern');
    var siteKeyPattern    = siteKey.attr('pattern');
    var secreteKeyPattern = secretKey.attr('pattern');

    // Google reCAPTCHA yes/no
    if ( enableCaptcha == 'yes' ) {
        // required attribute
        siteKey.attr('required', 'required');
        secretKey.attr('required', 'required');

        // show the TR
        siteKeyTR.show();
        secretKeyTR.show();
    }
    else {
        // required attribute
        siteKey.removeAttr('required');
        secretKey.removeAttr('required');

        // html5 pattern attribute
        siteKey.removeAttr('pattern');
        secretKey.removeAttr('pattern');

        // show/hide tr
        siteKeyTR.hide();
        secretKeyTR.hide();
    }

    // send email yes/no
    var sendEmail = jQuery("input[type=radio]#AAFieldSendEmail:checked").val();
    if ( sendEmail == 'yes') {
        emailTR.show();
        email.attr('required', 'required');
        email.attr('pattern', emailPattern);
    }
    else {
        emailTR.hide();
        email.removeAttr('required');
        email.removeAttr('pattern');
    }

    // When Send Email Radio Field Changes
    jQuery(document).on('change',
        'input[type=radio]#AAFieldSendEmail:checked', function(){
            var sendEmail = jQuery("input[type=radio]#AAFieldSendEmail:checked").val();
            if ( sendEmail == 'yes' ) {
                emailTR.show('slow')
                email.attr('required', 'required');
                email.attr('pattern', emailPattern);
            }
            else {
                emailTR.hide('slow')
                email.removeAttr('required');
                email.removeAttr('pattern');
            }
        }
    );

    // When Enable Google reCAPTCHA Radio Field Changes
    jQuery(document).on('change',
        'input[type=radio]#AAFieldEnableCaptcha:checked', function(){
            var enableCaptcha = jQuery("input[type=radio]#AAFieldEnableCaptcha:checked").val();
            if ( enableCaptcha == 'yes' ) {
                // required attribute
                siteKey.attr('required', 'required');
                secretKey.attr('required', 'required');

                // set pattern attribute
                siteKey.attr('pattern', siteKeyPattern);
                secretKey.attr('pattern', secreteKeyPattern);

                // show TR fields
                siteKeyTR.show('slow');
                secretKeyTR.show('slow');
            }
            else {
                // required attribute
                siteKey.removeAttr('required');
                secretKey.removeAttr('required');

                // remove pattern attribute
                siteKey.removeAttr('pattern');
                secretKey.removeAttr('pattern');

                // tr attribute hide
                siteKeyTR.hide('slow');
                secretKeyTR.hide('slow');
            }
        }
    );
});

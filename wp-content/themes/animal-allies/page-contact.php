<?php

global $post; // get data on current post

// get map field from advanced custom fields
$map = get_field('google_map');

// contact information from advanced custom fields
$street_address     = get_field_escaped('street_address');
$city_state_zip     = get_field_escaped('city_state_zip');
$phone_number       = get_field_escaped('phone_number');
$email              = get_field_escaped('email');
$email_link         = get_field_escaped('email', $post->ID, true, 'esc_attr');
$hours_of_operation = get_field_escaped('hours_of_operation');
$facebook           = get_field_escaped('facebook', $post->ID, true,'esc_url');

// options from the plugin options settings
$options = get_option('AAOptionContactPage');
$contactInfo = get_option('AAOptionContactInfo');

/**
 * In order to allow Advanced Custom Fields editing of the Google Map
 * element on the contact page, we need to have an API key to embed the
 * map.  This should be changed to a key the client uses, and perhaps stored
 * by Advanced Custom Fields as a field in itself by the site admin.  For
 * development I've created an api key for Google Maps Embed API.  Google
 * provides different api and keys based upon how you integrate their map
 * on a site.  Embed is one of Google's methods, and its a simple one.
 *
 * @link https://developers.google.com/maps/documentation/embed/ Google Maps Embed API
 */
$google_maps_embed_api_key = $options['AAFieldGoogleMapsEmbedAPIKey'];
get_header(); ?>
<div class="wideSection whiteBG">
    <div class="container">

  <!-- Opening container div and breadcrumbs in header -->

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
            <div class="col-md-8">
                <p></p>
                <!-- Embedded Google Map -->
                <iframe width="100%" height="400px" frameborder="0" scrolling="no"
                        marginheight="0" marginwidth="0"
                        src="https://www.google.com/maps/embed/v1/place?key=<?php echo urlencode($google_maps_embed_api_key) ?>&q=<?php echo urlencode($map['address']) ?>">
                </iframe>
            </div>
            <!-- Contact Details Column -->
            <div class="col-md-4" id="contactInfoColumn">

                <div class="row">
                    <h3 class="col-md-12" id="contactHead" class="contactDetailsTitle">Contact Details</h3>
                    <div class="row contactRow contactRowFlexboxContainer">
                        <div class="contactRowFlexboxIcon contactRowFlexboxItems">
                            <span class="fa-stack fa">
                                <i class="fa fa-stack-2x fa-map-marker"></i>
                            </span>
                        </div>
                        <div class="contactRowFlexboxLabel contactRowFlexboxItems">
                            <?php echo esc_html( $contactInfo['AAFieldStreetAddress'] ); ?><br><?php echo esc_html( $contactInfo['AAFieldCityStateZip'] ); ?><br>
                        </div>
                    </div>
                    <div class="row contactRow contactRowFlexboxContainer">
                        <div class="contactRowFlexboxIcon contactRowFlexboxItems">
                            <span class="fa-stack fa">
                                <i class="fa fa-stack-2x fa-clock-o"></i>
                            </span>
                        </div>
                        <div class="contactRowFlexboxLabel contactRowFlexboxItems">
                            <?php echo esc_html( $contactInfo['AAHoursOfOperation'] ); ?>
                        </div>
                    </div>
                    <div class="row contactRow contactRowFlexboxContainer">
                        <div class="contactRowFlexboxIcon contactRowFlexboxItems">
                            <span class="fa-stack fa">
                                <i class="fa fa-stack-2x fa-phone"></i>
                            </span>
                        </div>
                        <div class="contactRowFlexboxLabel contactRowFlexboxItems">
                            <?php echo esc_html( $contactInfo['AAFieldPhone'] ); ?>
                        </div>
                    </div>
                    <div class="row contactRow contactRowFlexboxContainer">
                        <div class="contactRowFlexboxIcon contactRowFlexboxItems">
                            <span class="fa-stack fa">
                                <i class="fa fa-stack-2x fa-envelope-o"></i>
                            </span>
                        </div>
                        <div class="contactRowFlexboxLabel contactRowFlexboxItems">
                            <a href="mailto:<?php echo esc_attr( $contactInfo['AAFieldEmail'] ); ?>"><?php echo esc_html( $contactInfo['AAFieldEmail'] ); ?></a>
                        </div>
                    </div>
                    <div class="row contactRow contactRowFlexboxContainer">
                        <div class="contactRowFlexboxIcon contactRowFlexboxItems">
                            <span class="fa-stack fa">
                                <i class="fa fa-stack-2x fa-facebook"></i>
                            </span>
                        </div>
                        <div class="contactRowFlexboxLabel contactRowFlexboxItems">
                            <a href="<?php echo esc_url( $contactInfo['AAFieldFacebook'] ); ?>" target="_blank">Like us on Facebook!</a>
                        </div>
                    </div>

                    <div class="row contactRow contactRowFlexboxContainer">

                        <div class="contactRowFlexboxIcon contactRowFlexboxItems">
			                <span class="fa-stack fa">
				                <i class="fa fa-stack-2x fa-paypal"></i>
                            </span>
                        </div>

                        <div class="contactRowFlexboxLabel contactRowFlexboxItems">
                            <form method="post" style="margin:0;" action="https://www.paypal.com/cgi-bin/webscr">
                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="business" value="animalalliesclinic@yahoo.com">
                                <input type="hidden" name="item_name" value="">
                                <input type="hidden" name="return" value="">
                                <input type="hidden" name="cancel_return" value="">
                                <input type="hidden" name="image_url" value="">
                                <input type="hidden" name="bn" value="yahoo-sitebuilder">
                                <input type="hidden" name="pal" value="C3MGKKUCCAB9J">
                                <input type="hidden" name="mrb" value="R-5AJ59462NH120001H">
                                <input type="image" border="0" style="object-fit: contain;" src="<?php echo esc_url( get_template_directory_uri() . '/img/paypal-donate-button-01.png'); ?>">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="wideSection lightGreyBG">
    <div class="container">
        <!-- /.row -->
            <!-- Contact Form -->
            <!-- In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
            <div class="row">
                <div class="col-md-8">
                    <h2 style="padding-bottom: 10px;">Send us a Message</h2>
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="control-group form-group">
                            <div class="controls">

                                <label>Full Name: (required)</label>
                                <div class="input-group margin-bottom-sm">
                                    <span class="input-group-addon"><i class="fa fa-lg fa-user fa-fw"></i></span>
                                <input type="text" class="form-control" id="name" placeholder="Jane Doe"
                                       pattern="[a-zA-Z \-.]{1,50}"
                                       minlength="1"
                                       maxlength="50"
                                       required
                                       data-validation-required-message="Please enter your name."
                                       data-validation-minlength-message="Too short: Minimum of '1' characters"
                                       data-validation-maxlength-message="Too long: Minimum of '50' characters"
                                       data-validation-pattern-message="Name may include letters, spaces, hyphens, and periods.">
                                </div>
                                <p class="help-block"></p>

                            </div>
                        </div>
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Email Address: (required)</label>
                                <div class="input-group margin-bottom-sm">
                                    <span class="input-group-addon"><i class="fa fa-lg fa-envelope fa-fw"></i></span>
                                    <input type="email" class="form-control" id="email" placeholder="example@domain.com" required
                                           data-validation-required-message="Please enter your email address.">
                                </div>
                            </div>
                            <p class="help-block"></p>
                        </div>
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Phone Number:</label>
                                <div class="input-group margin-bottom-sm">
                                    <span class="input-group-addon"><i class="fa fa-lg fa-phone-square fa-fw"></i></span>
                                <input type="tel" class="form-control" id="phone"  placeholder="123-555-6789"
                                       pattern="\(?([0-9]{3})\)?[\-. ]?([0-9]{3})[\-. ]?([0-9]{4})"
                                       data-validation-pattern-message="Must input valid number with area code, e.g. 123-555-6789">
                                </div>
                            </div>
                            <p class="help-block"></p>
                        </div>

                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Message:</label>

                                <textarea rows="10" cols="100" class="form-control" id="message" placeholder="Enter your message here." required
                                          maxlength="999"
                                          data-validation-regex-regex="([\w\d\s.,?!:;\x27\x22\[\](){}@#$%&`~\-\^=+*<>\\/|]{1,999})"
                                          data-validation-regex-message="Please avoid special characters such as &cent;, &Auml;, &frac12;, etc."
                                          data-validation-required-message="Please enter your message"  style="resize:none"></textarea>
                            </div>
                        </div>

                        <?php
                        // if the google recaptcha is enabled in plugin options then show it
                        if ( $options['AAFieldEnableCaptcha'] == 'yes' ) { ?>
                            <div class="g-recaptcha grecaptcha control-group form-group" data-sitekey="<?php echo esc_attr($options['AAFieldCaptchaSiteKey']) ?>" data-callback="captcha_filled"
                                 data-expired-callback="captcha_expired">
                            </div>
                        <?php } // end php if ?>
                        <p id="gcaptcha-help" class="help-block"></p>
                        <div id="success"></div>
                        <!-- For success/fail messages -->
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
            <!-- /.row -->
    </div>
</div>
<?php
// get footer.php template
get_footer();

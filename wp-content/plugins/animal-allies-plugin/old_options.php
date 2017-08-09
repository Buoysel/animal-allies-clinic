<?php
/**
 * This code sets up an options page for the plugin.
 *
 * We use WordPress' built in Settings API to create the page html, save
 * settings, register settings, sections, and fields. This API is not that
 * well implemented and forces us to contain HTML for fields and sections
 * within callback functions.  Thus all the HTML for the options page is
 * currently on this page wrapped within many callback functions designated in
 * add_settings_section(), add_settings_field(), or add_menu_page() WordPress
 * Settings API functions.
 *
 * First we register  a menu item to access the options page.
 * @see aa_options_page()
 *
 * Then we register an new setting group, which will contain our sections and
 * fields.
 *
 * We also add sections to this new setting group, and add fields to each
 * section.  Each section and field contains a callback to a function to
 * generate the HTML.
 *
 * We include the functions containing the HTML for callbacks last in this
 * file.
 *
 * There may be a better way to implement all of this, but for now we do it
 * in a simple functional approach.
 *
 * @see https://developer.wordpress.org/plugins/settings/settings-api/
 * @see https://developer.wordpress.org/plugins/settings/options-api/
 */

//========================================================================
//                                                    SETUP PLUGIN OPTIONS
//========================================================================


//------------------------------------------------------------------------
//                                                  CREATE A NEW MENU ITEM
//------------------------------------------------------------------------

/**
 * Creates a new item in the admin menu to access the new options page
 */
function aa_options_page() {
    add_menu_page(
        'Animal Allies Options',    // title to show on menu page
        'Animal Allies Options',    // text to show in the menu
        'manage_options',           // capability required to edit options
        'aa_options_menu',          // unique menu slug
        'aa_options_page_html',     // function to call to render page
        'dashicons-admin-generic',  // icon to show in menu, could be custom
        '30'                        // position in the menu
    );
}
add_action( 'admin_menu', 'aa_options_page');

/**
 * Function called on admin_init and registers all options with Settings API
 *
 * First the setting is registered, then each section of the setting, then
 * the actual fields which make up each section.
 */
function aa_settings_init() {
    // registers a setting and its sanitization callback (Settings API)

    //--------------------------------------------------------------------
    //                                              REGISTER A NEW SETTING
    //--------------------------------------------------------------------
    register_setting(
        'aa_plugin',    // group name for the setting page
        'aa_options',   // name of the option to sanitize and save
        [                           // array of option
            'sanitize_callback' => 'aa_options_sanitize',  // function to call to sanitize values
        ]
    );

    //--------------------------------------------------------------------
    //                                     ADD SECTIONS TO THE NEW SETTING
    //--------------------------------------------------------------------
    // Contact Form Settings
    add_settings_section(
        'aa_section_contact_form',      // slug name to identify the section
        'Contact Form Settings',        // formatted title of the section
        'aa_section_contact_form_html', // function that echoes html content between heading and fields
        'aa_plugin'                     // the slug name of the settings page to show this section
    );

    // Google API Key Settings
    add_settings_section(
        'aa_section_google_maps_api_key',       // slug name to identify the section
        'Google Maps API Key',                  // formatted title of the section
        'aa_section_google_maps_api_key_html',  // function that echoes content between title and fields
        'aa_plugin'                         // the slug name of the settings page to show this section
    );

    //--------------------------------------------------------------------
    //                                          ADD FIELDS TO EACH SECTION
    //--------------------------------------------------------------------

    // Send contact form email or not
    add_settings_field(
        'aa_field_contact_send_email',              // slug for the field
        'Send an email when the contact form is submitted',       // title of the field
        'aa_field_contact_send_email_html',  // function to fill the field with form inputs
        'aa_plugin',                                // slug of settings page to display field on
        'aa_section_contact_form',               // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_contact_send_email',
            'class'     => 'aa_options_row',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );

    // Emails to send contact form to
    add_settings_field(
        'aa_field_contact_email_list',              // slug for the field
        'Email address to receive message',       // title of the field
        'aa_field_contact_email_list_html',  // function to fill the field with form inputs
        'aa_plugin',                                // slug of settings page to display field on
        'aa_section_contact_form',               // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_contact_email_list',
            'class'     => 'aa_field_contact_email_list_tr',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );

    // Store message in WordPress
    add_settings_field(
        'aa_field_contact_store_message',              // slug for the field
        'Store messages in WordPress',       // title of the field
        'aa_field_contact_store_message_html',  // function to fill the field with form inputs
        'aa_plugin',                                // slug of settings page to display field on
        'aa_section_contact_form',               // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_contact_store_message',
            'class'     => 'aa_options_row',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );

    // Enable Google reCAPTCHA
    add_settings_field(
        'aa_field_contact_enable_recaptcha',       // slug for the field
        'Enable Google reCAPTCHA',                 // title of the field
        'aa_field_contact_enable_recaptcha_html',  // function to fill the field with form inputs
        'aa_plugin',                               // slug of settings page to display field on
        'aa_section_contact_form',                 // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_contact_enable_recaptcha',
            'class'     => 'aa_options_row',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );

    // Google reCAPTCHA Site key
    add_settings_field(
        'aa_field_google_recaptcha_site_key',           // slug for the field
        'Google reCAPTCHA Site Key',                  // title of the field
        'aa_field_google_recaptcha_site_key_html',    // function to fill the field with form inputs
        'aa_plugin',                                    // slug of settings page to display field on
        'aa_section_contact_form',                   // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_google_recaptcha_site_key',
            'class'     => 'aa_recaptcha_site_key_tr',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );

    // Google reCAPTCHA secret key
    add_settings_field(
        'aa_field_google_recaptcha_secret_key',       // slug for the field
        'Google reCAPTCHA Secret Key',                // title of the field
        'aa_field_google_recaptcha_secret_key_html',  // function to fill the field with form inputs
        'aa_plugin',                                // slug of settings page to display field on
        'aa_section_contact_form',               // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_google_recaptcha_secret_key',
            'class'     => 'aa_recaptcha_secret_key_tr',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );


    // Google maps embed API key
    add_settings_field(
        'aa_field_google_maps_embed_api_key',       // slug for the field
        'Google Maps Embed API Key',                // title of the field
        'aa_field_google_maps_embed_api_key_html',  // function to fill the field with form inputs
        'aa_plugin',                                // slug of settings page to display field on
        'aa_section_google_maps_api_key',               // slug name of section to display field within
        // extra optional args for outputting field
        [
            // put setting title in <label for=""> with for= this value
            'label_for' => 'aa_field_google_maps_embed_api_key',
            'class'     => 'aa_options_row',  // css class to add to <tr> of field
            'aa_options_group_custom_data' => 'custom'
        ]
    );


}
add_action('admin_init', 'aa_settings_init');

//========================================================================
//                                                   HTML FOR OPTIONS PAGE
//========================================================================

/**
 * Base html for form section for the options page.
 *
 * This function outputs the html for the options page.  All other html is
 * placed on the options page by this function though WordPress' Settings API
 * calls.
 *
 * settings_fields() and do_settings_sections() fills in the HTMl for the
 * page.
 *
 * @see aa_options_page() The function which registers this function.
 */
function aa_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset($_GET['settings-updated']) ) {
        // add settings saved message with the class of "updated"
        add_settings_error('aa_plugin_messages', 'aa_plugin_message', 'Settings Saved', 'updated');
    }

    // show error/update messages
    settings_errors( 'aa_plugin_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting
            settings_fields( 'aa_plugin' );
            // output setting sections and their fields
            // (sections are registered for "aa_plugin", each field is registered to a specific section)
            do_settings_sections( 'aa_plugin' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

//------------------------------------------------------------------------
//                                                            SECTION HTML
//------------------------------------------------------------------------

/**
 * Output HTML for Contact Form Settings section
 * @param $args
 */
function aa_section_contact_form_html($args) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>">
        Settings for how to process the "Send Message" from on the contact page.
    </p>
    <?php
}

/**
 * Output HTML for Google API Keys section
 * @param $args
 */
function aa_section_google_maps_api_key_html($args) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>">
        The Google Map on the contact page requires a Google Maps Embed API
        key.
    </p>
    <?php
}

//------------------------------------------------------------------------
//                                                              FIELD HTML
//------------------------------------------------------------------------

/**
 * Output HTML for Contact Send Email field
 * @param $args
 */
function aa_field_contact_send_email_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <div style="margin:0.5em 0em;">
        Yes
        <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               value="yes"
            <?php
            checked($options[$args['label_for']], 'yes');
            ?>

        ><span style="margin-left: 2em;">No</span>
        <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               value="no"

            <?php
            checked($options[$args['label_for']], 'no')
            ?>

        >
    </div>
    <?php
}

/**
 * Output HTML for Google reCAPTCHA Site Key field
 * @param $args
 */
function aa_field_contact_email_list_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <input type="email" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           style="width:90%; "
           data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
           name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           pattern="[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,24}"
           required
           value="<?php echo esc_attr(
               isset( $options[ $args['label_for'] ] )
                   ?  $options[ $args['label_for'] ]
                   : ''
           ); ?>"
    >
    <?php
}

/**
 * Output HTML for Contact Store Message field
 * @param $args
 */
function aa_field_contact_store_message_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <div style="margin:0.5em 0em;">
        Yes
        <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               value="yes"
            <?php
            checked($options[$args['label_for']], 'yes');
            ?>

        ><span style="margin-left: 2em;">No</span>
        <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               value="no"
            <?php
            checked($options[$args['label_for']], 'no')
            ?>
        >
    </div>
    <p class="description">Select "Yes" to store and view contact form submissions
        within WordPress.  This will create a new menu item titled "Messages".</p>
    <?php
}

function aa_field_contact_enable_recaptcha_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <div style="margin:0.5em 0em;">
        Yes
        <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               value="yes"
               required
            <?php
            checked($options[$args['label_for']], 'yes');
            ?>

        ><span style="margin-left: 2em;">No</span>
        <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
               value="no"
               required
            <?php
            checked($options[$args['label_for']], 'no')
            ?>

        >
    </div>
    <p class="description">Select "Yes" to place a Google reCAPTCHA element on the contact form.
        This is a security feature intended to help reduce spam.</p>
    <?php
}

/**
 * Output HTML for Google reCAPTCHA Site Key field
 * @param $args
 */
function aa_field_google_recaptcha_site_key_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           size="46"
           data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
           name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           required
           value="<?php echo esc_attr(
               isset( $options[ $args['label_for'] ] )
                   ?  $options[ $args['label_for'] ]
                   : ''
           ); ?>"
    >
    <p class="description">
        Visit <a href="https://www.google.com/recaptcha"
                 target="_blank">https://www.google.com/recaptcha</a>
        to obtain Google reCAPTCHA keys.
    </p>
    <?php
}
/**
 * Output HTML for Google reCAPTCHA Secret Key field
 * @param $args
 */
function aa_field_google_recaptcha_secret_key_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           size="46"
           data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
           name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           required
           value="<?php echo esc_attr(
               isset( $options[ $args['label_for'] ] )
                   ?  $options[ $args['label_for'] ]
                   : ''
           ); ?>"
    >
    <p class="description">
        Visit <a href="https://www.google.com/recaptcha"
                 target="_blank">https://www.google.com/recaptcha</a>
        to obtain Google reCAPTCHA keys.
    </p>
    <?php
}


/**
 * Output HTML for Google Maps Embed API Key field
 * @param $args
 */
function aa_field_google_maps_embed_api_key_html($args) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option('aa_options');
    // output the field
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           size="46"
           data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
           name="aa_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo esc_attr(
               isset( $options[ $args['label_for'] ] )
                   ?  $options[ $args['label_for'] ]
                   : ''
           ); ?>"
    >
    <p class="description">
        Visit <a href="https://developers.google.com/maps/documentation/embed/"
                 target="_blank">https://developers.google.com/maps/documentation/embed/</a>
        to obtain a key if you do not have one.
    </p>
    <?php
}

/**
 * Function called to sanitize data
 *
 * This function needs to be seperated out, it is too unwieldy currently
 *
 * @param $input array of key value option fields
 * @return $output array of sanitized values
 */
function aa_options_sanitize($input) {
    $options = get_option('aa_options');
    $output = array(); // array to store the validated & sanitized fields
    //--------------------------------------------------------------------
    //                                      VALIDATION REGULAR EXPRESSIONS
    ///-------------------------------------------------------------------

    // this supports multiple emails but the client side does not at this time
    $email_regex = <<<END
\A                    # beginning of string
(                     # start capture group
  [\s]*               # space character zero more times
  [A-Za-z0-9._%+\-]+  # letters, digits, and . _ % + - one or more times
  @                   # @ sign one time
  [A-Za-z0-9.\-]+     # letters, digits, period, dash one or more times
  \.                  # period one time
  [A-Za-z]{2,24}      # letters 2 to 24 times
  (?:                 # no capture for additional email addresses 
    ,                   # single comma
    [\s]*               # space character zero more times
    [A-Za-z0-9._%+\-]+  # letters, digits, and . _ % + - one or more times
    @                   # @ sign one time
    [A-Za-z0-9.\-]+     # letters, digits, period, dash one or more times
    \.                  # period one time
    [A-Za-z]{2,24}      # letters 2 to 24 times
   ){0,50}              # match additional email addresses zero to 50 times
)                     # end capture group
\z                    # the end of the string
END;
    // for validating google api keys
    $google_key_regex = <<<END
\A                # beginning of string
(                 # start capture group
  [\w\d\-]{1,500} # word character, digit, or dash 1 to 500 times
)                 # end capture group
\z                # end of string
END;

    // for validating fields with 'yes' or 'no' value
    $control_fields_regex = <<<END
\A                # beginning of string
(                 # start capture group
  (?:yes|no)      # no capture group of either yes or no
)                 # end capture group
\z                # end of string
END;


    //--------------------------------------------------------------------
    //                                          VALIDATION AND SANITIZTION
    ///-------------------------------------------------------------------

    /**
     * Currently radio buttons and google api keys are no validated, but they
     * are sanitized.  The front end provides some validation and error warning
     * but this section could use enhancement.
     */

    // loop through all form input as keys and values
    foreach ($input as $key => $value) {

        // a switched based on the key or field we are validating/sanitizing
        switch ($key) {
            case 'aa_field_contact_email_list':

                // if the send email field is yes, process this form input
                if ($input['aa_field_contact_send_email'] == 'yes') {

                    $validated_email = '';
                    // if it doesnt match the regular expression
                    if (!preg_match("/$email_regex/xms", $value, $validated_email)) {
                        // set an error message
                        add_settings_error(
                            'aa_plugin_messages',    // slug of setting to apply
                            'aa_plugin_email_error', //slug to id error
                            'Email input had an error, please update with valid email address.',
                            'error'  // type or message. 'error' or 'updated'
                        );
                        // set the value to be blank
                        $output[$key] = "";
                    }
                    else {
                        // save the validated email in sanitized form
                        $output[$key] = sanitize_text_field($validated_email[0]);
                    }
                }
                // if the send email field is no, just save the previous saved value
                else {
                    $output[$key] = isset($options['aa_field_contact_email_list'])   ?
                        sanitize_text_field($options['aa_field_contact_email_list']) :
                        "" // empty string
                    ;
                }
                break;

            // recaptcha site key field
            case 'aa_field_google_recaptcha_site_key':
                // if the recaptcha is enabled, get the field from the input
                if ($input['aa_field_contact_enable_recaptcha'] == 'yes') {
                    $output[$key] = sanitize_text_field($value);
                }
                // otherwise set it to its previous value
                else {
                    $output[$key] = isset($options['aa_field_google_recaptcha_site_key'])   ?
                        sanitize_text_field($options['aa_field_google_recaptcha_site_key']) :
                        "" // empty string
                    ;
                }
                break;
            // recaptcha secret key field
            case 'aa_field_google_recaptcha_secret_key':
                // if the recaptcha is enabled, get the field from the input
                if ($input['aa_field_contact_enable_recaptcha'] == 'yes') {
                    $output[$key] = sanitize_text_field($value);
                }
                // otherwise set it to its previous value
                else {
                    $output[$key] = isset( $options['aa_field_google_recaptcha_secret_key'] ) ?
                        sanitize_text_field($options['aa_field_google_recaptcha_secret_key']) :
                        "" // empty string
                    ;
                }
                break;
            case 'aa_field_google_maps_embed_api_key':
                if ( !isset($value) || $value == "" ) {
                    add_settings_error(
                        'aa_plugin_messages',    // slug of setting to apply
                        'aa_plugin_email_error', //slug to id error
                        'No Google Maps Embed API Key is set.  The Google map on the contact page may not function without this key.',
                        'error'  // type or message. 'error' or 'updated'
                    );
                }
                $output[$key] = sanitize_text_field($value);
                break;
            // make sure to sanitize any fields not explicitly written here
            // currently lets through api keys and 'yes' 'no' forms and does not
            // validate their data on server side
            default:
                $output[$key] = sanitize_text_field($value);
        }
    }


    // return our new sanitized values in an array
    return $output;
}

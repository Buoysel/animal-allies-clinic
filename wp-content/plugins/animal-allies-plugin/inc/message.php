<?php

//========================================================================
//                                       PROCESS AJAX FORM ON CONTACT PAGE
//========================================================================


/**
 * Function to handle ajax post request from contact_me.js
 *
 * Currently we assume all fields in the contact form are required.  This
 * is not actually the case and needs to be revised.
 *
 * For information how jQuery works with AJAX see the link below
 * @see http://api.jquery.com/jquery.ajax/ jQuery AJAX docs
 *
 */
function aa_process_contact_form() {
    $aa = new AnimalAlliesCustomPost();  // custom post object
    $options = get_option('AAOptionContactPage');

    // array to hold JSON response data
    $our_response = array(
        'is_success'    =>  true, // true if was success, false if there was an error
        'message'       =>  'Your message has been sent.', // message to send back.
    );

    /**
     * Check the nonce to see if it is valid.
     *
     * If the security nonce is not valid, this function will automatically
     * terminate the ajax http request and send a 403 Forbidden error.
     */
    check_ajax_referer("aa_submit_contact_form");

    //--------------------------------------------------------------------
    //                    VALIDATE AND AUTHENTICATE GOOGLE RECAPTCHA VALUE
    //--------------------------------------------------------------------


    // if the plugin options have recaptcha enabled
    if ($options['AAFieldEnableCaptcha'] == 'yes' ) {
        // see if google captcha validated and authenticated
        $our_response = google_captcha_authenticate();
    }

    // if there has been an error to this point with google recaptcha
    if (! $our_response['is_success']) {
        //go ahead and send response and die();
        wp_send_json($our_response);

    }

    //--------------------------------------------------------------------
    //                              ENSURE DATA ARRIVES IN EXPECTED FORMAT
    //--------------------------------------------------------------------

    // validate user input, return JSON response and validated data
    list($our_response, $validated_data) = validate_contact_form();

    // if there has been an error to this point
    if ( ! $our_response['is_success'] ){
        // go ahead and send response and die();
        wp_send_json($our_response);
    }

    //--------------------------------------------------------------------
    //                                                       SANITIZE DATA
    //--------------------------------------------------------------------

    /**
     * Sanitize the text using WordPress builtin functions.  These
     * functions strip the fields of various content.  For information see
     * the WordPress codex or link below.  As a note, these fields
     * automatically get sanitized by the wp_insert_post() function itself
     * but we do it here for extra safety.
     *
     * @see https://codex.wordpress.org/Validating_Sanitizing_and_Escaping_User_Data
     */
    $sanitized_name    = sanitize_text_field($validated_data['name']);
    $sanitized_email   = sanitize_email($validated_data['email']);
    $sanitized_phone   = sanitize_text_field($validated_data['phone']);
    $sanitized_message = sanitize_text_field($validated_data['message']);

    //--------------------------------------------------------------------
    //                                                         INSERT POST
    //--------------------------------------------------------------------

    // if the option is set to store the message in a post, insert the post
    if ($options['AAFieldStoreMessage'] == 'yes') {

        // insert these fields into a new post in the Message custom post
        $args = array(
            'post_content'   => $sanitized_message,
            'post_title'     => $sanitized_name,
            'post_status'    => 'private',          // mark as private
            'post_type'      => $aa->getSlug('message'),
            'comment_status' => 'closed',
            'meta_input'     => array(
                'email' => $sanitized_email,
                'phone' => $sanitized_phone,
            ),
        );
        // we dont error check this. TODO: error check insert post
        wp_insert_post($args);

        // set response
        $our_response['is_success'] = true;
        $our_response['message'] = 'Your message has been sent.';
    }

    //--------------------------------------------------------------------
    //                                                          SEND EMAIL
    //--------------------------------------------------------------------

    // if the plugin option is set to send an email
    if ( $options['AAFieldSendEmail'] == 'yes') {

        // form a message including the user's information
        $formed_message = <<<END
The following message was sent through the Animal Allies website contact page:

Name: $sanitized_name
Phone: $sanitized_phone
Email: $sanitized_email

$sanitized_message
END;
        // send the email but store the response
        $was_sent = wp_mail(
            $options['AAFieldContactFormEmail'], // email address to send to
            'Animal Allies Message: ' . $sanitized_name, // subject,
            $formed_message
        );

        if ($was_sent) {
            $our_response['is_success'] = true;
            $our_response['message'] = 'Your message has be sent.';

        }
        else {
            $our_response['is_success'] = false;
            $our_response['message'] = "Unable to send email.";
        }
    }

    // set default success message for simple user feedback
    if ($our_response['is_success']) {
        $our_response['message'] = 'Your message has been sent.';
    }

    wp_send_json($our_response); // this should automatically die();
    die();
}
// for both users logged in and not logged in
add_action( 'wp_ajax_aa_process_contact_form', 'aa_process_contact_form' );  // logged in users
add_action( 'wp_ajax_nopriv_aa_process_contact_form', 'aa_process_contact_form' );      // not logged in users


/**
 * This function handles the google_captcha validation and authentication.
 *
 * - Makes sure user supplied captcha is in valid format
 * - Queries google API through HTTPS to authenticate
 * - Returns an array used in JSON response
 *
 * @return array $our_response JSON response array
 */
function google_captcha_authenticate() {
    // JSON response array
    $our_response = array(
        'is_success' => false,   // assume we fail
        'message'    => 'reCAPTCHA failure.'
    );


    // get the plugin options
    $options = get_option('AAOptionContactPage');

    // store the secret key set in plugin option
    $saved_secret_key = $options['AAFieldCaptchaSecretKey'];

    // secret key for recaptcha http check
    $recaptchaSecretKey = '6LfELxkUAAAAAKkqIBkV5nqxpwf_xVXK8DFDr0CE';
    $recaptchaSecretKey = $saved_secret_key;

    // regex to validate recpatcha response
    $recaptcha_regex = <<<END
\A                # beginning of string
(                 # start capture group
  [\w\d\-]{1,500} # word character, digit, or dash 1 to 500 times
)                 # end capture group
\z                # end of string
END;

    // validate the recaptcha we recieved
    $validated_recaptcha = "";
    if (!preg_match("!$recaptcha_regex!xms", $_POST['recaptcha'], $validated_recaptcha)) {
        $our_response['is_success'] = false;
        $our_response['message'] = "Invalid reCAPTCHA Response.";
    } // if validated, then check with google for authentication
    else {
        // url to send POST request to google
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        // args with POST parameters to send to google
        $args = array(
            'body' => array(
                'secret'  => $recaptchaSecretKey,      // our secret
                'response' => $validated_recaptcha[0], // user submitted
            ),
        );
        /**
         * Send https POST request to google to authenticate user's reCAPTCHA
         * submitted response.  Will return a WP_Error object if the request
         * simply failed.  Otherwise an array will be sent back.
         *
         * @see https://codex.wordpress.org/Function_Reference/wp_remote_post wp_remote_post docs
         */
        $google_response = wp_remote_post($url, $args);

        // if a WP_Error object is the resposne
        if (is_wp_error($google_response)) {
            $our_response['is_success'] = false;
            $our_response['message'] = "Could not authenticate reCAPTCHA.";
        } // otherwise we got a response, so see if google authenticates
        else {
            // print for temporary debug
            //print_r($google_response);

            // create php object from json response
            $json_response_object = json_decode($google_response['body']);
            //print_r($json_response_object);

            // if google authenticated the reCAPTCHA user supplied response
            if ($json_response_object->{'success'}) {
                $our_response['is_success'] = true;
                $our_response['message'] = 'Captcha Validated.';
            } // if there was an error authenticating by google
            else {
                $our_response['is_success'] = false;
                $our_response['message'] = $json_response_object->{'error-codes'};
            }
        }
    }
    return $our_response;
}

/**
 * Validates contact form data
 *
 * Checks user supplied data against regex to validate input format.
 * Invalid required parameters will have a null value.
 * Also creates JSON response based upon validation outcome.
 *
 * @return array returs an array of two arrays.  First is the JSON array,
 * second is the validated data in an array.
 */
function validate_contact_form() {
    // our JSON response
    $our_response = array(
        'is_success' =>  true,
        'message'    => "Form fields validated.",
    );

    // regex for validating name field
    $name_regex = <<<END
\A                      # beginning of string
(                       # start capture group
  [a-zA-Z \-.]{1,50}    # letter, space, dash, period one to 50 times         
)                       # end capture group
\z                      # end of string
END;

    // regex for validating phone form field
    $phone_regex = <<<END
\A                # beginning of string
(                 # start capture group
  \(?             # opening parenthesis 0 or 1 time
  (?:             # non capturing group
    [0-9]{3}      # number 0-9 three times
  )               # end non-capture group     
  \)?             # closing parenthesis 0 or 1 time
  [\-. ]?         # a dash, period, or single space zero or 1 time
  (?:             # start non capture group
    [0-9]{3}      # number 0-9 three times
  )               # end non-capture group
  [\-. ]?         # a dash, period, or single space zero or 1 time
  (?:             # start non capture group
    [0-9]{4}      # 0-9 four times
  )               # end non capture group
)                 # end capture group
\z                # end of string     
END;

    // there are so many ways to validate email addresses, this is one simple way
    $email_regex = <<<END
\A                    # beginning of string
(                     # start capture group
  [A-Za-z0-9._%+\-]+  # letters, digits, and . _ % + - one or more times
  @                   # @ sign one time
  [A-Za-z0-9.\-]+     # letters, digits, period, dash one or more times
  \.                  # period one time
  [A-Za-z]{2,24}      # letters 2 to 24 times
)                     # end capture group
\z                    # the end of the string
END;

    /** @var string $message_regex captures printable ascii & whitespace */
    $message_regex = <<<END
\A                 # beginning of string
(                  # start capture group
  [ -~\s]{1,999}   # ascii character range from space to ~, and \s, 1-999 times
)                  # end capture group
\z                 # end of the sting
END;
    // validate all form fields
    $validated_name = "";
    if ( ! preg_match("!$name_regex!xms", $_POST['name'], $validated_name ) ) {
        $our_response['is_success'] = false;
        $our_response['message'] = 'Could not process form 1, invalid input!';
    }

    // phone is not required, so we simply do not die on phone problems
    // we assume the html front end checking user input appropriately
    // for all non-malicious users, so if a phone was provided, its likely
    // in the right format. may rethink in future.
    $validated_phone = "";
    if ( ! preg_match("!$phone_regex!xms", $_POST['phone'], $validated_phone) ){
        //$our_response['is_success'] = false;
        //$our_response['message'] = 'Could not process form, invalid input!';
        $validated_phone[0] = "Phone not provided";
    }
    $validated_email = "";
    if ( ! preg_match("!$email_regex!xms", $_POST['email'], $validated_email) ) {
        $our_response['is_success'] = false;
        $our_response['message'] = 'Could not process form, invalid input!';
    }
    $validated_message = "";
    if ( ! preg_match("/$message_regex/xms", $_POST['message'], $validated_message) ){
        $our_response['is_success'] = false;
        $our_response['message'] = 'Could not process form, invalid input!:' . $_POST['message'];
    }

    // group our data in array to return
    $validated_data = array(
        'name'    => $validated_name[0],
        'phone'   => $validated_phone[0],
        'email'   => $validated_email[0],
        'message' => $validated_message[0],
    );

    // return JSON response and all validated data
    return array( $our_response, $validated_data);
}
//========================================================================
//                                       MESSAGE_POST CUSTOM POST SETTINGS
//========================================================================

/**
 * This code adds a badge to the messages, but we do not support this yet.
 */

//add_filter( 'add_menu_classes', 'add_plugin_bubble_so_17525062');
//
//function add_plugin_bubble_so_17525062( $menu )
//{
//    $pending_count = 10; // Use your code to create this number
//
//    foreach( $menu as $menu_key => $menu_data )
//    {
//        // From the plugin URL http://example.com/wp-admin/edit.php?post_type=acf
//        if( 'edit.php?post_type=message_post' != $menu_data[2] )
//            continue;
//        $menu[$menu_key][0] .= " <span class='update-plugins count-$pending_count'><span class='plugin-count'>" . number_format_i18n($pending_count) . '</span></span>';
//    }
//    return $menu;
//}


//------------------------------------------------------------------------
//                                   CREATE CUSTOM COLUMNS IN WORDPRESS UI
//------------------------------------------------------------------------

/**
 * Redefine the columns to use in the WordPress UI
 * @param $columns
 * @return array
 */
function message_create_custom_columns($columns) {
    // overwrite columns array
    $columns = array(
        'cb' => '<input type="checkbox">',  // check box, built int
        //'title'   => __('Title'),
        'from'    => __('From'),
        'message' => __('Message'),
        'date'    => __('Date'),
    );
    return $columns;

}
add_filter('manage_edit-message_post_columns', 'message_create_custom_columns');

/**
 * Change the primary column to a custom column for message custom post
 *
 * This changes the primary column to be the custom column 'from', and then
 * adds the small 'Edit | Quick Edit | Trash | when the mouse is hovered over
 * that column.
 *
 * @see https://make.wordpress.org/core/2015/08/08/list-table-changes-in-4-3/
 * @param $column
 * @param $screen
 * @return string
 */
function message_post_table_primary_column( $column, $screen ) {
    if ( 'edit-message_post' === $screen ) {
        $column = 'from';
    }

    return $column;
}
add_filter( 'list_table_primary_column', 'message_post_table_primary_column', 10, 2 );

//------------------------------------------------------------------------
//                                FILL IN COLUMNS PER POST IN WORDPRESS UI
//------------------------------------------------------------------------


/**
 * Fills in the columns on the message custom post with content
 *
 * Need to review/add security to this section when inserting data into
 * columns
 *
 * @param $column
 * @param $post_id
 */
function message_fill_custom_columns($column, $post_id) {
    global $post;

    switch ($column) {
        case 'from' :
            $name  = get_the_title();
            $email = get_post_meta($post_id, 'email', true);
            $phone = get_post_meta($post_id, 'phone', true);
            echo esc_html($name) . '<br>' . esc_html($email) . '<br>' . esc_html($phone);
            break;
        case 'message' :
            $message = nl2br(the_content());//get_the_content();
            echo esc_html(htmlentities($message));
            break;
    }

}
add_action('manage_message_post_posts_custom_column', 'message_fill_custom_columns', 10, 2);

//------------------------------------------------------------------------
//                                          RESIZE COLUMNS IN WORDPRESS UI
//------------------------------------------------------------------------

/**
 * We resize the column size for the message custom posts with css
 *
 * Ideally this would be moved to a css file somewhere if possible.
 */
function my_column_width() {
    echo '<style type="text/css">';
    echo '.column-from { width:20%; overflow:hidden }';
    echo '</style>';
}
add_action('admin_head', 'my_column_width');



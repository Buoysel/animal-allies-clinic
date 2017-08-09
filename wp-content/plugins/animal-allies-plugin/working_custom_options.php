
/**
* @internal never define functions inside callbacks.
* these functions could be run multiple times; this would result in a fatal error.
*/

/**
* custom option and settings
*/
function aa_settings_init() {
// register a new setting for "wporg" page
register_setting( 'aa_options', 'aa_options_name' );

// register a new section in the "wporg" page
add_settings_section(
'aa_options_section',
__( 'The Matrix has you.', 'wporg' ),
'aa_section_cb',
'aa_options'
);

// register a new field in the "wporg_section_developers" section, inside the "wporg" page
add_settings_field(
'aa_field', // as of WP 4.6 this value is used only internally
// use $args' label_for to populate the id inside the callback
__( 'Pill', 'wporg' ),
'aa_field_cb',
'aa_options',
'aa_options_section',
[
'label_for' => 'aa_field',
'class' => 'aa_row',
'wporg_custom_data' => 'custom',
]
);
}

/**
* register our wporg_settings_init to the admin_init action hook
*/
add_action( 'admin_init', 'aa_settings_init' );

/**
* custom option and settings:
* callback functions
*/

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function aa_section_cb( $args ) {
?>
<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
<?php
}

// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function aa_field_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'aa_options_name' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['wporg_custom_data'] ); ?>"
            name="aa_options_name[<?php echo esc_attr( $args['label_for'] ); ?>]"
    >
        <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
            <?php echo esc_html('red pill'); ?>
        </option>
        <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
            <?php echo esc_html('blue pill'); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg' ); ?>
    </p>
    <p class="description">
        <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg' ); ?>
    </p>
    <?php
}

/**
 * top level menu
 */
function aa_options_page() {
    // add top level menu page
    add_menu_page(
        'Animal Allies Options',    // title to show on menu page
        'Animal Allies Options',                  // text to show in the menu
        'manage_options',           // capability required to edit options
        'aa_options_group',          // unique menu slug
        'aa_options_page_html',     // function to call to render page
        'dashicons-admin-generic',  // icon to show in menu, could be custom
        '30'                        // position in the menu
    );
}

/**
 * register our wporg_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'aa_options_page' );

/**
 * top level menu:
 * callback functions
 */
function aa_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // add error/update messages

    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'wporg' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'wporg_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'aa_options' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'aa_options' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}

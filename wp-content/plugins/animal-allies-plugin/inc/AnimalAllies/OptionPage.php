<?php
namespace AnimalAllies;

/**
 * Class Options implements the Options page for the Animal Allies Plugin
 *
 *
 * @package AnimalAllies
 */
class OptionPage {

    public $pageTitle;
    public $menuText;
    public $setting;
    public $menuSlug;
    public $capability;
    public $menuIcon;
    public $menuPosition;

    public function __construct($args) {
        $this->pageTitle    = $args['pageTitle'];
        $this->menuText     = $args['menuText'];
        $this->menuSlug     = $args['menuSlug'];
        $this->capability   = $args['capability'];
        $this->menuIcon     = $args['menuIcon'];
        $this->menuPosition = $args['menuPosition'];
        $this->setting      = $args['setting'];

        add_action('admin_menu', [$this, 'addMenu']);
    }

    public function addMenu() {
        add_menu_page(
            $this->pageTitle,    // title to show on menu page
            $this->menuText,     // text to show in the menu
            $this->capability,   // capability required to edit options
            $this->menuSlug,     // unique menu slug
            [$this, 'getHTML'],  // function to call to render page
            $this->menuIcon,     // icon to show in menu, could be custom
            $this->menuPosition  // position in the menu
        );
    }

    public function showSetting($setting) {
        $this->setting = $setting;
    }

    public function getHTML() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // wordpress will add the "settings-updated" $_GET parameter to the url
        if ( isset($_GET['settings-updated']) ) {
            // add settings saved message with the class of "updated"
            add_settings_error($this->setting->groupName,
                $this->setting->groupName . 'SuccessMessage',
                'Settings Saved',
                'updated'
            );
        }
        // show error/update messages
        settings_errors( $this->setting->groupName );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">

                <?php
                // output security fields for the registered setting

                settings_fields( $this->setting->groupName );
                // output setting sections and their fields
                // (sections are registered for "aa_plugin", each field is registered to a specific section)
                do_settings_sections( $this->setting->groupName );
                // output save settings button
                submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
    }
}
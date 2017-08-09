<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/7/2017
 * Time: 8:56 PM
 */

namespace AnimalAllies;


class Section {
    public $sectionSlug;
    public $sectionTitle;
    public $callback;
    public $settingSlug;
    public $sectionDescription;
    public $setting;

    public function __construct($args) {
        $this->sectionSlug  = $args['sectionSlug'];
        $this->sectionTitle = $args['sectionTitle'];
    }

    public function addSection() {
        add_settings_section(
            $this->sectionSlug,
            $this->sectionTitle,
            [$this, 'getHTML'],
            $this->setting->groupName
        );
    }

    public function addToSetting(Setting $setting){
        $this->setting = $setting;
        add_action('admin_init', [$this, 'addSection']);
    }

    public function getHTML($args) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <?php echo esc_html($this->sectionDescription) ?>
        </p>
        <?php
    }
}
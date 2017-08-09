<?php
namespace AnimalAllies\Field;

use AnimalAllies\Field;

class RadioField extends Field {
    public $radioFields = [];

    public function addRadioFields($args) {
        foreach ($args as $key => $value) {
            $this->radioFields[$key] = $value;
        }
    }
    public function getHTML($args) {
        // get the value of the setting we've registered with register_setting()
        $options = get_option($this->section->setting->optionName);
        // output the field
        ?>
        <div style="margin:0.5em 0em;">
            
            <?php foreach($this->radioFields as $key => $value) {

            ?>
            <label style="display:block; margin: 0.5em 0;">
                <input type="radio" id="<?php echo esc_attr( $args['label_for'] ); ?>"
                       data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
                       name="<?php echo esc_attr($this->section->setting->optionName); ?>[<?php echo esc_attr( $args['label_for'] ); ?>]"
                       value="<?php echo esc_attr($value); ?>"
                       required
                    <?php
                    checked($options[$args['label_for']], $value);
                    ?>
                >

            <?php echo esc_html($key); ?>
            </label>
            <?php } // end foreach ?>

        </div>
        <p class="description"><?php echo esc_html($this->description);?></p>
        <?php
    }
}
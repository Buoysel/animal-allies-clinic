<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/8/2017
 * Time: 12:25 AM
 */

namespace AnimalAllies\Field;
use AnimalAllies\Field;


class TextField extends Field {

    public function getHTML($args) {
        $options = get_option($this->section->setting->optionName);
        ?>
        <input type="text"
               id="<?php echo esc_attr( $args['label_for'] ); ?>"
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="<?php echo esc_attr($this->section->setting->optionName); ?>[<?php echo esc_attr( $args['label_for'] ); ?>]"
               pattern="<?php echo $this->getHTMLPattern(); ?>"
               title="This is a format message"
               class="regular-text"
               <?php echo esc_attr( $this->isRequired ? 'required' : '' );?>
               value="<?php echo esc_attr(
                   isset( $options[ $args['label_for'] ] )
                       ?  $options[ $args['label_for'] ]
                       : ''
               ); ?>"
        >
        <?php //echo $this->section->setting->fields; ?>
        <p class="description"><?php echo strip_tags($this->description, '<a>');?></p>
        <?php
    }
}
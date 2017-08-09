<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/7/2017
 * Time: 9:32 PM
 */

namespace AnimalAllies;
use AnimalAllies\Validator;

class Field {
    public $fieldSlug;
    public $fieldTitle;
    public $trClass;
    public $section;
    public $description;
    public $fieldType;
    public $isRequired;
    public $parentField;
    public $parentValue;
    public $errorMessage;

    public function __construct($args) {
        $this->fieldSlug    = $args['fieldSlug'];
        $this->fieldTitle   = $args['fieldTitle'];
        $this->trClass      = $args['trClass'];
        $this->fieldType    = $args['fieldType'];
        $this->parentField  = $args['parentField'];
        $this->parentValue  = $args['parentValue'];
        $this->isRequired   = $args['isRequired'];
        $this->errorMessage = $args['errorMessage'];
    }

    public function addToSection($section) {
        $this->section = $section;
        array_push($this->section->setting->fields, $this);
        add_action('admin_init', [$this, 'addField']);
    }

    public function addField() {
        add_settings_field(
            $this->fieldSlug,              // slug for the field
            $this->fieldTitle,       // title of the field
            [$this, 'getHTML'],  // function to fill the field with form inputs
            $this->section->setting->groupName,        // slug of settings page to display field on
            $this->section->sectionSlug,               // slug name of section to display field within
            // extra optional args for outputting field
            [
                // put setting title in <label for=""> with for= this value
                'label_for' => $this->fieldSlug,
                'class'     => $this->trClass,  // css class to add to <tr> of field
               // 'aa_options_group_custom_data' => 'custom'
            ]
        );
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getHTMLPattern() {
        $val = new Validator;
        return $val->regexFor[$this->fieldType]['html5'];
    }

    public function getInputType() {
        switch ($this->fieldType) {
            case 'email':
                $inputType = 'email';
                break;
            case 'phone':
                $inputType =  'tel';
                break;
            default:
                $inputType =  'text';
        }
        return $inputType;

    }

    public function getHTML($args) {


        $options = get_option($this->section->setting->optionName);
        ?>
        <input type="email" id="<?php echo esc_attr( $args['label_for'] ); ?>"
               style="width:90%; "
               data-custom="<?php echo esc_attr( $args['aa_options_group_custom_data'] ); ?>"
               name="<?php echo esc_attr($this->section->setting->optionName); ?>[<?php echo esc_attr( $args['label_for'] ); ?>]"
               pattern="[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,24}"
               required
               value="<?php echo esc_attr(
                   isset( $options[ $args['label_for'] ] )
                       ?  $options[ $args['label_for'] ]
                       : ''
               ); ?>"
        >
        <p class="description"><?php echo esc_html($this->description) ?></p>
        <?php
    }

}
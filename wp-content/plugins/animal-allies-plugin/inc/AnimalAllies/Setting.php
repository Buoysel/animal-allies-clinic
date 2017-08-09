<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/7/2017
 * Time: 2:02 AM
 */

namespace AnimalAllies;

require_once('Validator.php');
use AnimalAllies\Validator;

class Setting {
    public $groupName;
    public $optionName;
    public $messageName;
    public $fields = array();
    public $errors;


    public function __construct($args) {
        $this->groupName  = $args['groupName'];
        $this->optionName = $args['optionName'];
        $this->messageName = $args['messageName'];

        add_action('admin_init', [$this, 'register']);
    }

    public function register() {
        register_setting(
            $this->groupName,
            $this->optionName,
            [
                'sanitize_callback' => [$this, 'sanitize']
            ]
        );
    }

    public function sanitize($input) {
        $val = new Validator;

        $options = get_option($this->optionName);
        $output = []; // new validated output

        // loop through each item
        foreach ($this->fields as $field) {

            $getNewValue = true;

            // if this field only shows when a parent field exists
            if ( $field->parentField != null and $field->parentField != '') {

                // if the parent field has already been validated
                if ( isset($output[$field->parentField->fieldSlug])) {
                    $getVal = $output[$field->parentField->fieldSlug];
                }
                else {
                    // validate the parent value
                    $getVal = sanitize_text_field(
                        $val->validate(
                            $field->parentField->fieldType,
                            $input[ $field->parentField->fieldSlug ]
                        )
                    );
                }
                // if parent value is set to value needed for this field to save
                if ($getVal == $field->parentValue) {
                    $getNewValue = true;
                }
                else {
                    $getNewValue = false;
                }

            }
            // if this value should be updated (default true)
            if ($getNewValue) {
                $result = $val->validate($field->fieldType, $input[ $field->fieldSlug ]);
            }
            // if the value should no be updated because its parent field is
            // not set to the designated value
            else {
                // use the old value for this field if it is set
                $result = isset($options[$field->fieldSlug])
                    ? $options[$field->fieldSlug]
                    : ''
                    ;
            }

            // if validated
            if ($result) {
                $output[$field->fieldSlug] = sanitize_text_field($result);
            }
            else {
                // show error if field is required
                if($field->isRequired) {
                    add_settings_error(
                        $this->groupName,
                        $field->fieldSlug . 'Error',
                        'Error saving "' . $field->fieldTitle . '" setting.',
                        'error');
                }
                $output[$field->fieldSlug] = '';
            }

        }
        return $output;
    }

}
<?php
namespace AnimalAllies;

use AnimalAllies\Field\RadioField;
use AnimalAllies\Field\TextField;
use AnimalAllies\OptionPage\OptionSubPage;

function createOptionContactPage($mainOption) {
//------------------------------------------------------------------------
//                                                                SETTINGS
//------------------------------------------------------------------------

    // Contact Page Setting
    $settingContactPage = new Setting([
        'groupName'  => 'AASettingContactPage',
        'optionName' => 'AAOptionContactPage',
    ]);

//------------------------------------------------------------------------
//                                                            OPTION PAGES
//------------------------------------------------------------------------

    // Contact Page Option / Menu Item - This is a sub menu option
    $optionContactPage = new OptionSubPage([
        'pageTitle'  => 'Contact Page Settings',
        'menuText'   => 'Contact Page',
        'capability' => 'manage_options',
        'menuSlug'   => 'AAMenuOptionsContactPage',
    ]);
    $optionContactPage->addToParentOption($mainOption); // see option-home.php
    $optionContactPage->showSetting($settingContactPage);

//========================================================================
//                                                                SECTIONS
//========================================================================

    // Contact Form
    $sectionContactForm = new Section([
        'sectionSlug'  => 'AASectionContactForm',
        'sectionTitle' => 'Contact Form',
    ]);
    $sectionContactForm->sectionDescription
        = 'These settings change how the contact form on the contact page is 
        processed.';
    $sectionContactForm->addToSetting($settingContactPage);

    // Google Maps
    $sectionGoogleMaps = new Section([
        'sectionSlug'  => 'AASectionGoogleMaps',
        'sectionTitle' => 'Google Maps API Key',
    ]);
    $sectionGoogleMaps->sectionDescription
        = 'The Google map on the contact page requires a Google Maps Embed
        API Key';
    $sectionGoogleMaps->addToSetting($settingContactPage);

    //====================================================================
    //                                                              FIELDS
    //====================================================================

    // Send Email Yes/No
    $fieldSendEmail = new RadioField([
        'fieldSlug'  => 'AAFieldSendEmail',
        'fieldTitle' => 'Send an email when the contact form is submitted',
        'fieldType'  => 'yesOrNo',
        'isRequired' => true,
    ]);
    $fieldSendEmail->errorMessage
        = 'Error setting whether to send an email when a form is submitted';
    $fieldSendEmail->addRadioFields([
        'Yes' => 'yes',
        'No'  => 'no',
    ]);
    $fieldSendEmail->addToSection($sectionContactForm);

    // Contact Form Email Address
    $fieldEmailAddress = new TextField([
        'fieldSlug'   => 'AAFieldContactFormEmail',
        'fieldTitle'  => 'Send contact form to this email address',
        'fieldType'   => 'email',
        'trClass'     => 'AAFieldContactFormEmailTR',
        'parentField' => $fieldSendEmail,
        'parentValue' => 'yes',
    ]);
    $fieldEmailAddress->addToSection($sectionContactForm);

    // Store Message Yes/No
    $fieldStoreMessage = new RadioField([
        'fieldSlug'  => 'AAFieldStoreMessage',
        'fieldTitle' => 'Store messages in WordPress',
        'fieldType'  => 'yesOrNo',
        'isRequired' => true,
    ]);
    $fieldStoreMessage->addRadioFields([
        'Yes' => 'yes',
        'No'  => 'no',
    ]);
    $fieldStoreMessage->description
        = 'Select "Yes" to store and view contact form submissions within 
        WordPress. This will create a new menu item titled "Messages".';
    $fieldStoreMessage->addToSection($sectionContactForm);

    // Google Captcha Yes/No
    $fieldEnableCaptcha = new RadioField([
        'fieldSlug'  => 'AAFieldEnableCaptcha',
        'fieldTitle' => 'Enable Google reCAPTCHA',
        'fieldType'  => 'yesOrNo',
        'isRequired' => true,
    ]);
    $fieldEnableCaptcha->description
        = 'Select "Yes" to place a Google reCAPTCHA element on the contact 
        form. This is a security feature intended to help reduce spam.';
    $fieldEnableCaptcha->addRadioFields([
        'Yes' => 'yes',
        'No'  => 'no',
    ]);
    $fieldEnableCaptcha->addToSection($sectionContactForm);

    // Google Captcha Site key
    $fieldSiteKey = new TextField([
        'fieldSlug'   => 'AAFieldCaptchaSiteKey',
        'fieldTitle'  => 'Google reCAPTCHA Site Key',
        'fieldType'   => 'ascii',
        'trClass'     => 'AAFieldCaptchaSiteKeyTR',
        'parentField' => $fieldEnableCaptcha,
        'parentValue' => 'yes',
    ]);
    $fieldSiteKey->description
        = 'Visit <a href="https://www.google.com/recaptcha" 
           target="_blank">Google reCAPTCHA</a> to obtain Google reCAPTCHA keys.';
    $fieldSiteKey->addToSection($sectionContactForm);

    // Google Captcha Secret key
    $fieldSecretKey = new TextField([
        'fieldSlug'   => 'AAFieldCaptchaSecretKey',
        'fieldTitle'  => 'Google reCAPTCHA Secret Key',
        'fieldType'   => 'ascii',
        'trClass'     => 'AAFieldCaptchaSecretKeyTR',
        'parentField' => $fieldEnableCaptcha,
        'parentValue' => 'yes',
    ]);
    $fieldSecretKey->description
        = 'Visit <a href="https://www.google.com/recaptcha" 
           target="_blank">Google reCAPTCHA</a> to obtain Google reCAPTCHA keys.';

    $fieldSecretKey->addToSection($sectionContactForm);

    // Google Maps Embed API key
    $fieldMapKey = new TextField([
        'fieldSlug' => 'AAFieldGoogleMapsEmbedAPIKey',
        'fieldTitle' => 'Google Maps Embed API Key',
        'fieldType' => 'ascii',
    ]);
    $fieldMapKey->description
        = 'Visit 
          <a href="https://developers.google.com/maps/documentation/embed/" 
          target="_blank">Google Maps Embed API</a> to obtain a key. The 
          map on the Contact Page may cease to function without a valid key.'
        ;
    $fieldMapKey->addToSection($sectionGoogleMaps);

}





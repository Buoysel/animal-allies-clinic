<?php
namespace AnimalAllies;

// use them for shorthand reference
use AnimalAllies\OptionPage;
use AnimalALlies\OptionPage\OptionSubPage;
use AnimalAllies\Setting;
use AnimalAllies\Section;
use AnimalAllies\Field;
use AnimalAllies\Field\TextField;


function createOptionContactInfo() {
//------------------------------------------------------------------------
//                                                                SETTINGS
//------------------------------------------------------------------------

// Site Contact Info Setting
    $settingContactInfo = new Setting([
        'groupName'  => 'AASettingContactInfo',
        'optionName' => 'AAOptionContactInfo',
    ]);

//------------------------------------------------------------------------
//                                                            OPTION PAGES
//------------------------------------------------------------------------

// Site Contact Information Page/Menu Item
    $optionContactInfo = new OptionPage([
        'pageTitle'    => 'Animal Allies Contact Information',
        'menuText'     => 'Website Options',
        'capability'   => 'manage_options',
        'menuSlug'     => 'AAMenuOptionsHome',
        'menuIcon'     => 'dashicons-admin-generic',
        'menuPosition' => '40',
    ]);
    $optionContactInfo->showSetting($settingContactInfo); // show this setting

//========================================================================
//                                                                SECTIONS
//========================================================================

// Site Contact Information
    $sectionContactInfo = new Section([
        'sectionSlug'  => 'AASectionContactInfo',
        'sectionTitle' => 'Contact Information',
    ]);
    $sectionContactInfo->addToSetting($settingContactInfo);
    $sectionContactInfo->sectionDescription
        = "Input your contact information here to allow visitors of your site
 contact you.";

//====================================================================
//                                                              FIELDS
//====================================================================


//--------------------------------------------------------------------
//                                            SITE CONTACT INFO FIELDS
//--------------------------------------------------------------------
// Email Address
    $fieldEmail = new TextField([
        'fieldSlug'  => 'AAFieldEmail',
        'fieldTitle' => 'Email Address',
        'fieldType'  => 'email',
    ]);
    $fieldEmail->addToSection($sectionContactInfo);
    $fieldEmail->description
        = 'Enter the email address you wish for visitors to send their emails.';

// Street Address
    $fieldStreetAddress = new TextField([
        'fieldSlug'  => 'AAFieldStreetAddress',
        'fieldTitle' => 'Street Address',
        'fieldType'  => 'ascii'
    ]);
    $fieldStreetAddress->description = "Enter your street address.";
    $fieldStreetAddress->addToSection($sectionContactInfo);

// City, State, Zip address line 2
    $fieldCityStateZip = new TextField([
        'fieldSlug'  => 'AAFieldCityStateZip',
        'fieldTitle' => 'City, State, and Zip',
        'fieldType'  => 'ascii',
    ]);
    $fieldCityStateZip->description
        = 'Enter your address city, state, and zip code e.g. 
    ( Spartanburg, SC 29303 )';
    $fieldCityStateZip->addToSection($sectionContactInfo);

// Phone
    $fieldPhone = new TextField([
        'fieldSlug'  => 'AAFieldPhone',
        'fieldTitle' => 'Phone',
        'fieldType'  => 'ascii',
    ]);
    $fieldPhone->description
        = 'Enter the phone number you would like customers to use to 
       contact your organization. e.g. (800)-555-5555';
    $fieldPhone->addToSection($sectionContactInfo);

// Hours of Operation
    $fieldHoursOfOperation = new TextField([
        'fieldSlug'  => 'AAHoursOfOperation',
        'fieldTitle' => 'Hours of Operation',
        'fieldType'  => 'ascii',

    ]);
    $fieldHoursOfOperation->description = 'Enter your hours of operation, e.g. (
Tuesday - Thursday 7:30am - 4:30pm )
';
    $fieldHoursOfOperation->addToSection($sectionContactInfo);


// Facebook URL
    $fieldFacebook = new TextField([
        'fieldSlug'  => 'AAFieldFacebook',
        'fieldTitle' => 'Facebook URL',
        'fieldType'  => 'ascii',
    ]);
    $fieldFacebook->description = "Enter the web address for your facebook site.";
    $fieldFacebook->addToSection($sectionContactInfo);

    // return this object so other options can be added as sub menu items
    return $optionContactInfo;

}

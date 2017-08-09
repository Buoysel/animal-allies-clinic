<?php
namespace AnimalAllies;

// include necessary class files
require_once("OptionPage.php");
require_once("OptionPage/OptionSubPage.php");
require_once('Setting.php');
require_once('Section.php');
require_once('Field.php');
require_once('Field/TextField.php');
require_once('Field/RadioField.php');

// pages which flesh out options with objects in a function
require_once('option-contact-info.php');
require_once('option-contact-page.php');


function createOptions() {
    $mainOption = createOptionContactInfo();
    createOptionContactPage($mainOption);
}
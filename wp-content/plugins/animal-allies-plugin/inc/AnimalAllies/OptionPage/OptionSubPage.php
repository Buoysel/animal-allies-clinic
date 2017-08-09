<?php
/**
 * Created by PhpStorm.
 * User: Andrew
 * Date: 4/8/2017
 * Time: 9:25 PM
 */

namespace AnimalAllies\OptionPage;
use AnimalAllies\OptionPage;


class OptionSubPage extends OptionPage {

    public $parentOptionPage;

    public function __construct($args) {
        $this->pageTitle    = $args['pageTitle'];
        $this->menuText     = $args['menuText'];
        $this->menuSlug     = $args['menuSlug'];
        $this->capability   = $args['capability'];
        $this->setting      = $args['setting'];
    }

    public function addToParentOption($optionPage) {
        $this->parentOptionPage = $optionPage;
        add_action('admin_menu', [$this, 'addSubMenu']);
    }


    public function addSubMenu() {
        add_submenu_page(
            $this->parentOptionPage->menuSlug,  // parent menu slug
            $this->pageTitle,    // title to show on menu page
            $this->menuText,     // text to show in the menu
            $this->capability,   // capability required to edit options
            $this->menuSlug,     // unique menu slug
            [$this, 'getHTML']   // function to call to render page
        );
    }
}
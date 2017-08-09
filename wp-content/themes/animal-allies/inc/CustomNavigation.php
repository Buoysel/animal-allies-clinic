<?php
/**
 * Class CustomNavigation
 *
 * This is our class to implement our custom CSS/HTML for the site navigation
 * within header.php. It is a WordPress Walker object, simply extending the
 * base class Walker_Nav_Menu class found in
 * wp-includes/class-walker-nav-menu.php
 *
 * In order to allow the user to pick an icon, the navigation relies upon
 * the plugin "Menu Icons" by Dzikri Aziz.  This allows the user to select
 * a font awesome icon in the menu admin area.  If Menu Icons plugin fails, we
 * load icons originally designed for specific pages, and a default icon for
 * new pages. We don't use the Menu Icons plugin to generate a menu, we only
 * pull the icon selected within it for our custom made menu.  For information
 * on the Menu Icons plugin see below.
 *
 * @see https://wordpress.org/plugins/menu-icons/ Menu Icons Plugin
 *
 * For information on how we implement our own navigation see the links below.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/ wp_nav_menu
 * @see https://codex.wordpress.org/Class_Reference/Walker WordPress Walker Info
 * @see https://codex.wordpress.org/Class_Reference/Walker#General_Menu_Example menu example
 * @see https://wordpress.org/support/topic/how-to-get-image-icon-url/ Menu Icon Help
 * @package AnimalAllies
 */
class AACustomNavigation extends Walker_Nav_Menu {

    // default icons for predesigned urls as a fallback option
    private $defaultIcons = [
        '/'              => 'fa-home',
        '/wordpress'     => 'fa-home',
        '/home'          => 'fa-home',
        '/services'      => 'fa-medkit',
        '/staff'         => 'fa-user-md',
        '/contributions' => 'fa-heart',
        '/faq'           => 'fa-question',
        '/contact'       => 'fa-phone',
    ];

    // default icon for new pages or any url without any icon defined
    private $defaultIcon = 'fa-paw';

    /**
     * sart_lvl function generates for each sub menu item I think.. not sure
     *
     * we dont support sub menus so this is not implemented
     *
     * @param string $output
     * @param int    $depth
     * @param array  $args
     */
    public function start_lvl(  &$output, $depth = 0, $args = array() ) {

    }

    /**
     * start_el function is called to generate each <li> menu item in the menu.
     *
     * @param string  $output reference to output variable for the menu
     * @param WP_Post $item
     * @param int     $depth
     * @param array   $args
     * @param int     $id
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $post;

        // get the final path of the url
        preg_match("%(/[\w\-]*)/?\z%", $item->url, $href_slug);

        // get the icon for this item TODO: if no regex match
        $icon = $this->getIcon($item, $href_slug[1]);

        // get the html for this menu item
        $html = $this->getHTML($item, $post, $icon);

        // add this iterm's html to the menu html
        $output .= $html;
    }

    /**
     * Gets the CSS class for the menu item icon
     *
     * Since the functionality of this menu depends upon another plugin
     * Menu Item Icons, we make sure the class is available to us.  If it
     * is not installed or does not have a value, we use our default icon
     * settings to set an icon.
     *
     * @param $item
     * @param $link_path
     * @return string
     */
    private function getIcon($item, $link_path) {
        $icon = $this->defaultIcon;  // holds CSS class  of icon as string

        // if the Menu Icon Plugin is Available use it to get the icon
        if (class_exists('Menu_Icons_Meta') and method_exists('Menu_Icons_Meta', 'get')) {
            // if the Menu Icon Plugin's icon has been set
            if ( Menu_Icons_Meta::get($item->ID) != null ) {
                $iconSettings = array_filter( Menu_Icons_Meta::get( $item->ID ) );
                // make sure the icon has a property
                $icon = isset($iconSettings['icon']) ?
                    $iconSettings['icon'] :
                    $this->getDefaultIcon($link_path);
            }
            // no Menu Icon Plugin Icon has been set
            else {
                $icon = $this->getDefaultIcon($link_path);
            }
        }
        // no Menu Icon Plugin installed
        else {
            $icon = $this->getDefaultIcon($link_path);
        }

        return $icon;
    }

    /**
     * Gets the default icon for a page title.
     *
     * We use this function to generate an icon for pages who do not have an
     * icon set in the WordPress admin UI.  This is helps to ensure that all
     * pages have at least one icon, and helps to error proof against unfound
     * icons or unset icons.
     *
     * @param $link_path final path of the url ( /page )
     * @return $icon string CSS class string of the icon
     */
    private function getDefaultIcon($link_path) {
        // if specific icon exists for this page, get it. else get default
        $icon = isset($this->defaultIcons[$link_path]) ?
            $this->defaultIcons[$link_path]            :
            $this->defaultIcon                         ;

        return $icon;  // CSS class
    }


    /**
     * We test if the the link is considered the current page by the link's
     * text and matching that with the page/post title.  Changes to a page's
     * title will automatically change the link text under normal operation.
     *
     * @param $item
     * @param $post
     * @return bool
     */
    private function isCurrentPage($item, $post) {
        // see if the current page's title is the same as the link's text
        return ($post->post_title == $item->title ? true : false);
    }

    /**
     * This method creates the html for the menu item.  It escapes values to
     * be inserted into the html.  The HTML is for a menu item which refers
     * to the current page is slightly different for the CSS to work.
     *
     * We don't use a </li> here because it is set in the end_el() method of
     * the parent class.
     *
     * @param $item
     * @param $post
     * @param $icon
     * @return string
     */
    private function getHTML($item, $post, $icon) {

        // escape variables for heredocs
        $escaped_url  = esc_url($item->url);
        $escaped_icon = esc_attr($icon);
        $escaped_link_text = esc_html($item->title);

        // if this link referes to the current page
        if ($this->isCurrentPage($item, $post)) {
            $html = <<< END_HTML
<li class="navBtnLi  navBtnLiThisPage">
	<a href="$escaped_url" class="navBtnAnchorThisPage">
		<span class="fa-stack fa-lg navBtnSpan">
			<i class="fa fa-circle fa-stack-2x navBtnCircleThisPage"></i>
			<i class="fa fa-circle-thin fa-stack-2x navBtnRingThisPage"></i>
			<i class="fa fa-stack-1x fa-inverse $escaped_icon navBtnIconThisPage"></i>
		</span>
		<span class="navBtnLabel navBtnLabelThisPage">$escaped_link_text</span>
	</a>
END_HTML;
        }
        // if the link does not refer to the current page
        else {
            $html = <<< END_HTML
<li class="navBtnLi  navBtnLi">
	<a href="$escaped_url" class="navBtnAnchor">
		<span class="fa-stack fa-lg navBtnSpan">
			<i class="fa fa-circle fa-stack-2x navBtnCircle"></i>
			<i class="fa fa-circle-thin fa-stack-2x navBtnRing"></i>
			<i class="fa fa-stack-1x fa-inverse $escaped_icon navBtnIcon"></i>
		</span>
		<span class="navBtnLabel navBtnLabel">$escaped_link_text</span>
	</a>
END_HTML;

        }

        return $html;
    }
}
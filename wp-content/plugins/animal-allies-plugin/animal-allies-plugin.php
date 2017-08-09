<?php
/*
Plugin Name: Animal Allies Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: Animal Allies Plugin to Support Custom Post Types
Version:     2017.15.03
Author:      Capstone Group
Author URI:
License:     GPL2
License URI:
Text Domain: wporg
Domain Path: /languages
*/


// simple class for setting custom page slugs, names, etc
require_once('inc/AnimalAlliesCustomPost.php');

// contact form processing and custom post modification
require_once('inc/message.php');

// include options pages for generating plugin options
require_once('inc/AnimalAllies/create-options.php');

// create the options page and contents
\AnimalAllies\createOptions();

/**
 *
 * Enqueue custom scripts/css based upon page loaded
 * @param $hook
 */
function aa_admin_scripts($hook) {
    // if the admin page is the aa_options_menu page
    if ($hook == 'toplevel_page_aa_options_menu' ) {
        // then enqueue our custom js for the options page
        wp_enqueue_script(
            'custom-options-js',
            plugin_dir_url(__FILE__) . '/js/options.js', array(), '1.0.2'
        );
    }

    if ($hook == 'website-options_page_AAMenuOptionsContactPage') {
        wp_enqueue_script(
            'custom-options-js',
            plugin_dir_url(__FILE__) . '/js/options.js', array(), '1.0.2'
        );
    }

}
add_action('admin_enqueue_scripts', 'aa_admin_scripts');

/**
 * Custom post type creation for staff members and wish list.
 *
 * @return void     returns nothing
 */
function create_post_type()
{
    $aa = new AnimalAlliesCustomPost();


    // FAQ Custom Post
    register_post_type( $aa->getSlug('faq'),  // slug
        array(
            'labels' => array (
                'name'            => __($aa->getName('faq') ),
                'singular_name'   => __($aa->getName('faq') ),
            ),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-info',
        )
    );

    // Carousel Custom Post
    register_post_type($aa->getSlug('carousel'),  // slug
        array(
            'labels' => array(
                'name' => __($aa->getName('carousel')),
                'singular_name' => __($aa->getName('carousel')),
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-format-gallery',
        )
    );

    // Services Custom post
    register_post_type($aa->getSlug('services'),
        array(
            'labels' => array (
                'name'            => __($aa->getName('services') ),
                'singular_name'   => __($aa->getName('services') ),
            ),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-hammer',
        )
    );

    // staff members custom post
    register_post_type($aa->getSlug('staff'),  // slug
        array(
            'labels' => array(
                'name' => __($aa->getName('staff')),
                'singular_name' => __($aa->getName('staff'))
            ),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-groups',
        )
    );

    // wish list custom post
    register_post_type($aa->getSlug('wish_list'),  // slug
        array(
            'labels' => array(
                'name' => __($aa->getName('wish_list')),
                'singular_name' => __($aa->getName('wish_list')),
            ),
            'public'      => true,
            'has_archive' => true,
            'menu_icon'   => 'dashicons-cart',
            //  'taxonomies'  => array( 'category'),
        )
    );

    // sponsors custom post
    register_post_type($aa->getSlug('sponsors'),
        array(
          'labels' => array(
              'name' => __($aa->getName('sponsors')),
              'singluar_name' => __($aa->getName('sponsors')),
          ),
          'public'      => true,
          'has_archive' => true,
          'menu_icon'   => 'dashicons-heart',
        )
    );


    // get plugin options, and only create this if the option is set to 'yes'
    $options = get_option('AAOptionContactPage');
    if ($options['AAFieldStoreMessage'] == 'yes' && current_user_can('manage_options')) {

        // Contact form custom post
        register_post_type($aa->getSlug('message'),  // slug
            array(
                'labels' => array(
                    'name' => __($aa->getName('message')),
                    'singular_name' => __($aa->getName('message')),
                ),
                'has_archive' => true,
                'exclude_from_search' => true,   // front end search results
                'publicly_queryable' => false,  // front end parse_request()
                'show_ui' => true,   // display backend UI
                'show_in_nav_menus' => false,  // not in navigation menus
                'show_in_admin_bar' => false,  // dont show in admin bar at top
                'menu_icon' => 'dashicons-email', // icon in menu
                'query_var' => false,
                'supports' => array(
                    'title',
                    'editor',
                    'custom-fields',
                )

            )
        );
    }


}
add_action( 'init', 'create_post_type' );


/**
 * Custom Taxonomy Categories for Wish List and Staff custom posts.
 *
 * Here we implement custom taxonomies in order to create custom categories
 * for the Wish List and Staff custom posts.  These categories serve to
 * organize the posts for display on the web site.  Instead of WordPress built
 * in categories, this custom taxonomy allows us to display only a few
 * valid category options in the Advanced Custom Field for a particular
 * custom post.  WordPress provides a built in way for users to create and_action( 'manage_movie_posts_custom_column', 'my_manage_movie_columns', 10, 2 );

 * edit these custom taxonomies.  We can also restrict its editing in the
 * options.
 *
 * WordPress' register_taxonomy() is used.
 *
 * @link https://codex.wordpress.org/Taxonomies WordPress taxonomies info
 * @return void
 *
 */
function animal_allies_custom_taxonomies() {
    $aa = new AnimalAlliesCustomPost(); // create custom post object

    /**
     * WordPress builtin custom taxonomy function.
     * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
     * Word press code reference
     */
    // wish list categories
    register_taxonomy(
        $aa->getTaxonomy('wish_list'), // taxonomy key
        $aa->getSlug('wish_list'),     // object_type to associate with taxonomy
        array(                         // array of arguments/options
            'label'        => __( 'Categories' ), // label
            'hierarchical' => true,  // make this taxonomy a category
            'show_admin_column' => true, // show category column posts grid
            'query_var'         => true,
        )
    );
    // staff categories
    register_taxonomy(
        $aa->getTaxonomy('staff'), // taxonomy key
        $aa->getSlug('staff'),     // object_type to associate with taxonomy
        array(                         // array of arguments/options
            'label'        => __( 'Categories' ), // label
            'hierarchical' => true,  // make this taxonomy a category
            'show_admin_column' => true, // show category column posts grid
            'query_var'         => true,
        )
    );
}
add_action( 'init', 'animal_allies_custom_taxonomies' );

/**
 * Function to change the drop down menu for custom posts to filter categories
 *
 * By default, WordPress does not support filtering custom posts by custom
 * taxonomies through the backend custom post UI.  This feature is important
 * for this site to manage a large number of posts.  This function modifies
 * the WordPress UI to include a drop down box with custom post taxonomy
 * information to filter posts.
 *
 * @returns void
 * @see http://wordpress.stackexchange.com/questions/578/adding-a-taxonomy-filter-to-admin-list-for-a-custom-post-type
 */
function restrict_listings_by_category() {
    $aa = new AnimalAlliesCustomPost();  // new custom post object

    global $typenow;    // current post type
    global $wp_query;

    // loop through custom post types to add dropdown menu
    foreach ( array('wish_list', 'staff') as $post ) {
        if ($typenow == $aa->getSlug($post) ) {

            // get all information about the taxonomy
            $taxonomy = get_taxonomy($aa->getTaxonomy($post));
            // alter the dropdown menu with these options
            wp_dropdown_categories(array(
                'show_option_all' =>  __("Show All {$taxonomy->label}"),
                'taxonomy'        =>  $aa->getTaxonomy($post),
                'name'            =>  $aa->getTaxonomy($post),
                'orderby'         =>  'date',
                'selected'        =>  $wp_query->query[$aa->getTaxonomy($post)], // $wp_query->query['term']
                'hierarchical'    =>  true,
                'depth'           =>  1,
                'show_count'      =>  true, // Show # listings in parens
                'hide_empty'      =>  true, // Don't show businesses w/o listings
            ));
        } //end if
    } //end foreach
}
add_action('restrict_manage_posts','restrict_listings_by_category');

/**
 * This function changes the category key's value in the url from
 * an integer ID to the slug of the category.
 *
 * Before the page is updated, we need to change the ID form of the category
 * itself to its slug.  The url might look like this before being changed
 *     &wish_list_category=14
 * This attempts to identify a category by its ID.  However, this pulls up a
 * blank list of posts, and we need to change it to use the category's slug.
 *
 * An ID of 0 will show all posts and filter nothing, and this is acceptable
 * for the "Show All" filter option.
 *
 * @param $query WordPress builtin $query variable
 * @return void
 */
function convert_category_id_to_slug($query)
{
    $aa = new AnimalAlliesCustomPost();

    global $typenow;
    global $pagenow;

    $qv = &$query->query_vars;
    //$post = 'wish_list';
    // $typenow == $aa->getSlug($post) &&
    foreach (array('wish_list', 'staff') as $post) {
        // if post is correct and the current page is the edit page
        if (  $pagenow == 'edit.php' && $typenow == $aa->getSlug($post)
              && isset($qv[ $aa->getTaxonomy($post) ])   // is category set
              && $qv[ $aa->getTaxonomy($post)]  != 0     // is category not zero
        ){
            // convert id to term
            $term = get_term_by('id', $qv[ $aa->getTaxonomy($post) ],
                $aa->getTaxonomy($post));
            // set the value to the slug of the category
            $qv[ $aa->getTaxonomy($post) ] = $term->slug;
        }
    } // end foreach
}
add_filter('parse_query','convert_category_id_to_slug');


function hide_menu_items_for_nonadmin()  {
     global $userID;
     if (!current_user_can('switch_themes')) {
          remove_menu_page('edit.php?post_type=acf');
          remove_menu_page('edit.php');
          remove_menu_page('edit-comments.php');
          remove_submenu_page('themes.php','widgets.php');
          remove_submenu_page('themes.php','themes.php');

          // make sure the non-admin user has this menu before stipping
          // sub-menu items
          if (current_user_can('edit_theme_options')) {
              //The Customize pages can't be hidden with remove_
              global $submenu;
              foreach($submenu['themes.php'] as $menu_index => $theme_menu){
                if( $theme_menu[0] == 'Customize'   ||
                    $theme_menu[0] == 'Header'      ||
                    $theme_menu[0] == 'Background')
                unset($submenu['themes.php'][$menu_index]);
              }
          }
     }
}
add_action('admin_init', 'hide_menu_items_for_nonadmin');

/**
 * Block access to
 */
function block_access_for_nonadmin() {
    global $userID;
    if (!current_user_can('switch_themes')){
      $screen = get_current_screen();
      $base   = $screen->id;

      if ('edit-post'     == $base ||
          'edit-comments' == $base ||
          'themes'        == $base ||
          'widgets'       == $base)
          wp_die('Sorry, you are not allowed to access this page.');
    }
}
add_action('current_screen', 'block_access_for_nonadmin');
?>

<?php
/**
 * Animal Allies functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Animal_Allies
 */


if ( ! function_exists( 'animal_allies_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function animal_allies_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Animal Allies, use a find and replace
	 * to change 'animal-allies' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'animal-allies', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'animal_allies_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );


}
endif;
add_action( 'after_setup_theme', 'animal_allies_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function animal_allies_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'animal_allies_content_width', 640 );
}
add_action( 'after_setup_theme', 'animal_allies_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function animal_allies_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'animal-allies' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'animal-allies' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'animal_allies_widgets_init' );

// quick fix to test and see if we can upgrade jquery version and put it
// in the footer, not header
function modify_jquery_version() {
    wp_deregister_script('jquery');

    // get from CDN for faster loads, may change to google?
    wp_register_script('jquery',
           'https://code.jquery.com/jquery-3.1.1.min.js', array(), '3.3.1');
    wp_enqueue_script('jquery');

}
add_action('init', 'modify_jquery_version');

/**
 * Enqueue scripts and styles for admin pages
 */

function aa_admin_theme_scripts($hook) {
    $aa = new AnimalAlliesCustomPost(); // new custom post object

    // enqueue scripts for editing posts
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        $screen = get_current_screen(); // gets the current screen

        // if the screen is valid and the current screen is editing the
        // services custom post
        if ( is_object($screen) && $aa->getSlug('services') == $screen->post_type) {
            // enqueue our custom javascript for picking icons
            wp_enqueue_script(
                'icon-picker-js',
                get_template_directory_uri() . '/js/iconPicker.js', array(),
                '1.0.0', true
            );
            wp_enqueue_style(
                'font-awesome-css',
                get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css', array(),
                '4.7.0'
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'aa_admin_theme_scripts');

/**
 * Enqueue scripts and styles for front end content
 */
function animal_allies_scripts() {

	// helps convert nav to collapseable style
    wp_enqueue_script( 'animal-allies-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'animal-allies-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// bootstrap scripts and styles
	wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery' ), '3.3.7', true );
    wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', 'all' );
    wp_register_style( 'modern-business-css', get_template_directory_uri() . '/css/modern-business.css', array(), '3.3.7', 'all' );
    wp_register_style( 'font-awesome-css', get_template_directory_uri() . '/font-awesome/css/font-awesome.min.css', array(), '4.2.0', 'all' );

    // our theme style.css
    wp_register_style('animal-allies-style', get_stylesheet_uri(), array(), '1.1.1');


    // contact form scripts
    wp_register_script( 'form-validation-js', get_template_directory_uri() . '/js/jqBootstrapValidation.js', array('jquery' ), '', true);
    wp_register_script( 'contact-me-js', get_template_directory_uri() . '/js/contact_me.js', array('jquery' ), '1.0.0', true);
    wp_register_script( 'google-recaptcha-js','https://www.google.com/recaptcha/api.js' ); // for google recaptcha service
    wp_register_script( 'sponsor-carousel-js', get_template_directory_uri() . '/js/sponsor-carousel.js', array('jquery' ), '1.0.0', true);
    // enqueue contact scripts of this is the contact page
    if (is_page('Contact')) {

        // get option for whether or not to enable google reCAPTCHA
        $options = get_option('AAOptionContactPage');
        // will be 'yes' if enabled, 'no' if not enabled
        $enable_recaptcha = $options['AAFieldEnableCaptcha'];

        wp_enqueue_script('form-validation-js');
        wp_enqueue_script('contact-me-js');

        // only enqueue google recaptcha js if the option is set to 'yes'
        if ($enable_recaptcha == 'yes') {
            wp_enqueue_script('google-recaptcha-js');
        }

        // need nonce for word press to use AJAX, creates sessions
        $nonce = wp_create_nonce( 'aa_submit_contact_form' );
        /**
         * Modify contact_me.js javascript from here using localize script.
         *
         * We create an javascript object called aa_ajax_object.
         * In the array below are the attributes and their values.
         * The javascript code has been modified to reference aa_ajax_object.ajax_url
         * or other property we define here.  This part fills in those values
         * before the javascript used.
         */
        wp_localize_script('contact-me-js', 'aa_ajax_object', array(
            'ajax_url'    => admin_url('admin-ajax.php'),  // wordpress url to handle ajax requests,
            '_ajax_nonce' => $nonce,
            'enable_recaptcha' => $enable_recaptcha  // send 'yes' or 'no'
        ));


    }
    else if ( is_page('Sponsors')) {
        wp_enqueue_script('sponsor-carousel-js'); // for the sponsors images
    }

    // jquery may already be enqueued.  we actually deregister above, may change this...?
    wp_enqueue_script( 'jquery');


    wp_enqueue_script( 'bootstrap-js' );
    wp_enqueue_script( 'jquery-js' );
    wp_enqueue_script( 'jquery-ui-js' );
    wp_enqueue_style( 'bootstrap-css' );
    wp_enqueue_style( 'modern-business-css' );
    wp_enqueue_style( 'font-awesome-css' );
    
    // our theme  style.css
    wp_enqueue_style('animal-allies-style');
}
add_action( 'wp_enqueue_scripts', 'animal_allies_scripts' );
remove_filter('the_content', 'wpautop'); // for help with bootstrap support

/**
 * Register the menu for navigation
 */
function register_my_menu() {
    register_nav_menu( 'navigation', __('Navigation Menu', 'theme_slug' ));
}
add_action( 'init', 'register_my_menu');

/**
 * Helper function to get escaped field from ACF
 * and also normalize values.
 *
 * @param $field_key
 * @param bool $post_id
 * @param bool $format_value
 * @param string $escape_method esc_html / esc_attr or NULL for none
 * @return array|bool|string
 */
function get_field_escaped($field_key, $post_id = false, $format_value = true, $escape_method = 'esc_html')
{
    $field = get_field($field_key, $post_id, $format_value);

    /* Check for null and falsy values and always return space */
    if($field === NULL || $field === FALSE)
        $field = '';

    /* Handle arrays */
    if(is_array($field))
    {
        $field_escaped = array();
        foreach($field as $key => $value)
        {
            $field_escaped[$key] = ($escape_method === NULL) ? $value : $escape_method($value);
        }
        return $field_escaped;
    }
    else
        return ($escape_method === NULL) ? $field : $escape_method($field);
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

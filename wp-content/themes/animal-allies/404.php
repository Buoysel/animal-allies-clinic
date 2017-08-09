<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Animal_Allies
 */


/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package animal-allies
 */

require_once("inc/CustomNavigation.php");

?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto:400,700" rel="stylesheet">

        <?php wp_head(); ?>

    </head>
    <!-- body -->
<body <?php body_class(); ?> id="body">

    <!-- Navigation -->
    <nav id="theNav" class="navbar" role="navigation">
        <div id="navContainer" class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div id="navbarHeader" class="navbar-header">
                <button id="navButton" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="navLogoLink" class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <!--<img id="navLogo" src="<?php echo esc_url(get_template_directory_uri()); ?>/img/logo-normal-with-text.png"> -->
                </a>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse collapse" id="navbar">

                <?php

                /**
                 * Creates the navigation from our custom walk class
                 * AACustomNavigation.
                 * @see inc/CustomNavigation.php
                 */
                wp_nav_menu([
                    'menu'       => 'navigation',
                    'menu_class' => 'nav navbar-nav navbar-right',
                    'walker'     => new AACustomNavigation,
                    'container'  => false,
                ]);
                ?>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>
<div id="flexBox"><!--flexbox div -->
    <!-- Page Content -->
    <main style="margin:0;">
    <div class="titleSection">
        <div class="container">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Oops...</h1>
                </div>
            </div>
        </div>
    </div>

<div class="wideSection whiteBG flex1">
    <div class="container">

        <!-- Opening 'container div and breadcrumbs in header -->
        <!-- Image Header -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                
                <h2 class="page-header">Sorry, I was unable to find the page you requested.</h2>
                <p><a href="<?php echo esc_url(home_url('/')); ?>">Click here</a> to find your way
                    back home, or use the menu at the top of the page.</p>

            </div>
        </div>

    </div><!-- /container -->
</div><!-- /wideSection whiteBG -->

<?php
get_footer();

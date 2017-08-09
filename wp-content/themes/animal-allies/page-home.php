<?php

/**
 * Assign Advanced Custom Fields to variables for easy
 * access in page HTML to follow.  get_field is a function
 * provided by Advanced Custom Fields plugin to get data
 * from the post's custom fields.
 */

// Main Image object for About Section, escaped later
$main_image         =       get_field( "main_image");

// Text for the About Section
$about_title_1   	=	    get_field_escaped( "about_title_1" );
$about_text_1    	=       get_field_escaped( "about_text_1" );
$about_title_2   	=      	get_field_escaped( "about_title_2" );;
$about_text_2    	=       get_field_escaped( "about_text_2" );
$about_title_3   	=      	get_field_escaped( "about_title_3" );
$about_text_3   	=       get_field_escaped( "about_text_3" );

// Text for statistics, found at bottom of page
$surgery_statistics	=	    get_field_escaped( "surgery_statistics" );
$current_goal		=	    get_field_escaped( "current_goal" );

// Array of Customer Image Objects for Bottom of Page, escaped later
$customer_images = [
    get_field("customer1_image"),
    get_field("customer2_image"),
    get_field("customer3_image"),
    get_field("customer4_image"),
    get_field("customer5_image"),
    get_field("customer6_image"),
];


// get header.php template
get_header(); ?>

    <!-- Opening container div and breadcrums in header -->

        <!-- Intro Content -->
        <div class="row">
            <div class="col-md-6">
                <img class="img-responsive"
                     src="<?php // Use user supplied image or default image
                        echo ($main_image['url'] ? esc_url($main_image['url'])
                        : bloginfo('stylesheet_directory') . '/img/Trusted_Sign-735x270.jpg>');
                ?>"
                     alt="<?php // Use user supplied alt image or blank
                         echo ($main_image['alt'] ? esc_attr($main_image['alt'])
                         : '');
                     ?>">
            </div>
            <div class="col-md-6">
                <h2><?php echo $about_title_1 ?></h2>
                <h3>
                    <?php echo $about_text_1 ?>
                </h3>
                <h2><?php echo $about_title_2 ?></h2>
                <h3>
                    <?php echo $about_text_2 ?>
                </h3>
                <h2><?php echo $about_title_3 ?></h2>
                <h3>
                    <?php echo $about_text_3 ?>
                </h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Our Customers -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Reviews</h2>
            </div>

            <?php
                // loop through all images and output html
                for ($i = 0; $i < sizeOf($customer_images); $i++) {
            ?>
            <div class="col-md-2 col-sm-4 col-xs-6">
                <img class="img-responsive customer-img"
                     src="<?php echo ($customer_images[$i]['url']      // if this is set
                             ? esc_url($customer_images[$i]['url'])    // then output url
                             : 'http://placehold.it/500x300');         // else show placehoder
                         ?>"
                     alt="<?php echo ($customer_images[$i]['alt']     // if this is set
                             ? esc_attr($customer_images[$i]['alt'])  // then show alt text
                             : '');                                   // else show blank
                         ?>"
                >
            </div>
            <?php
                } // end for loop
            ?>

        </div>
        <!-- /.row -->
        <hr>

        <span style="text-align:center">
        <h1><?php echo $surgery_statistics ?></h1>
		    <h1><?php echo $current_goal ?></h1>
        </span>

    <!-- /.container -->
<?php
// get footer.php template
get_footer();

<?php
/**
 * Assign Advanced Custom Fields to variables for easy
 * access in page HTML to follow.  get_field is a function
 * provided by Advanced Custom Fields plugin to get data
 * from the post's custom fields.
 *
 */
$aa = new AnimalAlliesCustomPost(); // new custom post object for slugs

$main_text         =        get_field_escaped('main_text');
// Image object for Mission and Goals Section, escaped later
$goal_image         =       get_field( "goal_image");

// Text for the Mission and Goals Section
$about_title_2   	=      	get_field_escaped( "about_title_2" );;
$about_text_2    	=       get_field_escaped( "about_text_2" );
$about_title_3   	=      	get_field_escaped( "about_title_3" );
$about_text_3   	=       get_field_escaped( "about_text_3" );


$statistics_image   =       get_field('statistics_image');

// Text for statistics, found at bottom of page
$surgery_statistics	=	    get_field( "surgery_statistics" );
$current_goal		=	    get_field( "current_goal" );

$args = array (
    'numberposts'       => -1,
    'orderby'           => 'date',  // allow admin to set order in admin UI
    'order'             => 'DESC',
    'post_type'         => $aa->getSlug('carousel'),
    'post_status'       => 'publish',
    'suppress_filters'  => true
);

//get all posts for the carousel news thing
$posts_array = get_posts($args);

// get header.php template
get_header(); ?>

<div class="wideSection lightGreyBG">
    <div class="container">
    <!-- CAROUSEL -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol id="carouselDots" class="carousel-indicators">
            <?php
            // generate the small selection buttons for each slide
            $number_of_posts = count($posts_array);
            for ($i = 0; $i < $number_of_posts; $i++) {
                ?>
                <li data-target="#myCarousel"
                    data-slide-to="<?php echo esc_attr($i) ?>" <?php echo $i == 0 ? 'class="active"' : '' ?>
                ></li>

                <?php
            } // end for loop
            ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php
                $i = 0; // simple counter for initial active state

                // loop through each custom post
                foreach ($posts_array as $post) {
                    // get the fields in nice variables
                    $image   = get_field('news_image');
                    $link_url = get_field('link_url');
                    $add_link = get_field('add_link'); // true or false

                    // whether to open link new window.  true or false
                    $link_window = get_field('link_window');

                    // if this image has a link then add it
                    if( isset($link_url) && $link_url != '' && $add_link == true ) {
                        ?><a href="<?php echo esc_url($link_url);?>"
                             target="<?php echo esc_attr($link_window ? '_blank' : '_self'); ?>"
                          >
                    <?php } // end iff ?>

                    <?php
                    /**
                     * Set the first item as active, and build the news item
                     */
                    ?>
                    <div class="item<?php echo $i == 0 ? ' active' : '' ?>">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt']); ?>"
                             class="img-responsive center-block newsSlide"
                        >

                        <div class="carousel-caption">
                            <h3><?php echo get_field_escaped('news_title'); ?></h3>
                            <p><?php echo get_field_escaped('news_description'); ?></p>
                        </div>

                    <?php

                    // close the <a> tag if it was implemented.
                    if( isset($link_url) && $link_url != '' ) {
                        ?></a>
                    <?php }  // end if ?>


                    </div>
                    <?php
                    $i++;
                } // end foreach
            ?>

        </div>
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- CAROUSEL ENDS-->

    <p class="homeSubtitle"><?php echo $main_text ?></p>

</div>
</div>
<div class="wideSection whiteBG">
    <div class="container">


    <!-- Intro Content -->
        <div class="row">
            <div class="col-xs-5 hidden-xs col-sm-5 col-md-5 col-lg-4">
                <img class="img-responsive img-circle" src="<?php echo esc_url($goal_image['url']) ?>"
                     alt="<?php echo $goal_image['alt'] ?>">
            </div>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 col-lg-offset-1 ourMission" >
                <h2><?php echo $about_title_2; ?></h2>
                <p><?php echo $about_text_2;  ?></p>
                <h2><?php echo $about_title_3; ?></h2>
                <p><?php echo $about_text_3;  ?></p>
            </div>

        </div>
            <!--<h2></h2>
                <h3 class="paragraphText"></h3> -->
    </div><!-- /.container -->
</div><!-- /wideSection -->

<!-- goals and statistics -->
<div class="wideSection veryLightGreyBG">
    <div class="container">
        <div class="row ourStatistics">
            <div class="col-lg-9 col-md-10 col-sm-10 col-xs-12">
                <p class="text-center"><?php echo strip_tags($surgery_statistics, '<strong>'); ?></p>
                <p class="text-center"><?php echo strip_tags($current_goal, '<strong>'); ?></p>
            </div>
            <div class="col-lg-3 col-md-2 col-sm-2 hidden-xs">
                <img class="img-responsive"
                     src="<?php echo esc_url($statistics_image['url']);?>"
                     alt="<?php echo esc_attr($statistics_image['alt']); ?>"
                >
            </div>



        </div>
    </div>
</div>

<?php
// get footer.php template
get_footer();

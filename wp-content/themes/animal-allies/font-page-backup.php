<?php
/**
 * Assign Advanced Custom Fields to variables for easy
 * access in page HTML to follow.  get_field is a function
 * provided by Advanced Custom Fields plugin to get data
 * from the post's custom fields.
 */
$aa = new AnimalAlliesCustomPost(); // new custom post object for slugs

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

$args = array (
    'numberposts'       => -1,
    'orderby'           => 'date',
    'order'             => 'DESC',
    'post_type'         => $aa->getSlug('carousel'),
    'post_status'       => 'publish',
    'suppress_filters'  => true
);

//get all posts for the carousel news thing
$posts_array = get_posts($args);

// get header.php template
get_header(); ?>

    <!-- CAROUSEL -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
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
            foreach ($posts_array as $post) {
            $image = get_field('news_image');
            $link_url = get_field('link_url');

            if( isset($link_url) && $link_url != '' ) {
            ?><a href="<?php echo esc_url($link_url);?>">
                <?php } ?>
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
                if( isset($link_url) && $link_url != '' ) {
                ?></a>
        <?php } ?>


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
    <hr>

    <!-- /.row --
<!-- Intro Content -->
    <div class="row">
        <div class="col-md-6">
            <img class="img-responsive" src="<?php echo $main_image['url'] ?>"
                 alt="<?php echo $main_image['alt'] ?>">
            <hr>
            <span style="text-align:center">
                <h2><?php echo $surgery_statistics ?></h2>
                <h2><?php echo $current_goal ?></h2>
            </span>
        </div>
        <div class="col-md-6">
            <h2><?php echo $about_title_1; ?></h2>
            <h3 class="paragraphText"><?php echo $about_text_1;  ?></h3>
            <h2><?php echo $about_title_2; ?></h2>
            <h3><?php echo $about_text_2;  ?></h3>
            <h2><?php echo $about_title_3; ?></h2>
            <h3><?php echo $about_text_3;  ?></h3>
        </div>
    </div>

    <!-- /.container -->
<?php
// get footer.php template
get_footer();

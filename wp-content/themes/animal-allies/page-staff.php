<?php

/**
 * The arguments to pass to the get_posts() function,
 * which gets the Staff Members custom post content
 * metadata (custom field values)
 */



/**
 * This function takes a category ID and returns all posts
 * which belong to the category, with specific settings.
 *
 * Called later in the html within a php loop which gathers
 * each sub category of the Wish List category.  These are passed to this
 * function in order to retrieve the posts for each sub category.
 *
 * @param $category_id   - id of the category to select
 * @return array         - an array of posts
 */

$aa = new AnimalAlliesCustomPost();
function get_posts_for_category( $category_id ) {
    $aa = new AnimalAlliesCustomPost();
    $args = array(
        'numberposts'      => -1,              // all posts
        'order'            => 'DESC',
        'post_type'        => $aa->getSlug('staff'),
        'post_status'      => 'publish',
        'suppress_filters' => true,
        'tax_query'        => array(
            array(
                'taxonomy' => $aa->getTaxonomy('staff'),
                'field'    => 'term_id',
                'terms'    => $category_id,
            )
        )
    );

    return get_posts($args);
}


$board_of_directors_photo = get_field('board_of_directors_photo');
$board_of_directors       = get_field('board_of_directors');

// Retrieve 50 posts of the type 'staff_members'
$posts_array = get_posts( $args );

// get header.php
get_header(); ?>

<div class="wideSection lightGreyBG">
    <div class="container">

  <!-- Opening 'container div and breadcrumbs in header -->

        <!-- Image Header -->
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo get_the_post_thumbnail(
                    get_the_ID(),                 // post id or WP_Post object
                    [1200, 300],                  // array with size width/height in pixels
                    [
                            'class' => 'img-responsive featuredImage'
                    ] // array of attributes
                );
                ?>
            </div>
        </div>
        <!-- /.row -->

<?php
// get all custom taxomony categories for tied to the staff custom post
$categories = get_terms( array(
    'taxonomy' => $aa->getTaxonomy('staff'),
    'order_by' => 'date',               // this lets users order in post view
    'order'    => 'DESC',               // top post is first
));

// loop through each first child sub category of the Staff page
foreach ($categories as $category) {
    // get all posts for this category
    $category_posts = get_posts_for_category($category->term_id);

    // make sure we don't output any html for any categories which
    // do not belong to at least one staff post.  This should
    // not be the case but just in case we check.
    if ( sizeof($category_posts) == 0 ) {
        continue;
    }

     //output the category name along with the first row of a category.
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?php echo esc_html($category->name); ?></h2>
        </div>
    <?php

    // simple variable to count when to add a new row
    // there should be up to four columns in a row
    $i = 0;

    // loop through each post in a category to output employee information
    foreach ($category_posts as $post) {
        // setup the post data to use global post functions
        setup_postdata($post);

        // if this is the start of new row, make a new row
        if ( $i % 4 == 0 && $i > 0 ) {
            ?>
            </div><div class="row">
            <?php
        }


        $imgUrl = ''; // holds the image url
        // if there is a staph photo set then use it
        if (get_field_escaped('staff_photo') != ''){
            $imgUrl = get_field_escaped('staff_photo', $post->ID);
        }
        // else set the image as a placeholder
        else {
            $imgUrl = 'http://placehold.it/192x192?text=Profile';
        }
        // output the cell html with post's custom field information
        ?>
        <div class="col-md-3 col-sm-6">
            <div class="panel panel-default text-center">
                <div class="panel-heading">
                            <span class="fa-stack fa-5x">
                                <img class="img-rounded" src="<?php echo $imgUrl; ?>" style="max-width: 100%;  max-height: 100%;"/>
                            </span>
                </div>
                <div class="panel-body staffPanelInfo">
                    <h4 class="staffName"><?php echo get_field_escaped('staff_name', $post->ID); ?></h4>
                    <p class="staffPosition"><?php echo get_field_escaped('staff_position', $post->ID); ?></p>
                </div>
            </div>
        </div>
        <?php
        $i++; // increment column counter
    } // end of foreach
    ?>
    </div><!-- /last staff row -->
<?php
} // end category foreach
?>
    </div>
</div>
    <div class="wideSection whiteBG">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Board of Directors</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <img class="img-responsive" style="margin-bottom: 20px;"
                         alt="<?php echo $board_of_directors_photo['alt']; ?>"
                         src="<?php echo $board_of_directors_photo['url'];?>">
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?php echo $board_of_directors ?>
                </div>

            </div>
        </div>
    </div>
<?php
get_footer();

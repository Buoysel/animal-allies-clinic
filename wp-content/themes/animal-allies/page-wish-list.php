<?php

$aa = new AnimalAlliesCustomPost(); // new custom post object
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
function get_posts_for_category( $category_id ) {
    $aa = new AnimalAlliesCustomPost();
    $args = array(
        'numberposts'      => -1,              // all posts
        'orderby'          => 'title',
        'order'            => 'ASC',
        'post_type'        => $aa->getSlug('wish_list'),
        'post_status'      => 'publish',
        'suppress_filters' => true,
        'tax_query'        => array(
            array(
                'taxonomy' => $aa->getTaxonomy('wish_list'),
                'field'    => 'term_id',
                'terms'    => $category_id,
            )
        )
    );

    return get_posts($args);
}

// get header.php template
get_header(); ?>

  <!-- Opening 'container div and breadcrumbs in header -->

        <!-- Image Header -->
        <div class="row">
            <div class="col-lg-12">
                <img class="img-responsive" src="http://placehold.it/1200x300" alt="">
            </div>
        </div>
        <!-- /.row -->

        <!-- Service Panels -->
        <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->

        <?php
        /**
         * Here we generate the html from the database to display each item
         * in the wish list.
         */

        // get all sub-categories of the Wish List Category
        $categories = get_terms( array(
            'taxonomy' => $aa->getTaxonomy('wish_list'),
            'order_by' => 'date',
            'order'    => 'DESC',
           // 'parent'   => get_cat_ID( 'Wish List' ),
        ));

        // loop through each category, get posts, and display post data
        foreach ($categories as $category) {

            // get all posts fur current category
            $my_posts = get_posts_for_category($category->term_id);

            // make sure we don't output any html for any categories which
            // do not belong to at least one "wish_list" post.  This should
            // not be the case but just in case we check.
            if ( sizeof($my_posts) == 0 ) {
                continue;
            }

            $i = 0; // simple counter for creating rows of <div> elements

            // begin a new row with the category name
            echo <<<CATEGORY
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">$category->name</h2>
    </div>
CATEGORY;

            // loop through each post to print out necessary html
            foreach ($my_posts as $post) {

                // prepare post data
                setup_postdata($post);

                /**
                 * There should be up to four items per row.  Start a new
                 * row if the counter reaches a multiple of 4.  The last
                 * row is closed outside this foreach loop by a </div> tag.
                 */

                if ( $i % 4 == 0 && $i > 0) {
                    echo '</div><div class="row">';
                }
                // output the cell html with post's custom field information
                ?>

                    <div class="col-md-3 col-sm-6">
                        <div class="panel panel-default text-center">
                            <div class="panel-body" style="height: 200px;">
                                <h4><?php echo get_field_escaped('item_name', $post->ID) ?></h4>
                <?php
                // output item description, or "Desciption: N/A" if there is none
                if (get_field('item_description',  $post->ID) != ''){
                    echo '<p>Description: ' . get_field_escaped('item_description', $post->ID) . '</p>';
                }
                else {
                    echo '<p>Description: N/A </p>';
                }

                // item quantity
                echo '<p>Quantity: ' . get_field_escaped('quantity',  $post->ID) . '</p>';

                // if refill is needed, indicate, otherwise show good supply
                if (get_field('refill_needed')){
                    echo '<p style="color:red;">Refill Requested</p>';
                }
                else {
                    echo '<p style="color:green;">Good Supply</p>';
                }

                ?>

                <a href="#" class="btn btn-primary">Link to Item</a>
                            </div>
                        </div>
                    </div>

                <?php

                $i++;  // increment item counter

            } // end foreach post

            echo '</div>'; // close final row
        } // end foreach category

        ?>

<?php
// get footer.php template
get_footer();

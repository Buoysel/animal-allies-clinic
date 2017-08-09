<?php
// get advanced custom field values for big red title section
$thank_you_title       = get_field_escaped('thank_you_title');
$thank_you_description = get_field_escaped('thank_you_description');
$thank_you_image       = get_field('thank_you_image');  // image object, escaped later

// get advanced custom fields values for donation information
// A textarea field. Is also escaped for javascript automatically, so using escaping it again
// will remove any HTML formatting.
$donate_information  = get_field('donate_information');


$donate_title = get_field_escaped('donate_title');        // title for the paypal section
$paypal_donate_image = get_field('paypal_donate_image');  // image object, escaped later

// wish list title and description
$wish_list_title = get_field_escaped('wish_list_title');
$wish_list_description = get_field('wish_list_description');

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

<div class="wideSection lightGreyBG">
    <div class="container">
  <!-- Opening 'container div and breadcrumbs in header -->

        <!-- Header Image -->
        <div class="row">
          <div class="col-lg-12">
            <div class="jumbotron" style="color:#fff; background-color:#8e1618; overflow: auto; padding: -10px;">
              <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 container">
                <h1 id="donateThankYouTitle"><?php echo $thank_you_title; ?></h1>
                <p id="donateThankYouDescription"><?php echo $thank_you_description;?></p>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <img class="img-responsive " src="<?php echo esc_url($thank_you_image['url']) ?>" style="
                  height: auto;
                  max-width:350%;
                  max-height:350%;
                  object-fit: contain;
                  margin-top:-10px;
                  alt="<?php echo esc_attr($thank_you_image['alt']) ?>"
                "/>
                <!-- Would like to center this image on smaller screens, but appearing on the right when normal sized is fine -->
              </div>
            </div>
          </div>
        </div> <!-- /Header Image -->
    </div>
</div>
<div class="wideSection whiteBG">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-header"><?php echo $donate_title; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-7">
                <?php echo $donate_information ?>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-5">
                <form method="post" action="https://www.paypal.com/cgi-bin/webscr" style="padding-top: 10px;">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="business" value="animalalliesclinic@yahoo.com">
                    <input type="hidden" name="item_name" value="">
                    <input type="hidden" name="return" value="">
                    <input type="hidden" name="cancel_return" value="">
                    <input type="hidden" name="image_url" value="">
                    <input type="hidden" name="bn" value="yahoo-sitebuilder">
                    <input type="hidden" name="pal" value="C3MGKKUCCAB9J">
                    <input type="hidden" name="mrb" value="R-5AJ59462NH120001H">
                    <input type="image" src="<?php echo esc_url($paypal_donate_image['url']) ?>"  style="img-responsive; max-height:66px; border: none;">
                <!-- Used Pixels to define width and height of image, because the image would use 100% of both when the screen was narrowed, but a percentage when full -->
                </form>
            </div>
        </div>
    </div>
</div>
<div class="wideSection lightGreyBG">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header"><?php echo $wish_list_title; ?></h2>
                <p><?php echo strip_tags($wish_list_description, '<br>'); ?></p>
            </div>
        </div>

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
            ?>
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?php echo esc_html($category->name);?></h2>
        </div>

        <?php
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
                    ?></div><div class="row"><?php
                }
                // output the cell html with post's custom field information
                ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="panel panel-default text-center">
                            <div class="panel-body" style="height: 200px;">
                                <h4 class="supplyName"><?php echo get_field_escaped('item_name', $post->ID) ?></h4>
                                <p class="supplyDescription"><?php
                                    // if description is set
                                    echo (get_field('item_description',  $post->ID) != null)
                                        // then echo the escaped description
                                        ?  get_field_escaped('item_description', $post->ID)
                                        // else echo the message below
                                        : '&nbsp;';
                                        ;
                                ?></p>
                                <p class="supplyQuantity">Quantity On Hand:
                                    <?php
                                        echo get_field_escaped('quantity',  $post->ID)
                                            . ' ' . get_field_escaped('units', $post->ID);
                                    ?>
                                </p>
                                <p class="supplyStatus" style="color:<?php
                                    // if refill is needed make color red, else green
                                    echo get_field('refill_needed') == true ? 'red' : 'green';
                                ?>;">
                                    <?php // if refill is needed display Refill text, else display Good Supply
                                    echo get_field('refill_needed') == true ? 'Refill Requested' : 'Good Supply';
                                    ?>
                                </p>

                                <a href="https://www.amazon.com/s/ref=nb_sb_ss_c_1_12?url=search-alias%3Daps&field-keywords=<?php
                                echo urlencode( get_field('item_name', $post->ID) );
                                ?>"
                                   class="btn btn-primary"
                                   target="_blank">
                                    Search on Amazon
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                $i++;  // increment item counter

            } // end foreach post
            ?></div> <!-- close final row --><?php
        } // end foreach category
        ?>
    </div>
</div>
<?php
// get footer.php template
get_footer();

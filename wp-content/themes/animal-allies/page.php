<?php
// Blank page.php that all new pages will be based on.

// get header.php template
get_header(); ?>
<div class="wideSection whiteBG flex1">
    <div class="container">

    <!-- Opening 'container div and breadcrumbs in header -->
    <!-- Image Header -->
    <div class="row featured-image">
        <div class="col-lg-12">
            <?php
                // gets the thumbnail for the post
                echo get_the_post_thumbnail(
                    get_the_ID(),                 // post id or WP_Post object
                    [1200, 300],                  // array with size width/height in pixels
                    ['class' => 'img-responsive featuredImage'] // array of attributes
                );
            ?>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-12">
            <?php
            $getPost = apply_filters('the_content', get_post_field('post_content', get_page_by_title(get_the_title())));
            $getLineBreaks = wpautop($getPost, true);
            echo $getLineBreaks;
            ?>
        </div>
    </div>

  </div><!-- /container -->
</div><!-- /wideSection whiteBG -->
<?php
// get footer.php template
get_footer();

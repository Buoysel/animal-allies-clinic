<?php

/**
 * No custom fields for this page yet
 */

// get header.php template
get_header(); ?>

  <!-- Opening 'container div and breadcrumbs in header -->

            <!-- Content Row -->
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    $getPost = apply_filters('the_content', get_post_field('post_content', get_page_by_title(get_the_title())));
                    $getLineBreaks = wpautop($getPost, true);
                    if ($getLineBreak == '')
                      echo 'We are not offering any specials at this time.';
                    else
                      echo $getLineBreaks;
                    ?>
                </div>
            </div>
            <!-- /.row -->

<?php
// get footer.php template
get_footer();

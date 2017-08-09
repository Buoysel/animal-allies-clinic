<?php

$aa = new AnimalAlliesCustomPost();  // new custom post object

/**
 * The arguments to pass to the get_posts() function,
 * which gets the Sponsors custom post content
 * metadata (custom field values)
 */
$args = array(
    'numberposts'      => -1,
    'orderby'          => 'title',
    'order'            => 'ASC',
    'post_type'        => $aa->getSlug('sponsors'),
    'post_status'      => 'publish',
    'suppress_filters' => true
);

// get all posts of type 'sponsors'
$posts_array = get_posts( $args );

// get header.php template
get_header(); ?>

<div class="wideSection whiteBG flex1" style="overflow:hidden;">
    <div class="container">

        <!-- Image Header -->
        <div class="row">
            <div class="col-md-12 whiteBG">
                <div class="slideBanner">
                <?php
                    $image_counter = 1;
                    foreach ($posts_array as $post) {
                        $imageURL = '';
                        setup_postdata($post);
                        $imageURL = get_field_escaped('sponsor_logo');
                        if ($imageURL == '')
                            continue;

                        switch ($image_counter) {
                            case 1:
                                ?>
                                <img class="col-md-3 col-sm-3 w3-animate-top slideShow1"
                                     src="<?php echo $imageURL ?>" />
                                <?php
                                $image_counter++;
                                break;
                            case 2:
                                ?>
                                <img class="col-md-3 col-sm-3 w3-animate-bottom slideShow2"
                                     src="<?php echo $imageURL ?>" />
                                <?php
                                $image_counter++;
                                break;
                            case 3:
                                ?>
                                <img class="col-md-3 col-sm-3 w3-animate-top slideShow3"
                                     src="<?php echo $imageURL ?>" />
                                <?php
                                $image_counter++;
                                break;
                            case 4:
                                ?>
                                <img class="col-md-3 col-sm-3 w3-animate-bottom slideShow4"
                                     src="<?php echo $imageURL ?>" />
                                <?php
                                $image_counter = 1;
                                break;
                        }
                    }
                ?>

                </div>
                <!-- /.slideBanner -->
            </div>
            <!-- /.column -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
<!-- /.wideSection -->

<div class="wideSection lightGreyBG flex1">
    <div class="container">

        <!-- Content Row -->
        <div class="row">
              <div class="col-md-4 veryLightGreyBG aaSponsors">
                <!-- Tried to format this the same way Andrew and Alex did,
                     but PHP would always throw an 'Unexpected end of file'
                     error after the get_footer() method... -->
                  <?php
                  //Display the sponsors

                  $c=0; // Column counter for 10 sponsors
                  $background_switch=1; //Swap columns between lightgrey and white

                  // Loop through each post in 'sponsors' and pull name
                  foreach ($posts_array as $post) {

                      // Setup the post data to use global post functions
                      setup_postdata($post);

                      // output each name.
                      ?>
                          <p><?php echo get_field_escaped('sponsor_name') ?></p>
                      <?php

                      $c++;
                      // Make a new column every 10 names.
                      if ($c % 10 == 0) {
                          // Close the current column
                          ?>
                              </div>
                          <?php
                          $c=0;

                          //Switch between white and grey background
                          if ($background_switch == 1) {
                              ?>
                                  <div class="col-md-4 whiteBG aaSponsors">
                              <?php
                              $background_switch = 0;
                          } else {
                              ?>
                                  <div class="col-md-4 veryLightGreyBG aaSponsors">
                              <?php
                              $background_switch = 1;
                          }
                      }
                  }
                  ?>
              </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
<!-- /.wideSection -->

<?php
// get footer.php template
get_footer();

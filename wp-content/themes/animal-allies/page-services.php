<?php
// include template function to create each service block
include_once('template-parts/serviceBlock.php');

// the title and paragraph for the Spay & Neuter section
$spay_and_neuter_title     = get_field_escaped('spay_and_neuter_title');
$spay_and_neuter_paragraph = get_field('spay_and_neuter_paragraph');

//Spay and Neuter prices for dogs and cats.
$dog_price_m = get_field_escaped('dog_price_m');
$dog_price_f = get_field_escaped('dog_price_f');

$cat_price_m = get_field_escaped('cat_price_m');
$cat_price_f = get_field_escaped('cat_price_f');

// title and paragraph for the Services section
$services_title     = get_field_escaped('services_title');
$services_paragraph = get_field('services_paragraph');


// title for the transportation section
$transportation_title = get_field_escaped('transportation_title');
$transportation_image = get_field('transportation_image');

// A WYSIWYG custom field, but scripts are escaped automatically and converted into paragraphs.
// Escaping this will remove the HTML formatting, however...
$transportation = get_field('transportation_information');

// title for the specials section
$specials_title = get_field_escaped('specials_title');
// Also a WYSIWYG field.
$specials = get_field('specials');


$aa = new AnimalAlliesCustomPost();  // custom post object to get slugs

/**
 * The arguments to pass to the get_posts() function,
 * which gets the Services custom post content
 * metadata (custom field values)
 */
$args = array (
    'numberposts'       => -1,
    'orderby'           => 'title',
    'order'             => 'ASC',
    'post_type'         => $aa->getSlug('services'),
    'post_status'       => 'publish',
    'suppress_filters'  => true
);

//get all posts of the type 'services'
$posts_array = get_posts($args);

// get header.php template
get_header(); ?>

<div class="wideSection lightGreyBG">
    <div class="container">

        <!-- Image Header -->
        <div class="row">
            <div class="col-lg-12">
                <?php
                    // gets 'featured image' for the post if set
                    echo get_the_post_thumbnail(
                        get_the_ID(),                 // post id or WP_Post object
                        [1200, 300],                  // array with size width/height in pixels
                        ['class' => 'img-responsive featuredImage'] // array of attributes
                    );
                ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <div class="container">
        <!--Spay/Neuter for Dogs and Cats-->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $spay_and_neuter_title; ?></h2>
            </div>
            <?php
            // if the services paragraph is set and not an empty string
            if ( isset($spay_and_neuter_paragraph) && $spay_and_neuter_paragraph != ''){

                // then show the paragraph
            ?>
            <div class="col-xs-12 servicesInfo">
                <p><?php echo strip_tags($spay_and_neuter_paragraph, '<br>'); ?></p>
            </div>
            <?php } // close if ?>

            <div class="col-md-4 col-sm-4 col-xs-12"> <!-- Column -->
                <div class="media">
                    <div class="pull-left">
                      <span class="fa-stack fa-2x">
                          <i class="fa fa-circle fa-stack-2x text-primary" style="color: #337ab7;"></i>
                          <i class="fa fa-paw fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading serviceItemName">Dogs</h4>
                        <p class="serviceItemPrice"><?php
                            echo 'Male: $'  . $dog_price_m . '</br>
                                Female: $'. $dog_price_f;
                            ?></p>
                    </div>
                </div>
            </div> <!-- Column -->
            <div class="col-md-4 col-sm-4 col-xs-12"> <!-- Column -->
              <div class="media">
                  <div class="pull-left">
                      <span class="fa-stack fa-2x">
                          <i class="fa fa-circle fa-stack-2x text-primary" style="color: #ff3300;"></i>
                          <i class="fa fa-paw fa-stack-1x fa-inverse"></i>
                      </span>
                  </div>
                  <div class="media-body">
                      <h4 class="media-heading serviceItemName">Cats</h4>
                      <p class="serviceItemPrice"><?php
                          echo 'Male: $'  . $cat_price_m . '</br>
                                Female: $'. $cat_price_f;
                      ?></p>
                  </div>
              </div>
            </div> <!-- Column -->
        </div> <!-- /row, /Spay/Neuter -->
    </div>
</div>
<div class="wideSection whiteBG">
    <div class="container">

        <!-- Service List -->
        <!-- The circle icons use Font Awesome's stacked icon classes. For more information, visit http://fontawesome.io/examples/ -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $services_title; ?></h2>
            </div>


        <?php
        // if the services paragraph is set and not an empty string
        if ( isset($services_paragraph) && $services_paragraph != ''){

            // then show the paragraph
            ?>
            <div class="col-xs-12 servicesInfo">
                <p><?php echo strip_tags($services_paragraph, '<br>'); ?></p>
            </div>
        <?php } // close if ?>

        </div>
        <div class="row"> <!-- start services first row -->

            <?php
              /**
              * Generate the HTML to show all Services
              */

              $i = 0;              // counter for generating 3 icons per row
              $serviceNumber = 0;  // Tracks the color picker

              foreach ($posts_array as $post) {

                  // set up the post data to use global post functions
                  setup_postdata($post);

                  // if three services have been printed, make a new row
                  if ($i % 3 == 0 && $i > 0) {
                      ?><!--</div>
                            <div class="row">-->
                      <?php
                  }

                  // Get escaped fields for generating the list items
                  $serviceName  = get_field_escaped('service');
                  $servicePrice = get_field_escaped('price');
                  $serviceIcon  = get_field_escaped('icon');
                  $serviceColor = '#8e1618';

                  /**
                   * Function to generate the html of each service item
                   * @see template-parts/serviceBlock.php
                   */
                  aa_create_service_block($serviceName, $servicePrice, $serviceIcon, $serviceColor);

                  // out put the cell html with post's custom field information
                  ?>

                  <?php
                      $i++; // increment row counter
              } // end foreach
            ?>
          </div>  <!-- /row -->
    </div>
</div>
<div class="wideSection veryLightGreyBG">
    <div class="container">
        <!-- Transportation -->
        <div class="row">
          <div class="col-lg-12">
              <h2 class="page-header"><?php echo $transportation_title; ?></h2>
          </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <?php echo $transportation; ?>
            </div>
            <div class="col-xs-12  col-sm-4 col-md-4 col-lg-4" >
                <img class="img-responsive img-circle" src="<?php echo esc_url($transportation_image['url']) ?>"
                     alt="<?php echo $transportation_image['alt'] ?>">
            </div>

        </div>


          <!-- /Transportation -->
    </div>
</div>
    <div class="wideSection whiteBG">
        <div class="container">
          <!-- Services -->
          <div class="row">
              <div class="col-lg-12">
                  <h2 class="page-header"><?php echo $specials_title; ?></h2>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12">
                <?php
                    echo ($specials != '') ? $specials : 'We are not offering any specials at this time.'
                ?>
              </div>
          </div>
          <!-- /Services -->

    </div><!-- container -->
</div><!-- wide thing -->

<?php
// get footer.php template
get_footer();

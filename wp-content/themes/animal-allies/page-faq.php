<?php

$aa = new AnimalAlliesCustomPost();  // new custom post object

// get custom fields for the text above the FAQ
$faq_content_title     = get_field_escaped('faq_content_title');
$faq_content_paragraph = get_field('faq_content_paragraph');

/**
 * The arguments to pass to the get_posts() function,
 * which gets the F.A.Q. custom post content
 * metadata (custom field values)
 */
$args = array(
    'numberposts'      => -1,
    'orderby'          => 'date',  // allows drag and drop ordering in admin
    'order'            => 'ASC',
    'post_type'        => $aa->getSlug('faq'),
    'post_status'      => 'publish',
    'suppress_filters' => true
);

// get all posts of type 'faq'
$posts_array = get_posts( $args );

// get header.php template
get_header(); ?>

<div class="wideSection lightGreyBG flex1">
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


        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="page-header"><?php echo $faq_content_title; ?></h2>
                <p class="faqHelp">
                    <?php
                    // strip all tags but allow links
                    echo strip_tags($faq_content_paragraph, '<a><br><strong>,'); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-group" id="accordion">

                    <?php
                    /**
                     * Generate the appropriate HTML to show the
                     * F.A.Q. information
                     */

                    $i = 0; // counter variable to give each faq a unique id #

                    // loop through each post in 'faq' and pull both the question and answers.
                    foreach ($posts_array as $post) {

                        // setup the post data to use global post functions
                        setup_postdata($post);

                        // output the cell html with post's custom field information
                        ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                       href="#collapse<?php echo esc_attr($i);?>">
                                        <?php echo get_field_escaped('question');?>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse<?php echo esc_attr($i);?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php echo get_field_escaped('answer');?>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel -->
                        <?php
                        $i++; // increment counter
                    } // end foreach
                    ?>
                </div>
                <!-- /.panel-group -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
</div>
<?php
// get footer.php template
get_footer();

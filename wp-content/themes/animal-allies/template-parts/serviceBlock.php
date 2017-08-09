<?php

/**
 * This function creates the html for each item within the services list.
 *
 * Colors are incremented based upon an array of colors.  Once we run out of
 * array colors, we start generating random colors.
 *
 * We pass serviceNumber as a reference to update the variable in the
 * page-service.php template.
 *
 * @param string $serviceName   string name of the service
 * @param string $servicePrice  string of the price to display without '$'
 * @param string $serviceIcon   CSS font-awesome class, defaults to fa-heart
 * @param int    $serviceNumber counter for the number of service items
 */
function aa_create_service_block($serviceName, $servicePrice, $serviceIcon = 'plus', $serviceColor = '#8e1618') {

?>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="media"><!-- SERVICE BLOCK -->
            <div class="pull-left">
			<span class="fa-stack fa-2x">
                <i class="fa fa-circle fa-stack-2x text-primary"  style="color:
                    <?php echo $serviceColor != '' ? $serviceColor : '#8e1618' ?>"></i>
                <i class="fa fa-<?php echo $serviceIcon != '' ? $serviceIcon : 'plus' ?> fa-stack-1x fa-inverse">
                </i>
			</span>
            </div>
            <div class="media-body">
                <h4 class="media-heading serviceItemName">
                    <?php echo $serviceName; ?>
                </h4>
                <p class="serviceItemPrice">
                    <?php if ( isset($servicePrice) and $servicePrice != '' ) {
                        echo '$' . $servicePrice;
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
<?php
} // end of function
?>
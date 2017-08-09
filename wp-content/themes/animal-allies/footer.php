<?php
$optionsFooterInfo = get_option('AAOptionContactInfo');
?>

</main>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <h4>Contact</h4>
                <address>
                    <a href="https://www.google.com/maps?ll=34.97185,-81.953457&z=16&t=m&hl=en-US&gl=US&mapclient=embed&cid=8767965459774264267" target="_blank">
                        <?php echo esc_html($optionsFooterInfo['AAFieldStreetAddress']);?><br>
                        <?php echo esc_html($optionsFooterInfo['AAFieldCityStateZip']);?>
                    </a>
                </address>
                <p><?php echo esc_html($optionsFooterInfo['AAFieldPhone']);?></p>
                <p><a href="mailto:<?php echo esc_attr($optionsFooterInfo['AAFieldEmail']);?>"><?php echo esc_html($optionsFooterInfo['AAFieldEmail']);?></a></p>
                <p>
                    <a href="<?php echo esc_url($optionsFooterInfo['AAFieldFacebook']);?>" target="_blank">
                        <i class="fa fa-facebook-square fa-2x"></i>
                    </a>
                </p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <!-- hours of operation -->

                    <h4>Hours of Operation</h4>
                    <p><?php echo esc_html($optionsFooterInfo['AAHoursOfOperation']);?></p>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="row">
                    <div class="col-md-12">
                    <!-- donate online -->

                        <h4 id="donateFooterHeading">Donate Online</h4>
                        <form method="post" style="margin:0;" action="https://www.paypal.com/cgi-bin/webscr">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="business" value="animalalliesclinic@yahoo.com">
                            <input type="hidden" name="item_name" value="">
                            <input type="hidden" name="return" value="">
                            <input type="hidden" name="cancel_return" value="">
                            <input type="hidden" name="image_url" value="">
                            <input type="hidden" name="bn" value="yahoo-sitebuilder">
                            <input type="hidden" name="pal" value="C3MGKKUCCAB9J">
                            <input type="hidden" name="mrb" value="R-5AJ59462NH120001H">
                            <input type="image" border="0" style="max-width:75%; max-height:75%; object-fit: contain;" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-34px.png">
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="affiliatesFlex">

                            <div id="affiliatesFlexCol2">
                                <!-- Trustwave -->

                                    <img id="trustwaveSealImage"
                                         src="https://sealserver.trustwave.com/seal_image.php?customerId=8a8b59960967430bbe94098040e7d7fe&amp;size=105x53&amp;style="
                                         alt="This site is protected by Trustwave's Trusted Commerce program"
                                         title="This site is protected by Trustwave's Trusted Commerce program"
                                         onclick="javascript:window.open('https://sealserver.trustwave.com/cert.php?customerId=8a8b59960967430bbe94098040e7d7fe&size=105x54&style=', 'c_TW', 'location=no, toolbar=no, resizable=yes, scrollbars=yes, directories=no, status=no, width=615, height=720'); return false;">
                                    <!-- iGive.com -->


                                    <img class="img-responsive img-rounded"
                                         id="iGiveImage"
                                         src="<?php echo esc_url(get_template_directory_uri()) . '/img/igive125x75.gif';?>"
                                         alt="iGive.com Logo">



                            </div>
                            <div>
                                <!-- GuideStar Gold -->
                                <a href="http://www.guidestar.org/profile/57-1098821" target="_blank">
                                    <img class="img-responsive" id="guidestar"
                                         alt="GuideStar Gold Participant"
                                         src="<?php echo esc_url(get_template_directory_uri()) . '/img/guidestar-gold2.png';?>">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>


        <div class="row copyright">
            <div class="col-md-12">
            <small class="copyright">Copyright &copy; Animal Allies 2017</small>
            </div>
        </div>
    </div> <!-- /container -->

</footer>
</div><!-- / flexbox div -->

<?php wp_footer(); ?>

</body>
</html>

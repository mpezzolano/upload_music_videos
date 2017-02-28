<div class="footer_wrapper">
    <div class="container_24">
        <div class="grid_24">
            <div class="footer_topwrapper">
                <?php
                /* A sidebar in the footer? Yep. You can can customize
                 * your footer with four columns of widgets.
                 */
                get_sidebar('footer');
                ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="container_24">
            <div class="grid_24">
                <div class="footer_bottom">
                    <div class="grid_10 alpha">
                        <div class="social_logo">
                            <ul class="fsocialicon">
                                <?php if (inkthemes_get_option('inkthemes_twitter') != '') { ?>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" class="twittericon"><a target="_blank" href="<?php echo inkthemes_get_option('inkthemes_twitter'); ?>"><span>Twitter</span></a></li>
                                    <?php
                                }
                                if (inkthemes_get_option('inkthemes_facebook') != '') {
                                    ?>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" class="facebookicon"><a target="_blank" href="<?php echo inkthemes_get_option('inkthemes_facebook'); ?>">Facebook</a></li>
                                    <?php
                                }
                                if (inkthemes_get_option('inkthemes_rss') != '') {
                                    ?>
                                    <li><img src="<?php echo get_template_directory_uri(); ?>/images/rss.png" class="newslettericon"><a target="_blank" href="<?php echo inkthemes_get_option('inkthemes_rss'); ?>">RSS Feed</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="grid_14 omega">
                        <div class="copyright">
                            <div class="copyrightinfo">
                                <div class="copyrightinfo">
                                    <?php
                                    if (inkthemes_get_option('inkthemes_footertext') != '') {
                                        echo inkthemes_get_option('inkthemes_footertext');
                                    } else {
                                        _e('VideoCraft Theme by InkThemes.com', 'videocraft');
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=403464249766594";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<?php wp_footer(); ?>
</body>
</html>

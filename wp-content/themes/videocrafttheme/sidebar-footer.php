<div class="grid_19 alpha">
    <div class="footer_top">
        <?php
        if (is_active_sidebar('first-footer-widget-area')) :
            dynamic_sidebar('first-footer-widget-area');
        else :
            inkthemes_cat_nav();
        endif;
        ?>
    </div>
</div>
<div class="grid_5 omega">
    <div class="footer_toplogo">
        <?php
        if (is_active_sidebar('second-footer-widget-area')) :
            dynamic_sidebar('second-footer-widget-area');
        else :
            ?>
            <a href="<?php echo home_url(); ?>"><img src="<?php
                if (inkthemes_get_option('inkthemes_logo') != '') {
                    echo inkthemes_get_option('inkthemes_logo');
                } else {
                    echo get_template_directory_uri() . '/images/logo.png';
                }
                ?>" alt="<?php bloginfo('name'); ?>" alt="logo"/></a>
            <?php endif; ?> 
    </div>
</div>
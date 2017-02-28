<?php
/**
 * Template Name: Dashboard
 * 
 * @package videocraft
 * since 1.0
 *  
 */
get_header();

if (is_user_logged_in()):
    ?>
    <div class="page_container">
        <div class="container_24">
            <div class="grid_24">
                <div class="page-content">
                    <div class="grid_18 alpha">
                        <div class="content-bar">
                            <div class="page-heading">
                                <h1><span class="arrow"><?php printf(__('Welcome %s - Your Listings', 'videocraft'), $current_user->user_login); ?></span></h1>		
                            </div>
                            <?php
                            //Get style
                            dashboard_style();
                            //Users listings
                            global $post;
                            if (!isset($_REQUEST['action']) && !isset($_REQUEST['action1']) || isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
                                user_listing($post->ID);
                            }
                            if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'):
                                $post_id = $_REQUEST['pid'];
                                wp_delete_post($post_id);
                            endif;
                            if (isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'edit'):
                                //Edit listing
                                $post_id = $_REQUEST['pid'];
                                edit_listing($post_id);
                            endif;
                            ?>
                        </div>
                    </div>
                    <div class="grid_6 omega">
                        <div class="sidebar dashboard">
                            <div id="author-info">            
                                <div id="author-avatar"> <?php echo get_avatar($current_user->ID, 40); ?> </div>
                                <!-- #author-avatar -->
                                <div id="author-description">
                                    <?php
                                    $user_info = get_userdata($current_user->ID);
                                    $registered = ($user_info->user_registered . "\n");
                                    ?>
                                    <h6><?php printf(__('Welcome, %s', 'videocraft'), $current_user->user_login); ?></h6>
                                    <p><?php echo MEMBER_SINCE; ?>&nbsp;<?php
                                        echo date("n/j/Y", strtotime($registered));
                                        ?></p>
                                </div>
                                <!-- #author-description	-->
                                <ul class="navigation">
                                    <li class="add-new"><a href="<?php echo home_url("/?page_id=" . get_option('upload_video')); ?>"><?php echo ADD_N_LISTING; ?></a></li>
                                    <li class="view-all"><a href="<?php echo home_url("/?page_id=" . get_option('video-listing')); ?>"><?php echo V_LISTING; ?></a></li>                
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php
else:
    wp_redirect(home_url());
endif;
?>
<?php get_footer(); ?>
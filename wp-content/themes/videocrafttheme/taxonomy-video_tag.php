<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * 
 */
get_header();
?>  
<div class="page_container">
    <div class="container_24">
        <div class="grid_24">
            <div class="page-content">
                <div class="grid_18 alpha">
                    <div class="content">
                        <div class="page-heading">
                            <h1 class="cat"><span class="arrow">
                                    <?php printf(__('Video Tag Archives: %s', 'videocraft'), '' . single_tag_title('', false) . ''); ?>
                                </span></h1>
                        </div>
                        <div class="video_cat_list">
                            <ul class="fthumbnail">
                                <?php if (have_posts()) : ?>
                                    <!-- Start the Loop. -->
                                    <?php
                                    global $cat_name;
                                    $cat_name = @ $GLOBALS['video_cat'];
                                    $limit = 2;
                                    $post_type = 'video_listing';
                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                                    $wp_query->is_archive = true;
                                    $wp_query->is_home = false;
                                    ?>
                                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                            <!--post start-->
                                            <li><div class="videobox">
                                                    <div class="video_thumb_wrapper">
                                                        <?php require ('video-front-thumb.php'); ?>
                                                        <a href="<?php the_permalink() ?>"><div class="video_play_icon"></div></a>
                                                    </div>
                                                    <span class="author"><?php
                                                        $auth = get_the_author();
                                                        echo substr($auth, 0, 14);
                                                        if (strlen($auth) > 14)
                                                            echo "...";
                                                        ?>
                                                    </span>
                                                    <span class="views"><?php echo getPostViews(get_the_ID()); ?></span>				
                                                    <h6 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>">
                                                            <?php
                                                            $tit = the_title('', '', FALSE);
                                                            echo substr($tit, 0, 50);
                                                            if (strlen($tit) > 50)
                                                                echo "...";
                                                            ?>
                                                        </a></h6> 
                                                </div> </li>		
                                            <!--End Post-->
                                            <?php
                                        endwhile;
                                    else:
                                        ?>
                                        <div class="post">
                                            <p>
                                                <?php _e('Sorry, no posts matched your criteria.', 'videocraft'); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                    <!--End Loop-->
                                    <div class="clear"></div>
                                    <?php
                                    inkthemes_pagination();
                                endif;
                                wp_reset_query();
                                // Reset Post Data
                                wp_reset_postdata();
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="grid_6 omega">
                    <!--Start Sidebar-->
                    <?php get_sidebar(); ?>
                    <!--End Sidebar-->
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>
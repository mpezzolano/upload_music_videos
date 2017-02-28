<?php
/**
 * The template for displaying Category pages.
 *
 */
get_header();
?>
<div class="content_wrapper video_cat">
    <div class="container_24">
        <div class="grid_24">
            <div class="frontpage-content">
                <div class="grid_18 alpha">
                    <div class="content category">
                        <div class="page-heading">
                            <h1 class="page-title cat"><span class="arrow"><?php printf(__('All Videos In: %s Category', 'videocraft'), '' . single_cat_title('', false) . ''); ?></span></h1>
                        </div>
                        <div class="video_cat_list">
                            <ul class="fthumbnail">
                                <?php if (have_posts()) : ?>
                                    <?php
                                    $category_description = category_description();
                                    if (!empty($category_description))
                                        echo '' . $category_description . '';
                                    /* Run the loop for the category page to output the posts.
                                     * If you want to overload this in a child theme then include a file
                                     * called loop-category.php and that will be used instead.
                                     */
                                    ?>
                                    <!-- Start the Loop. -->
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
                    <?php get_sidebar('category'); ?>
                    <!--End Sidebar-->
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>

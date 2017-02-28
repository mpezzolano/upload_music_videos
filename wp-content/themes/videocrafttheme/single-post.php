<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage videocraft
 * @since videocraft 1.0
 */
get_header();
?>  
<div class="page_container">
    <div class="container_24">
        <div class="grid_24">
            <div class="page-content">
                <div class="grid_18 alpha">
                    <div class="content-bar">
                        <div class="page-heading">
                            <h1><span class="arrow"><?php the_title(); ?></span></h1>		
                        </div>
                        <!-- Start the Loop. -->
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <!--post start-->
                                <div class="post">             
                                    <div class="post_content">
                                        <?php the_content(); ?>					
                                    </div>
                                    <ul class="post_meta">
                                        <li class="post_date">&nbsp;&nbsp;<?php echo get_the_time('M, d, Y') ?></li>
                                        <li class="posted_by">&nbsp;&nbsp;<span><?php _e('Author:&nbsp;', 'videocraft'); ?></span><?php the_author_posts_link(); ?></li>
                                        <li class="post_category">&nbsp;&nbsp;<span><?php _e('Categories:&nbsp;', 'videocraft'); ?></span><?php the_category(', '); ?></li>
                                        <li class="post_comment"><?php comments_popup_link(__('No Comments.', 'videocraft'), __('1 Comment.', 'videocraft'), __('% Comments.', 'videocraft')); ?></li>
                                    </ul>
                                    <div class="clear"></div>
                                    <?php if (has_tag()) { ?>
                                        <div class="tag">
                                            <?php the_tags(__('Post Tagged with ', ', ', '')); ?>
                                        </div>
                                    <?php } ?>
                                    <div class="clear"></div>
                                    <?php wp_link_pages(array('before' => '<div class="clear"></div><div class="page-link"><span>' . PAGES_COLON . '</span>', 'after' => '</div>')); ?>
                                </div>
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
                        <!--Start Comment box-->
                        <?php comments_template(); ?>
                        <!--End Comment box--> 
                    </div>       
                </div>
                <div class="grid_6 omega">
                    <!--Start Sidebar-->
                    <?php get_sidebar(); ?>
                    <!--End Sidebar-->
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
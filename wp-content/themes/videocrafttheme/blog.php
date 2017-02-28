<?php
/*
  Template Name: Blog Page
 */
get_header();
?>
<div class="page_container">
    <div class="container_24">
        <div class="grid_24">
            <div class="page-content">
                <div class="grid_18 alpha">
                    <div class="content-bar blog">
                        <?php
                        $limit = get_option('posts_per_page');
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        query_posts('showposts=' . $limit . '&paged=' . $paged);
                        $wp_query->is_archive = true;
                        $wp_query->is_home = false;
                        ?>
                        <!-- Start the Loop. -->
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <!--post start-->
                                <div class="post">
                                    <h1 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>"><?php the_title(); ?></a></h1>
                                    <?php
                                    echo $post->wp_thumbnail_id;
                                    ?>
                                    <div class="post_content">
                                        <?php
                                        if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
                                            inkthemes_get_thumbnail(789, 265);
                                        } else {
                                            inkthemes_get_image(789, 265);
                                        }
                                        the_excerpt();
                                        ?>
                                        <a class="more" href="<?php the_permalink() ?>"><?php _e('More &rarr;', 'videocraft'); ?></a> </div>
                                    <ul class="post_meta">
                                        <li class="post_date">&nbsp;&nbsp;<?php echo get_the_time('M, d, Y') ?></li>
                                        <li class="posted_by">&nbsp;&nbsp;<span><?php _e('Author:&nbsp;', 'videocraft'); ?></span><?php the_author_posts_link(); ?></li>
                                        <li class="post_category">&nbsp;&nbsp;<span><?php _e('Categories:&nbsp;', 'videocraft'); ?></span><?php the_category(', '); ?></li>
                                        <li class="post_comment"><?php comments_popup_link(__('No Comments.', 'videocraft'), __('1 Comment.', 'videocraft'), __('% Comments.', 'videocraft')); ?></li>
                                    </ul>
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
                        <?php
                        endif;
                        inkthemes_pagination();
                        ?>
                        <!--End Loop-->

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
<?php
/**
 * The template for displaying Search Results pages.
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
                    <div class="content search">
                        <div class="page-heading">
                            <h1 class="page-title"><span class="arrow"><?php printf(__('Search Results for: %s', 'videocraft'), '' . get_search_query() . ''); ?></span></h1>
                        </div>
                        <div class="video_cat_list">
                            <ul class="fthumbnail">
                                <?php
                                if (isset($_GET['post_type'])) {
                                    global $wpdb, $table_term, $table_post, $table_term_rel, $table_term_taxonomy;
                                    $txt = get_search_query();
                                    $table_term_taxonomy = $wpdb->prefix . "term_taxonomy";
                                    $table_term_rel = $wpdb->prefix . "term_relationships";
                                    $table_post = $wpdb->prefix . "posts";
                                    $table_term = $wpdb->prefix . "terms";
                                    $query = $wpdb->get_results("select term_id from $table_term where `name` like '%{$txt}%'");
                                    if (!empty($query)) {
                                        $arr = array();
                                        if ($query) {
                                            foreach ($query as $row) {

                                                $arr[] = $row->term_id;
                                            }
                                        }

                                        //print_r($arr2);
                                        for ($i = 0; $i <= count($arr); $i++) {
                                            $query = $wpdb->get_results("SELECT DISTINCT ID, post_author, post_content ,post_title,post_name FROM $table_post p
JOIN $table_term_rel tr
   ON (p.ID = tr.object_id AND p.post_status='publish')
JOIN $table_term_taxonomy tt
   ON ((tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy='video_cat') OR (tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy='video_tag'))
JOIN $table_term t
   ON (t.term_id = tt.term_id AND t.term_id = '" . $arr[$i] . "')
");

                                            foreach ($query as $rows) {
                                                $new_id[] = $rows->ID;
                                                //echo $rows->post_title;
                                                //echo "</br>".$rows->post_content;
                                            }
                                        }
                                    }
                                    $query = $wpdb->get_results("select ID from $table_post where (`post_title` like '%{$txt}%' OR `post_content` like '%{$txt}%' OR `post_name` like '%{$txt}%') AND `post_type`='video_listing' AND `post_status`='publish'");
                                    if (!empty($query)) {
                                        if ($query) {
                                            foreach ($query as $row) {

                                                $new_id[] = $row->ID;
                                            }
                                        }
                                        if ($new_id)
                                            $uni_arr = array_unique($new_id);
                                        if ($uni_arr) {
                                            for ($j = 0; $j < count($uni_arr); $j++) {
                                                $query = $wpdb->get_results("SELECT DISTINCT ID, post_author, post_content ,post_title,post_name FROM $table_post p
where ID=" . $uni_arr[$j] . "");

                                                foreach ($query as $rows) {
                                                    ?>
                                                    <li><div class="videobox" >
                                                            <div class="video_thumb_wrapper">
                                                                <?php require ('video-front-thumb-search.php'); ?>
                                                                <a href="<?php echo get_permalink($rows->ID); ?>"><div class="video_play_icon"></div></a>
                                                            </div>
                                                            <h6 class="title"><a href="<?php echo get_permalink($rows->ID); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), $rows->post_title); ?>">
                                                                    <?php
                                                                    //$tit = the_title('', '', FALSE);
                                                                    $tit = $rows->post_title;
                                                                    echo substr($tit, 0, 50);
                                                                    if (strlen($tit) > 50)
                                                                        echo "...";
                                                                    ?>
                                                                </a></h6>
                                                            <span class="author"><?php
                                                                $user = get_userdata($rows->post_author);
                                                                $auth = $user->user_login;
                                                                echo substr($auth, 0, 14);
                                                                if (strlen($auth) > 14)
                                                                    echo "...";
                                                                ?>
                                                            </span>
                                                            <span class="views"><?php echo getPostViews($rows->ID); ?></span>                 

                                                        </div> </li>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    else {
                                        ?>
                                        <article id="post-0" class="post no-results not-found">
                                            <header class="entry-header">
                                                <h1 class="entry-title">
                                                    <?php _e('Nothing Found', 'videocraft'); ?>
                                                </h1>
                                            </header>
                                            <!-- .entry-header -->
                                            <div class="entry-content">
                                                <p>
                                                    <?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'videocraft'); ?>
                                                </p>
                                                <?php video_search_form(); ?>
                                            </div>
                                            <!-- .entry-content -->
                                        </article>
                                        <?php
                                    }
                                } else {
                                    if (have_posts()) : while (have_posts()) : the_post();
                                            ?>               
                                            <!--Start Post-->
                                            <li><div class="videobox" >
                                                    <div class="video_thumb_wrapper">
                                                        <?php require ('video-front-thumb.php'); ?>
                                                        <a href="<?php the_permalink() ?>"><div class="video_play_icon"></div></a>
                                                    </div>

                                                    <h6 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>">
                                                            <?php
                                                            $tit = the_title('', '', FALSE);
                                                            echo substr($tit, 0, 50);
                                                            if (strlen($tit) > 50)
                                                                echo "...";
                                                            ?>
                                                        </a></h6>	
                                                    <span class="author"><?php
                                                        $auth = get_the_author();
                                                        echo substr($auth, 0, 14);
                                                        if (strlen($auth) > 14)
                                                            echo "...";
                                                        ?>
                                                    </span>
                                                    <span class="views"><?php echo getPostViews(get_the_ID()); ?></span>   
                                                </div> </li>
                                            <!--End Post-->
                                            <?php
                                        endwhile;
                                    else:
                                        ?>
                                        <article id="post-0" class="post no-results not-found">
                                            <header class="entry-header">
                                                <h1 class="entry-title">
                                                    <?php _e('Nothing Found', 'videocraft'); ?>
                                                </h1>
                                            </header>
                                            <!-- .entry-header -->
                                            <div class="entry-content">
                                                <p>
                                                    <?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'videocraft'); ?>
                                                </p>
                                                <?php get_search_form(); ?>
                                            </div>
                                            <!-- .entry-content -->
                                        </article>
                                    <?php
                                    endif;
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="clear"></div>
                        <nav id="nav-single"> <span class="nav-previous">
                                <?php next_posts_link(__('&larr; Older posts', 'videocraft')); ?>
                            </span> <span class="nav-next">
                                <?php previous_posts_link(__('Newer posts &rarr;', 'videocraft')); ?>
                            </span> </nav>	
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
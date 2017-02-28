<?php
/**
 * The template for displaying front page pages.
 *
 */
get_header();
?>

<div class="video_wrapper front">
    <div class="container_24">
        <div class="grid_24">
            <div class="grid_15 alpha ipad">
                <?php
                $args = array('post_type' => 'video_listing',
                    'meta_key' => 'featured_video',
                    'meta_value' => 'on',
                    'posts_per_page' => 1
                );
                $loop = new WP_Query($args);
                $count = 0;
                while ($loop->have_posts()) :$loop->the_post();
                    ?>
                    <h1 class="post_title home"><?php the_title(); ?></h1>
                    <div class="video_container">
                        <div class="video_player_container">
                            <div class="video_player">                            
                                <?php
                                global $post;
                                $im_data = inkthemes_im_lock();
                                if (isset($im_data['im_exist']) && $im_data['im_exist']) {
                                    echo $im_data['im_content'];
                                    $upload_video = false;
                                    $meta_video_url = null;
                                } else {
                                    if (isset($im_data['_meta_video']) && $im_data['_meta_video'] != '') {
                                        $upload_video = $im_data['_meta_video'];
                                    } else {
                                        $upload_video = false;
                                    }
                                    if (isset($im_data['_video_url']) && $im_data['_video_url'] != '') {
                                        $meta_video_url = $im_data['_video_url'];
                                    } else {
                                        $meta_video_url = null;
                                    }
                                }
//                                $meta_video_url = get_post_meta($post->ID, '_video_url', true);
                                echo $meta_video_url;
                                if (!empty($meta_video_url)) {
                                    $parts = parse_url($meta_video_url);
                                    $host = $parts['host'];
                                    if (empty($host)) {
                                        echo 'Unrecognized host';
                                    } else {
                                        $urll = $meta_video_url;
                                        if (strpos($urll, "dailymotion.com")) {
                                            $dailyid = strtok(basename($urll), '_');
                                            ?>
                                            <iframe src="http://www.dailymotion.com/embed/video/<?php echo $dailyid; ?>" type="application/x-shockwave-flash" width="705" height="400" allowfullscreen="true"></iframe>
                                            <?php
                                        }
                                        if (strpos($urll, "metacafe.com")) {
                                            if (preg_match("/((http:\/\/)?(www\.)?metacafe\.com)(\/watch\/)(\d+)(.*)/i", $urll, $match)) {
                                                $metaid = $match[5];
                                                ?>
                                                <embed src="http://www.metacafe.com/fplayer/<?php echo $metaid; ?>/meta.swf" width="705" height="400" allowfullscreen="true" wmode="transparent"  pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
                                                <?php
                                            }
                                        }
                                        if (strpos($urll, "vimeo.com")) {
                                            $video_id = explode('vimeo.com/', $urll);
                                            $video_id = $video_id[1];
                                            ?>
                                            <iframe src="http://player.vimeo.com/video/<?php echo $video_id; ?>"  frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen="true" allowscriptaccess="always" width="705" height="400"></iframe>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (strpos($urll, "youtube.com")) {
//youtube coding....
                                            $html = "<a href=" . $urll . "</a></p>";
                                            $regex = "/v\=([\-\w]+)/";
                                            preg_match_all($regex, $html, $out);
                                            $out[1] = array_unique($out[1]);
                                            foreach ($out[1] as $youtube) {
                                                $youtube;
                                            }
                                            ?>
                                            <iframe title="YouTube video" src="https://www.youtube.com/embed/<?php echo $youtube; ?>" frameborder="0" allowfullscreen></iframe> 
                                            <?php
//                                            $thumbyou = $video['thumb_1'];  //youtube 
//                                            echo "<a href=\"\"><img src=\"$thumbyou\" alt=\"\" /></a>";
                                        }
                                    }
                                }
                                //  Uploaded Video
//                                $upload_video = get_post_meta($post->ID, '_meta_video', true);
                                $upload_image = get_post_meta($post->ID, '_meta_image', true);
                                if ($upload_video) {
                                    $imageurl = $upload_image;
                                    $videourl = $upload_video;
                                    ?>
                                    <div id="container<?php echo $count; ?>"><?php _e('Loading the player ...', 'videocraft'); ?></div>
                                    </br>
                                    <script type="text/javascript">
                                        jwplayer("container<?php echo $count; ?>").setup({
                                            width: "100%",
                                            aspectratio: "16:9",
                                            image: "<?php echo $imageurl ?>",
                                            levels: [
                                                {file: "<?php echo $videourl ?>"}, // H.264 version
                                                {file: "<?php echo $videourl ?>"}, // WebM version
                                                {file: "<?php echo $videourl ?>"} // Ogg Theroa version
                                            ]
                                        });
                                    </script>      
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $count++;
                endwhile;
                wp_reset_postdata();
                wp_reset_query();
                ?>
            </div>
            <div class="grid_9 omega ipad">
                <div class="popular_videos">
                    <div class="tabs">
                        <div class="tab_menu_container home">
                            <ul id="tab_menu">
                                <li><a class="current" rel="tab_sidebar_popular"><?php _e('Recommend', 'videocraft'); ?></a></li>
                                <li><a class="" rel="tab_sidebar_recent"><?php _e('Popular', 'videocraft'); ?></a></li>
                                <li><a class="" rel="tab_sidebar_more"><?php _e('Recent', 'videocraft'); ?></a></li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                        <div class="tab_container">
                            <div class="tab_container_in">
                                <!-- Popular Videos -->
                                <div style="display: none;" id="tab_sidebar_popular" class="tab_sidebar_list">
                                    <ul class="videolist1" id="scroll">
                                        <?php
                                        $args = array(
                                            'post_type' => 'video_listing',
                                            'meta_key' => 'featured_video',
                                            'meta_value' => 'on',
                                            'orderby' => 'date',
                                            'order' => 'DESC',
                                            'posts_per_page' => 4
                                        );
                                        $loop = new WP_Query($args);
                                        ?>
                                        <?php
                                        while ($loop->have_posts()) :$loop->the_post();
                                            $vid = get_post_meta($post->ID, '_video_url', true);
                                            ?>
                                            <li>
                                                <?php require ('video-thumb.php'); ?>
                                                <div class="featured-post-desc">
                                                    <h6 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>">
                                                            <?php
                                                            $tit = the_title('', '', FALSE);
                                                            echo substr($tit, 0, 50);
                                                            if (strlen($tit) > 50)
                                                                echo "__";
                                                            ?>
                                                        </a></h6>
                                                    <?php echo get_the_time('M d, Y') ?>
                                                </div>
                                            </li>
                                            <div class="clear"></div>
                                            <?php
                                        endwhile;
                                        /**
                                         * Reset Post Data
                                         */
                                        wp_reset_postdata();
                                        wp_reset_query();
                                        ?>  				
                                    </ul>
                                </div>
                                <!-- END -->
                                <!-- Recent Videos -->
                                <div style="display:none" id="tab_sidebar_recent" class="tab_sidebar_list">
                                    <ul class="videolist2" id="scroll1">
                                        <?php
                                        $args = array('post_type' => 'video_listing', 'orderby' => 'comment_count', 'posts_per_page' => 4,);
                                        $loop = new WP_Query($args);
                                        while ($loop->have_posts()) :$loop->the_post();
                                            $vid = get_post_meta($post->ID, '_video_url', true);
                                            ?>
                                            <li>
                                                <?php require ('video-thumb.php'); ?>
                                                <div class="featured-post-desc">
                                                    <h6 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>">
                                                            <?php
                                                            $tit = the_title('', '', FALSE);
                                                            echo substr($tit, 0, 50);
                                                            if (strlen($tit) > 50)
                                                                echo "__";
                                                            ?>
                                                        </a></h6>
                                                    <?php echo get_the_time('M d, Y') ?>
                                                </div>
                                            </li>
                                            <div class="clear"></div>
                                            <?php
                                        endwhile;
// Reset Post Data
                                        wp_reset_postdata();
                                        wp_reset_query();
                                        ?>
                                    </ul>
                                </div>
                                <!-- END -->
                                <!-- More Video -->
                                <div style="display: none;" id="tab_sidebar_more" class="tab_sidebar_list">
                                    <ul class="videolist3" id="scroll2">
                                        <?php
                                        // The Query
                                        $args = array('post_type' => 'video_listing', 'posts_per_page' => 4,);
                                        $loop = new WP_Query($args);
                                        while ($loop->have_posts()) :$loop->the_post();
                                            ?>
                                            <li>
                                                <?php require ('video-thumb.php'); ?>
                                                <div class="featured-post-desc">
                                                    <h6 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>">
                                                            <?php
                                                            $tit = the_title('', '', FALSE);
                                                            echo substr($tit, 0, 50);
                                                            if (strlen($tit) > 50)
                                                                echo "__";
                                                            ?>
                                                        </a></h6>
                                                    <?php echo get_the_time('M d, Y') ?>
                                                </div>
                                            </li>
                                            <div class="clear"></div>
                                            <?php
                                        endwhile;
// Reset Post Data
                                        wp_reset_postdata();
                                        wp_reset_query();
                                        ?>	 
                                    </ul>
                                </div>
                                <!-- END -->
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="content_wrapper_shaddow home">
    <div class="container_24">
        <div class="grid_24">
            <div class="frontpage-content_shaddow">
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="content_wrapper">
    <div class="container_24">
        <div class="grid_24">
            <div class="frontpage-content">
                <div class="grid_18 alpha">
                    <div class="content home">
                        <?php
                        $options = inkthemes_get_option('of_template');
                        foreach ($options as $option) {
                            $option_type = $option['type'];
                            if ($option_type == 'multicheck') {
                                foreach ($option['options'] as $key => $option1) {
                                    if ($key == '' || $key == NULL) {
                                        
                                    } else {
                                        $of_key = $option['id'] . '_' . $key;
                                        $saved_std = inkthemes_get_option($of_key);
                                        if ($saved_std == 'true') {
                                            $window[] = $key;
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($window)) {
                            $args = array(
                                'orderby' => 'id',
                                'order' => 'ASC',
                                'include' => $window,
                                'number' => '10'
                            );
                            global $wpdb, $current_user;
                            $terms = get_terms('video_cat', $args);
                            $count = count($terms);
                            if ($count > 0) {
                                $i = 0;
                                foreach ($terms as $term) {
                                    $cat_id = $term->term_id;
                                    if (++$i == 12)
                                        break;
                                    ?>

                                    <div class="video_cat_list">
                                        <!-- start videopost-->
                                        <?php echo '<h1 class="title"><span class="arrow"><a href="' . get_term_link($term->slug, 'video_cat') . '">' . $term->name . '</a></span></h1>'; ?>
                                        <ul class="fthumbnail">
                                            <?php
                                            // The Query
                                            query_posts(array('posts_per_page' => 3, 'post_type' => 'video_listing', 'video_cat' => "$term->name"));
                                            while (have_posts()) :the_post();
                                                ?>
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
                                                <?php
                                            endwhile;
                                            // Reset Post Data
                                            wp_reset_postdata();
                                            wp_reset_query();
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                            }
                            else {
                                _e("There Are No Video In Any Category", 'videocraft');
                            }
                        } else {
                            $args = array(
                                'orderby' => 'id',
                                'order' => 'ASC',
                                'number' => '10',
                                'hierarchical' => false,
                            );

                            global $wpdb, $current_user;
                            $terms = get_terms("video_cat");
                            $count = count($terms);
                            if ($count > 0) {
                                $i = 0;
                                foreach ($terms as $term) {
                                    $cat_id = $term->term_id;
                                    if (++$i == 12)
                                        break;
                                    ?>
                                    <div class="video_cat_list">
                                        <!-- start videopost-->
                                        <?php echo '<h1 class="title"><span class="arrow"><a href="' . get_term_link($term->slug, 'video_cat') . '">' . $term->name . '</a></span></h1>'; ?>
                                        <ul class="fthumbnail">
                                            <?php
                                            // The Query
                                            query_posts(array('posts_per_page' => 3, 'post_type' => 'video_listing', 'video_cat' => "$term->name"));
                                            while (have_posts()) :the_post();
                                                ?>
                                                <li><span class="videobox">
                                                        <div class="video_thumb_wrapper">
                                                            <?php require ('video-front-thumb.php'); ?>
                                                            <a href="<?php the_permalink() ?>"><div class="video_play_icon"></div></a>
                                                        </div>
                                                        <div class="clear"></div>
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
                                                    </span> </li>
                                                <?php
                                            endwhile;
                                            // Reset Post Data
                                            wp_reset_postdata();
                                            wp_reset_query();
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                            }
                            else {
                                _e("There Are No Video In Any Category", 'videocraft');
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="grid_6 omega sidebar_seven_grid">
                    <!--Start Sidebar-->
                    <?php get_sidebar('home'); ?>
                    <!--End Sidebar-->
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php get_footer(); ?>

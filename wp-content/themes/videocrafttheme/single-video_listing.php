<?php
get_header();
global $wpdb;
?>  
<div class="video_wrapper">
    <div class="container_24">
        <div class="grid_24">
            <div class="grid_15 alpha">
                <div class="video_container">
                    <div class="video_player_container">
                        <div class="video_player">
                            <?php
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
//                                        $thumbyou = $video['thumb_1'];  //youtube 
//                                        echo "<a href=\"\"><img src=\"$thumbyou\" alt=\"\" /></a>";
                                    }
                                }
                            }
                            //  Uploaded Video
                            $upload_image = get_post_meta($post->ID, '_meta_image', true);
                            $count = isset($count) ? $count : 0;
                            if ($upload_video) {
                                $imageurl = $upload_image;
                                $videourl = $upload_video;
                                ?>		
                                <div id="container<?php echo $count; ?>">Loading the player ... </div></br>	  	
                                <script type="text/javascript">
                                    jwplayer("container<?php echo $count; ?>").setup({
                                        //flashplayer: "<?php echo get_template_directory_uri() . '/js/player.swf' ?>",
                                        width: "100%",
                                        aspectratio: "16:9",
                                        logo: {
                                            hide: true
                                        },
                                        image: "<?php echo $imageurl ?>",
                                        levels: [
                                            {file: "<?php echo $videourl ?>"}, // H.264 version
                                            {file: "<?php echo $videourl ?>"}, // WebM version
                                            {file: "<?php echo $videourl ?>"} // Ogg Theroa version
                                        ]
                                    });
                                </script>
                                <?php
                                $count++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                while (have_posts()) :the_post();
                endwhile;
                wp_reset_query();
// Reset Post Data
                ?> 	
                <div class="video_post">
                    <h1 class="post_title"><?php the_title(); ?></h1>
                    <?php
                    $up_path = get_template_directory_uri() . "/images/thumbs-up.png";
                    $down_path = get_template_directory_uri() . "/images/thumbs-down.png";
                    ?>
                    <div class="video_count">
                        <div class="video_counts video_count_like">
                            <img id="video_thumbsup" src="<?php echo $up_path; ?>" height="20px" width="20px" data_postid="<?php echo $post->ID; ?>"/>
                            <div id="video_up_count"><?php
                                if (!get_post_meta($post->ID, 'likes', true))
                                    echo 0;
                                else
                                    echo get_post_meta($post->ID, 'likes', true);
                                ?></div>
                        </div>
                        <div class="video_counts video_count_dislike">
                            <img id="video_thumbsdown" src="<?php echo $down_path; ?>" height="20px" width="20px" data_postid="<?php echo $post->ID; ?>"/>
                            <div id="video_down_count"><?php
                                if (!get_post_meta($post->ID, 'dislikes', true))
                                    echo 0;
                                else
                                    echo get_post_meta($post->ID, 'dislikes', true);
                                ?></div>
                        </div>
                    </div>
                    <ul class="video_post_meta">
                        <li class="post_date"><?php echo get_the_time('M, d, Y') ?></li>
                        <li class="posted_by"><span></span>
                            <?php the_author_posts_link(); ?>
                        </li>           
                        <li class="post_like">			
                        </li>
                        <li class="post_category"><span></span>
                            <?php echo get_the_term_list($post->ID, 'video_cat', '', ', ', ''); ?></li>
                        <li class="post_meta_views"><?php setPostViews(get_the_ID()); ?>
                            <?php echo getPostViews(get_the_ID()); ?></li>
                    </ul>		  		
                </div>
            </div>
            <div class="grid_9 omega">
                <div class="popular_videos single_video">
                    <div class="tabs">
                        <div class="tab_menu_container">
                            <ul id="tab_menu">
                                <li><a class="current" rel="tab_sidebar_popular"><?php _e('Related', 'videocraft'); ?></a></li>
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
                                        global $post;
                                        $vid_tax = get_the_terms($post->ID, 'video_cat');
                                        if ($vid_tax == '') {
                                            $vid_tax = 'none';
                                            $args = array('post_type' => 'video_listing', 'post__not_in' => array($post->ID), 'ignore_sticky_posts ' => 1, 'orderby' => 'rand', 'showposts' => 4, 'video_cat' => "$vid_tax");
                                        } else {
                                            foreach ($vid_tax as $tex_name) {
                                                $tax_name = $tex_name->name;
                                                $args = array('post_type' => 'video_listing', 'post__not_in' => array($post->ID), 'ignore_sticky_posts ' => 1, 'orderby' => 'rand', 'showposts' => 50, 'video_cat' => "$tax_name");
                                            }
                                        }
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
                                                            echo substr($tit, 0, 45);
                                                            if (strlen($tit) > 45)
                                                                echo "...";
                                                            ?>
                                                        </a></h6>
                                                    by <?php
                                                    $auth = get_the_author();
                                                    echo substr($auth, 0, 14);
                                                    if (strlen($auth) > 14)
                                                        echo "...";
                                                    ?>
                                                </div>
                                            </li>
                                            <div class="clear"></div>
                                            <?php
                                        endwhile;
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
                                                            echo substr($tit, 0, 45);
                                                            if (strlen($tit) > 45)
                                                                echo "...";
                                                            ?>
                                                        </a></h6>
                                                    by <?php
                                                    $auth = get_the_author();
                                                    echo substr($auth, 0, 14);
                                                    if (strlen($auth) > 14)
                                                        echo "...";
                                                    ?>
                                                </div>
                                            </li>
                                            <div class="clear"></div>
                                            <?php
                                        endwhile;
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
                                            global $cat_name;
                                            $cat_name = @ $GLOBALS['video_cat'];
                                            echo $cat_name;
                                            ?>
                                            <li>
                                                <?php require ('video-thumb.php'); ?>
                                                <div class="featured-post-desc">
                                                    <h6 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'videocraft'), get_the_title()); ?>">
                                                            <?php
                                                            $tit = the_title('', '', FALSE);
                                                            echo substr($tit, 0, 45);
                                                            if (strlen($tit) > 45)
                                                                echo "...";
                                                            ?>
                                                        </a></h6>
                                                    by <?php
                                                    $auth = get_the_author();
                                                    echo substr($auth, 0, 14);
                                                    if (strlen($auth) > 14)
                                                        echo "...";
                                                    ?>
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
                        <?php wp_link_pages(array('before' => '<div class="clear"></div><div class="page-link"><span>' . PAGES_COLON . '</span>', 'after' => '</div>')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="content_wrapper_shaddow">
    <div class="container_24">
        <div class="grid_24">
            <div class="single-content_shaddow">
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="page_container single">
    <div class="container_24">
        <div class="grid_24">
            <div class="page-content">
                <div class="grid_17 alpha">
                    <div class="content-bar single_video_page">
                        <!-- Start the Loop. -->
                        <?php
                        global $post;
                        $user_id = $wpdb->get_row("SELECT post_author FROM $wpdb->posts WHERE ID = $post->ID");
                        $user_id_value = $user_id->post_author;
                        $post_user_info = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = $user_id_value");

                        if (have_posts()) : while (have_posts()) : the_post();
                                ?>
                                <!--post start-->
                                <div class="post">   
                                    <?php if (inkthemes_get_option('inkthemes_page_banner') != '') { ?>
                                        <div class="single_page_banner"> 
                                            <p><?php echo stripslashes(inkthemes_get_option('inkthemes_page_banner')); ?></p>
                                        </div>
                                    <?php } ?>
                                    <div class="clear"></div>  
                                    <div class="post_content video_listing">
                                        <?php the_content('<p class="serif">' . __('Read the rest of this page', 'videocraft') . ' »</p>'); ?>
                                    </div>                                    
                                    <div class="single_page_ratting">
                                        <span>Rating </span>
                                        <?php
                                        $post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where rating_postid=\"$post->ID\"");
                                        echo videocraft_display_rating_star($post_rating);
                                        ?>
                                    </div>
                                    <?php if (has_video_tag(null)) { ?>
                                        <div class="video_tag">
                                            <?php echo '<span class="tag_class">Tags </span>' . get_the_term_list($post->ID, 'video_tag', '', ' ', ''); ?>
                                        </div>
                                    <?php } ?> 
                                    <div class="post_like">
                                        <div class="post-social-link">
                                            <div class="post-social-link-inner">
                                                <ul class="social-buttons cf">
                                                    <li><a href="http://twitter.com/share" class="socialite twitter-share" data-text="<?php the_title_attribute(); ?>" data-url="<?php the_permalink(); ?>" data-count="vertical" rel="nofollow" target="_blank"><span class="vhidden">Share on Twitter</span></a></li>
                                                    <li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="socialite googleplus-one" data-size="tall" data-href="<?php the_permalink(); ?>" rel="nofollow" target="_blank"><span class="vhidden">Share on Google+</span></a></li>
                                                    <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title_attribute(); ?>" class="socialite facebook-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank"><span class="vhidden">Share on Facebook</span></a></li>
                                                    <li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute(); ?>" class="socialite linkedin-share" data-url="<?php the_permalink(); ?>" data-counter="top" rel="nofollow" target="_blank"><span class="vhidden">Share on LinkedIn</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>                                     
                                </div>
                                <!--End Post-->
                                <?php
                            endwhile;
                            wp_reset_query();
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
                <div class="grid_7 omega sidebar_seven_grid">
                    <!--Start Sidebar-->
                    <?php get_sidebar('single-video_listing'); ?>
                    <!--End Sidebar-->
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('img#video_thumbsup').click(function () {
            var post_id = jQuery(this).attr('data_postid');
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
            var data = {action: "video_views", "id": post_id, "cond": "up"};
            jQuery.post(ajax_url, data, function (val) {
                if (val) {
                    jQuery('#video_up_count').html(val);
                }
            });
        });

        jQuery('img#video_thumbsdown').click(function () {
            var post_id = jQuery(this).attr('data_postid');
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
            var data = {action: "video_views", "id": post_id, "cond": "down"};
            jQuery.post(ajax_url, data, function (val) {
                if (val) {
                    jQuery('#video_down_count').html(val);
                }
            });
        });
    });
</script>  
<?php
get_footer();
?>
<?php

class videocraft_Install {

    function __construct() {
        global $pagenow;
        if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php') {
            $this->userid = get_current_user_id();
            $this->create_page();
            $this->videocraft_default_widgets();
            if (!get_option('videocraft_view_count')) {
                $this->videocraft_craete_view_count();
            }
        }
    }

    function create_page() {
        //reset options
        //delete_option('upload_video');
        //delete_option('contact');
        //delete_option('blog');
        //delete_option('video-listing');   
        //delete_option('Dashboard'); 
        /**
         * Create featured Video page
         */
        $pages = get_option('video-listing');
        if (empty($pages)) {
            $my_page = array(
                'ID' => false,
                'post_type' => 'page',
                'post_name' => __('Video Listing', 'videocraft'),
                'ping_status' => 'closed',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'post_author' => $this->userid,
                'post_title' => __('Video', 'videocraft'),
                'post_excerpt' => ''
            );
            $pagesid = wp_insert_post($my_page);
            if ($pagesid)
                update_option('video-listing', $pagesid);
            update_post_meta($pagesid, '_wp_page_template', 'template-video-listing.php');
        }
        /**
         * Create featured Blog page
         */
        $pages = get_option('blog');
        if (empty($pages)) {
            $my_page = array(
                'ID' => false,
                'post_type' => 'page',
                'post_name' => __('Blog Page', 'videocraft'),
                'ping_status' => 'closed',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'post_author' => $this->userid,
                'post_title' => __('Blog', 'videocraft'),
                'post_excerpt' => ''
            );
            $pagesid = wp_insert_post($my_page);
            if ($pagesid)
                update_option('blog', $pagesid);
            update_post_meta($pagesid, '_wp_page_template', 'blog.php');
        }
        /**
         * Create featured Contact page
         */
        $pages = get_option('contact');
        if (empty($pages)) {
            $my_page = array(
                'ID' => false,
                'post_type' => 'page',
                'post_name' => __('Contact Page', 'videocraft'),
                'ping_status' => 'closed',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'post_author' => $this->userid,
                'post_title' => __('Contact', 'videocraft'),
                'post_excerpt' => ''
            );
            $pagesid = wp_insert_post($my_page);
            if ($pagesid)
                update_option('contact', $pagesid);
            update_post_meta($pagesid, '_wp_page_template', 'template-contact.php');
        }
        /**
         * Create featured listing page
         */
        $pages = get_option('upload_video');
        if (empty($pages)) {
            $my_page = array(
                'ID' => false,
                'post_type' => 'page',
                'post_name' => __('Submit Video', 'videocraft'),
                'ping_status' => 'closed',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'post_author' => $this->userid,
                'post_title' => __('Video Upload', 'videocraft'),
                'post_excerpt' => ''
            );
            $pagesid = wp_insert_post($my_page);
            if ($pagesid)
                update_option('upload_video', $pagesid);
            update_post_meta($pagesid, '_wp_page_template', 'tpl_video_upload.php');
        }
        /**
         * Create featured listing page
         */
        $pages = get_option('Dashboard');
        if (empty($pages)) {
            $my_page = array(
                'ID' => false,
                'post_type' => 'page',
                'post_name' => __('Dashboard', 'videocraft'),
                'ping_status' => 'closed',
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'post_author' => $this->userid,
                'post_title' => __('Dashboard', 'videocraft'),
                'post_excerpt' => ''
            );
            $pagesid = wp_insert_post($my_page);
            if ($pagesid)
                update_option('Dashboard', $pagesid);
            update_post_meta($pagesid, '_wp_page_template', 'tpl_dashboard.php');
        }
        //check the membership box to enable wordpress registration
        if (get_option('users_can_register') == 0)
            update_option('users_can_register', 1);
    }

    /**
     * Activate and set 
     * Default widgets 
     */
    function videocraft_default_widgets() {
        $widget_recent_post = array();
        $widget_recent_post[1] = array(
            "title" => 'Recent Listing',
            "sort_by" => 'date',
            "show_type" => 'listing',
            "number" => '5',
            "excerpt_length" => '20',
        );
        $widget_recent_post['_multiwidget'] = '1';
        update_option('widget_advanced-recent-posts', $widget_recent_post);
        $widget_recent_post = get_option('widget_advanced-recent-posts');
        krsort($widget_recent_post);
        foreach ($widget_recent_post as $key1 => $val1) {
            $widget_recent_post_key = $key1;
            if (is_int($widget_recent_post_key)) {
                break;
            }
        }

        $widget_recent_review = array();
        $widget_recent_review[1] = array(
            "title" => 'Recent Reviews',
            "number" => '5',
        );
        $widget_recent_review['_multiwidget'] = '1';
        update_option('widget_recent-review', $widget_recent_review);
        $widget_recent_review = get_option('widget_recent-review');
        krsort($widget_recent_review);
        foreach ($widget_recent_review as $key2 => $val1) {
            $widget_recent_review_key = $key2;
            if (is_int($widget_recent_review_key)) {
                break;
            }
        }

        $widget_listing_category = array();
        $widget_listing_category[1] = array(
            "title" => 'Categories',
        );
        $widget_listing_category['_multiwidget'] = '1';
        update_option('widget_custom-categories', $widget_listing_category);
        $widget_listing_category = get_option('widget_custom-categories');
        krsort($widget_listing_category);
        foreach ($widget_listing_category as $key3 => $val1) {
            $widget_listing_category_key = $key3;
            if (is_int($widget_listing_category_key)) {
                break;
            }
        }

        $sidebars_widgets["home-widget-area"] = array("custom-categories-$widget_listing_category_key", "advanced-recent-posts-$widget_recent_post_key", "recent-review-$widget_recent_review_key");
        $sidebars_widgets["listing-widget-area"] = array("custom-categories-$widget_listing_category_key", "advanced-recent-posts-$widget_recent_post_key", "recent-review-$widget_recent_review_key");
        $sidebars_widgets["contact-widget-area"] = array("custom-categories-$widget_listing_category_key", "advanced-recent-posts-$widget_recent_post_key", "recent-review-$widget_recent_review_key");
        $sidebars_widgets["blog-widget-area"] = array(0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2', 3 => 'archives-2', 4 => 'categories-2', 5 => 'meta-2',);
        $sidebars_widgets["pages-widget-area"] = array(0 => 'search-2', 1 => 'recent-posts-2', 2 => 'recent-comments-2', 3 => 'archives-2', 4 => 'categories-2', 5 => 'meta-2',);
        update_option('sidebars_widgets', $sidebars_widgets);  //save widget iformations
    }

    /**
     * Crate view count table
     * @global type $wpdb
     * @global string $table_name
     */
    function videocraft_craete_view_count() {
        global $wpdb, $table_name;
        $table_name = $wpdb->prefix . "video_views_count";
        $structure1 = "CREATE TABLE IF NOT EXISTS $table_name (
	   id INT PRIMARY KEY AUTO_INCREMENT, 
	   post_id_video INT(11) NOT NULL, 
	   ip_address_video varchar(255) NOT NULL, 
	   date_video DATETIME 
       );";
        $wpdb->query($structure1);
        update_option('videocraft_view_count', true);
    }

}

//end class
new videocraft_Install();
?>

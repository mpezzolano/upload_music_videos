<?php

include_once get_template_directory() . '/functions/inkthemes-functions.php';
$functions_path = get_template_directory() . '/functions/';
/* These files build out the options interface.  Likely won't need to edit these. */
require_once ($functions_path . 'admin-functions.php');  // Custom functions and plugins
require_once ($functions_path . 'admin-interface.php');
// Admin Interfaces (options,framework, seo)
/* These files build out the theme specific options and associated functions. */
require_once ($functions_path . 'theme-options.php');   // Options panel settings and custom settings
require_once ($functions_path . 'shortcodes.php');
require_once ($functions_path . 'dynamic-image.php');
require_once ($functions_path . 'install.php');
require_once ($functions_path . 'define_string.php');
require_once ($functions_path . '/rating/post_rating.php');
require_once ($functions_path . '/rating/module_functions.php');
require_once ($functions_path . '/custom_post_type/post_type.php');
require_once ($functions_path . '/custom_post_type/video_metabox.php');
require_once ($functions_path . '/registration_panel/custom_function.php');
require_once ($functions_path . '/registration_panel/login.php');
require_once ($functions_path . '/registration_panel/registration.php');
require_once ($functions_path . '/widget/category_widget.php');
require_once ($functions_path . '/widget/video_search_form.php');
require_once ($functions_path . '/widget/google_map.php');
require_once ($functions_path . '/dashboard/dashboard_functions.php');
//require_once ($functions_path . 'plugin-activation.php');
//require_once ($functions_path . 'inkthemes-plugin.php');
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// Theme slug define
define('THEME_SLUG', 'videocraft');
/* ----------------------------------------------------------------------------------- */
/* Styles Enqueue */
/* ----------------------------------------------------------------------------------- */

function inkthemes_add_stylesheet() {
    if (!is_admin()) {
        if (inkthemes_get_option('inkthemes_altstylesheet') == 'black') {
            wp_enqueue_style('coloroptions', get_template_directory_uri() . "/css/color/" . inkthemes_get_option('inkthemes_altstylesheet') . ".css", '', '', 'all');
        }
        wp_enqueue_style('shortcodes', get_template_directory_uri() . "/css/shortcode.css", '', '', 'all');
        wp_enqueue_style('Registration_CSS', get_template_directory_uri() . "/functions/css/registration.css", '', '', 'all');
    }
}

add_action('init', 'inkthemes_add_stylesheet');
/* ----------------------------------------------------------------------------------- */
/* jQuery Enqueue */
/* ----------------------------------------------------------------------------------- */

function inkthemes_wp_enqueue_scripts() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('inkthemes-ddsmoothmenu', get_template_directory_uri() . '/js/ddsmoothmenu.js', array('jquery'));
        wp_enqueue_script('inkthemes-tabs', get_template_directory_uri() . '/js/tabs.js', array('jquery'));
        wp_enqueue_script('inkthemes-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'));
        wp_enqueue_script('inkthemes-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('inkthemes-socialite', get_template_directory_uri() . '/js/socialite.js', array('jquery'));
        wp_enqueue_script('inkthemes-jwplayer', get_template_directory_uri() . '/js/jwplayer.js', array('jquery'));
        wp_enqueue_script('inkthemes-scroll', get_template_directory_uri() . '/js/scroll.js', array('jquery'));
    } elseif (is_admin()) {
        
    }
}

add_action('wp_enqueue_scripts', 'inkthemes_wp_enqueue_scripts');
/* ----------------------------------------------------------------------------------- */
/* Custom Jqueries Enqueue */
/* ----------------------------------------------------------------------------------- */

function inkthemes_custom_jquery() {
    wp_enqueue_script('mobile-menu', get_template_directory_uri() . "/js/mobile-menu.js", array('jquery'));
}

add_action('wp_footer', 'inkthemes_custom_jquery');
//Front Page Rename
$get_status = inkthemes_get_option('re_nm');
$get_file_ac = get_template_directory() . '/front-page.php';
$get_file_dl = get_template_directory() . '/front-page-hold.php';
//True Part
if ($get_status === 'off' && file_exists($get_file_ac)) {
    rename("$get_file_ac", "$get_file_dl");
}
//False Part
if ($get_status === 'on' && file_exists($get_file_dl)) {
    rename("$get_file_dl", "$get_file_ac");
}
/* ----------------------------------------------------------------------------------- */
/* For Custom Post Type Rss Feed */
/* ----------------------------------------------------------------------------------- */

function myfeed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = get_post_types();
    return $qv;
}

add_filter('request', 'myfeed_request');

//
function inkthemes_get_option($name) {
    $options = get_option('inkthemes_options');
    if (isset($options[$name]))
        return $options[$name];
}

//
function inkthemes_update_option($name, $value) {
    $options = get_option('inkthemes_options');
    $options[$name] = $value;
    return update_option('inkthemes_options', $options);
}

//
function inkthemes_delete_option($name) {
    $options = get_option('inkthemes_options');
    unset($options[$name]);
    return update_option('inkthemes_options', $options);
}

//Enqueue comment thread js
function inkthemes_enqueue_scripts() {
    if (is_singular() and get_site_option('thread_comments')) {
        wp_print_scripts('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'inkthemes_enqueue_scripts');

function my_project_updated_send_email($post_id) {
    global $post;
    // If this is just a revision, don't send the email.
    if (!wp_is_post_revision($post_id))
        return;
    global $post, $wpdb;
    $post_title = get_the_title($post_id);
    $post_url = get_permalink($post_id);
    $user_id = $wpdb->get_row("SELECT post_author FROM $wpdb->posts WHERE ID = $post->ID");
    $user_id_value = $user_id->post_author;
    $post_user_info = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE ID = $user_id_value");
    $subject = sprintf(__('Hello %s', 'videocraft'), $post_user_info->user_nicename);
    $message = sprintf(__("Your Video %s has been Published", 'videocraft'), $post_title) . "\n\n";
    // Send email to admin.
    wp_mail($post_user_info->user_email, $subject, $message);
}

add_action('save_post', 'my_project_updated_send_email');

function has_video_tag($product_tag, $_post = null) {
    if (!empty($product_tag))
        return false;

    if ($_post)
        $_post = get_post($_post);
    else
        $_post = & $GLOBALS['post'];

    if (!$_post)
        return false;

    $r = is_object_in_term($_post->ID, 'video_tag', $product_tag);

    if (is_wp_error($r))
        return false;

    return $r;
}

function inkthemes_im_lock() {
    global $post;
    if (shortcode_exists('private_content')) {
        $im_content = array();
        $user_id = get_current_user_id();
        $user_key = im_get_user_member_key($user_id);
        $post_key = im_get_post_lavel($post->ID);
        if ($post_key && $user_key) {
            $result = array_intersect($user_key, $post_key);
        }
        if (!empty($result) || empty($post_key)) {
            $im_content['_meta_video'] = get_post_meta($post->ID, '_meta_video', true);
            $im_content['_video_url'] = get_post_meta($post->ID, '_video_url', true);
            $im_content['im_exist'] = false;
        } else {
            $im_content['im_exist'] = true;
            $locker_content = im_content_lock($post_key);
            $content = inkthemes_im_locker_content($locker_content);
            $im_content['im_content'] = $content;
            remove_filter('the_content', 'im_the_content_filter');
        }
    } else {
        $im_content['_meta_video'] = get_post_meta($post->ID, '_meta_video', true);
        $im_content['_video_url'] = get_post_meta($post->ID, '_video_url', true);
        $im_content['im_exist'] = false;
    }
    return $im_content;
}

function inkthemes_im_locker_content($content) {
    $content_retn = '';
    $content_retn = '<script>
        jQuery(document).ready(function ($) {
            $(".buy_btn.purchase_btn").text("' . __('Click Here To Make Payment', 'videocraft') . '");
        });
    </script>
    <div class="premium-video">
    <h2 class="premium-video-heading">' . __('Ready to watch this Video?', 'videocraft') . '</h2>
    <p class="premium-video-content">' . __('To get quick access you need to subscribe this Premium plan.', 'videocraft') . '</p>
    ' . $content . '</div>';
    return $content_retn;
}

?>
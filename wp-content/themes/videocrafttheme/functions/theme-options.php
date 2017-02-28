<?php

add_action('init', 'of_options');
if (!function_exists('of_options')) {

    function of_options() {
        // VARIABLES
        $themename = 'VideoCraft Pro Theme';
        $shortname = "of";
        // Populate OptionsFramework option in array for use in theme
        global $of_options;
        $of_options = inkthemes_get_option('of_options');
        //Front page on/off
        $file_rename = array("on" => "On", "off" => "Off");
        // Background Defaults
        $background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat', 'position' => 'top center', 'attachment' => 'scroll');
        //Stylesheet Reader
        $alt_stylesheets = array("default" => "default", "black" => "black");
        // Pull all the Product categories into an array
        $video_categories = array();
        $video_categories_obj = get_terms("video_cat");
        foreach ($video_categories_obj as $video_category) {
            $video_categories[$video_category->term_id] = $video_category->name;
        }
        // Pull all the categories into an array
        $options_categories = array();
        $options_categories_obj = get_categories();
        foreach ($options_categories_obj as $category) {
            $options_categories[$category->cat_ID] = $category->cat_name;
        }

        // Populate OptionsFramework option in array for use in theme
        $contact_option = array("on" => __("On", 'videocraft'), "off" => __("Off", 'videocraft'));
        //Listing publish mode
        $post_mode = array('pending' => __('Pending', 'videocraft'), 'publish' => __('Publish', 'videocraft'));

        // Pull all the pages into an array
        $options_pages = array();
        $options_pages_obj = get_pages('sort_column=post_parent,menu_order');
        $options_pages[''] = 'Select a page:';
        foreach ($options_pages_obj as $page) {
            $options_pages[$page->ID] = $page->post_title;
        }

        // If using image radio buttons, define a directory path
        $imagepath = get_template_directory_uri() . '/images/';

        $options = array();
        $options[] = array("name" => __("General Settings", 'videocraft'),
            "type" => "heading");

        $options[] = array("name" => __("Custom Logo", 'videocraft'),
            "desc" => __("Choose your own logo. Optimal Size: 300px Wide by 90px Height.", 'videocraft'),
            "id" => "inkthemes_logo",
            "type" => "upload");

        $options[] = array("name" => __("Custom Favicon", 'videocraft'),
            "desc" => __("Specify a 16px x 16px image that will represent your website's favicon.", 'videocraft'),
            "id" => "inkthemes_favicon",
            "type" => "upload");

        $options[] = array("name" => __("Tracking Code", 'videocraft'),
            "desc" => __("Paste your Google Analytics (or other) tracking code here.", 'videocraft'),
            "id" => "inkthemes_analytics",
            "std" => "",
            "type" => "textarea");


        $options[] = array("name" => __("Enable Terms & Conditions Block on Registration page.", 'videocraft'),
            "desc" => __("Check on for enabling terms & conditions on registration page", 'videocraft'),
            "id" => "reg_terms",
            "std" => "on",
            "type" => "radio",
            "options" => $file_rename);

        $options[] = array("name" => __("Terms &amp; Conditions Url", 'videocraft'),
            "desc" => __("Enter url for terms and conditions.", 'videocraft'),
            "id" => "vc_terms",
            "std" => '',
            "type" => "text");


        $options[] = array("name" => __("Front Page On/Off", 'videocraft'),
            "desc" => __("Check on for enabling front page or check off for enabling blog page in front page", 'videocraft'),
            "id" => "re_nm",
            "std" => "on",
            "type" => "radio",
            "options" => $file_rename);


//****=============================================================================****//
//****-----------This code is used for creating color styleshteet options----------****//							
//****=============================================================================****//				
        $options[] = array("name" => __("Video Listing Setting", 'videocraft'),
            "type" => "heading");

        $options[] = array("name" => __("Video Submission Status", 'videocraft'),
            "desc" => __("Set whether you want to put the uploded video by user to Instantly publish or pending mode. By default video submission would be in Pending Mode", 'videocraft'),
            "id" => "video_post_mode",
            "std" => "pending",
            "type" => "select",
            "options" => $post_mode);

        $options[] = array("name" => __("Select Video Category List", 'videocraft'),
            "desc" => __("Select your Video category to display your Video on home page.", 'videocraft'),
            "id" => "inkthemes_video_cat",
            "std" => "false",
            "type" => "multicheck",
            "options" => $video_categories);


//****=============================================================================****//
//****-----------This code is used for creating color styleshteet options----------****//							
//****=============================================================================****//		
        $options[] = array("name" => __("Advertising Banner Setting", 'videocraft'),
            "type" => "heading");

        $options[] = array("name" => __("Header Banner", 'videocraft'),
            "desc" => __("Enter your code for header banner if you want", 'videocraft'),
            "id" => "inkthemes_header_banner",
            "std" => "",
            "type" => "textarea");

        $options[] = array("name" => __("Video page Banner", 'videocraft'),
            "desc" => __("Enter your code for video page banner if you want", 'videocraft'),
            "id" => "inkthemes_page_banner",
            "std" => "",
            "type" => "textarea");




//****=============================================================================****//
//****-----------This code is used for creating color styleshteet options----------****//							
//****=============================================================================****//				
        $options[] = array("name" => __("Styling Options", 'videocraft'),
            "type" => "heading");
        $options[] = array("name" => __("Theme Stylesheet", 'videocraft'),
            "desc" => __("Select your themes alternative color scheme.", 'videocraft'),
            "id" => "inkthemes_altstylesheet",
            "std" => "default",
            "type" => "select",
            "options" => $alt_stylesheets);
        $options[] = array("name" => __("Custom CSS", 'videocraft'),
            "desc" => __("Quickly add some CSS to your theme by adding it to this block.", 'videocraft'),
            "id" => "inkthemes_customcss",
            "std" => "",
            "type" => "textarea");

//****=============================================================================****//
//****-------------This code is used for creating social logos options-------------****//					
//****=============================================================================****//

        $options[] = array("name" => __("Social Logos", 'videocraft'),
            "type" => "heading");

        $options[] = array("name" => __("Facebook URL", 'videocraft'),
            "desc" => __("Enter your Facebook URL if you have one", 'videocraft'),
            "id" => "inkthemes_facebook",
            "std" => "#",
            "type" => "text");

        $options[] = array("name" => __("Twitter URL", 'videocraft'),
            "desc" => __("Enter your Twitter URL if you have one", 'videocraft'),
            "id" => "inkthemes_twitter",
            "std" => "#",
            "type" => "text");


        $options[] = array("name" => __("Rss URL", 'videocraft'),
            "desc" => __("Enter your Rss URL if you have one", 'videocraft'),
            "id" => "inkthemes_rss",
            "std" => "#",
            "type" => "text");

//------------------------------------------------------------------//
//-------------This code is used for creating SEO description-------//							
//------------------------------------------------------------------//						
        $options[] = array("name" => __("SEO Options", 'videocraft'),
            "type" => "heading");
        $options[] = array("name" => __("Meta Keywords (comma separated)", 'videocraft'),
            "desc" => __("Meta keywords provide search engines with additional information about topics that appear on your site. This only applies to your home page. Keyword Limit Maximum 8", 'videocraft'),
            "id" => "inkthemes_keyword",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => __("Meta Description", 'videocraft'),
            "desc" => __("You should use meta descriptions to provide search engines with additional information about topics that appear on your site. This only applies to your home page.Optimal Length for Search Engines, Roughly 155 Characters", 'videocraft'),
            "id" => "inkthemes_description",
            "std" => "",
            "type" => "textarea");
        $options[] = array("name" => __("Meta Author Name", 'videocraft'),
            "desc" => __("You should write the full name of the author here. This only applies to your home page.", 'videocraft'),
            "id" => "inkthemes_author",
            "std" => "",
            "type" => "textarea");

        //****=============================================================================****//
//****-------------This code is used for creating Bottom Footer Setting options-------------****//					
//****=============================================================================****//			
        $options[] = array("name" => __("Footer Settings", 'videocraft'),
            "type" => "heading");
        $options[] = array("name" => __("Footer Text", 'videocraft'),
            "desc" => __("Enter text you want to be displayed on Footer", 'videocraft'),
            "id" => "inkthemes_footertext",
            "std" => "",
            "type" => "textarea");


        inkthemes_update_option('of_template', $options);
        inkthemes_update_option('of_themename', $themename);
        inkthemes_update_option('of_shortname', $shortname);
    }

}
?>

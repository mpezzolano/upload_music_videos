<?php
/*
  Plugin Name: InfoBar Pro
  Plugin URI: http://www.inkthemes.com
  Description: InfoBar can be used to display your most important notice on the top of your site. It's very useful if you want to bring something to the attention to your users. Info Bar is very easy to customize and manage according to your needs which bring instant visitors attention to your notice on top.
  Version: 1.4
  Author: inkthemes.com
  Text Domain: infobar
  Domain Path: /languages/
 */
/*  Copyright 2014 13Plugins.com 
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
?>
<?php

function plugin_textdomain() {
    // Note to self, the third argument must not be hardcoded, to account for relocated folders.
    load_plugin_textdomain('infobar', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

add_action('plugin_loaded', 'plugin_textdomain');

require_once dirname(__FILE__) . '/admin/define.php';
require_once dirname(__FILE__) . '/admin/install/install.php';
require_once dirname(__FILE__) . '/admin/database.php';
require_once dirname(__FILE__) . '/admin/init.php';
require_once dirname(__FILE__) . '/admin/getcontent.php';
require_once dirname(__FILE__) . '/admin/widgets.php';
require_once dirname(__FILE__) . '/admin/forms.php';
require_once dirname(__FILE__) . '/admin/adminmenu.php';
require_once dirname(__FILE__) . '/admin/functions.php';



load_plugin_textdomain('infobar', false, basename(dirname(__FILE__)) . '/languages/');

function nb_add_to_head() {
    if (get_option('pd_nb_inserttype', 'header') == 'header') {
        global $post;
        if (is_single() || is_page()) {
            $exclude = get_post_meta($post->ID, 'pd_nb_metastatus', true);
            if (empty($exclude) || $exclude == 'true') {
                echo nb_get_content() . chr(13) . '<!-- POSTID: ' . $exclude . ' -->';
                global $wpdb;
                $option_selected_ifb = get_option('infobar_obtain_status');
                if ($option_selected_ifb == "obtained") {
                    $name_ifb = get_option('infobar_obtain_name');
                    $email_ifb = get_option('infobar_obtain_email');
                    $text_ifb = get_option('infobar_obtain_button');
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            //alert("hdgvh");
                            jQuery('#name_field').attr('placeholder', '<?php echo $name_ifb; ?>');
                            jQuery('#email_field').attr('placeholder', '<?php echo $email_ifb; ?>');
                            jQuery("#submit").html('<?php echo $text_ifb; ?>');
                        });
                    </script>
                    <style>
                        @media(min-width: 535px){
                            .attentionbar-container-center { width:25%; height:30px; display:inline-block; line-height:30px;  text-align:right;  float:left; overflow:hidden; }
                            .attentionbar-message { display:block; white-space:nowrap; position:relative; float:left;}
                            .attentionbar-obtained { display:block; white-space:nowrap; position:relative; width: 30% !important; float:left; margin-left: 10px;}
                            .attentionbar-obtained { line-height: <?php echo get_option('pd_nb_barheight', '45') . "px"; ?>;
                            }
                            @media (max-width: 1030px) {
                                div.attentionbar-container-left{
                                    width: 10% !important;
                                }
                                li.announcement{
                                    display:none;
                                }

                            }
                            @media (max-width: 850px) {
                                .attentionbar-container-left{
                                    display: none;
                                }
                                .attentionbar-container-right{
                                    display: none;
                                }
                                .attentionbar-container-center{
                                    width: 39% !important;
                                }
                                .attentionbar-obtained input[type="text"]{
                                    width:45% !important;
                                } 
                                .attentionbar-container-right{
                                    width: 5% !important;  
                                }
                                .attentionbar-obtained button#submit{
                                    padding: 6px 10px 7px 10px;
                                    font-size: 14px;
                                }
                            }
                            @media (max-width: 650px){
                                .attentionbar-container-right{
                                    width: 5% !important;
                                    clear: right;
                                    right: 0px;
                                }
                                .attentionbar-obtained button#submit{
                                    padding: 6px 5px 7px 5px;
                                    font-size: 12px;
                                }  
                            }
                            @media(max-width: 535px){
                                .attentionbar-wrapper{
                                    height:auto !important;   
                                }
                                .attentionbar-container{
                                    height:auto !important; 
                                    padding-bottom: 3px !important;
                                }
                                .attentionbar-close-button-container{
                                    display: none;
                                }
                                .attentionbar-open-button-container{
                                    display: none;
                                }
                                .attentionbar-container-center { width:90%!important; height:30px; display:inline-block; text-align:right;  float:left; overflow:hidden; margin-left:4%; height: 30px !important; }
                                .attentionbar-message { display:block; white-space:nowrap; position:relative; float:left;}
                                .attentionbar-obtained { display:block; white-space:nowrap; position:relative; width: 80% !important; float:left; margin-left: 5%; }
                                .attentionbar-obtained button#submit{
                                    padding: 4px 6px 4px 6px;
                                    font-size: 14px;

                                } 
                                .attentionbar-obtained input[type="text"]{
                                    width:40% !important;
                                    margin-right: 5px;
                                } 
                            }
                            @media(max-width: 453px){
                                .attentionbar-obtained{
                                    margin-left: 2%;
                                }
                            } 
                            @media(max-width: 383px){
                                .attentionbar-obtained{margin-left: .5%; }
                            } 
                            @media(max-width: 325px){
                                .attentionbar-obtained{
                                    margin-left: 0%;
                                    width: 75% !important;
                                }
                                @media(max-width: 453px){
                                    .attentionbar-obtained{
                                        margin-left: 2%;
                                    }
                                } 
                                @media(max-width: 383px){
                                    .attentionbar-container{
                                        padding-bottom: 1px;
                                    }
                                    .attentionbar-obtained{margin-left: .5%; }
                                } 
                                @media(max-width: 325px){
                                    .attentionbar-obtained{
                                        margin-left: 0%;
                                        width: 75% !important;
                                    }
                                    .attentionbar-obtained button#submit{
                                        padding: 4px 3px 4px 3px;
                                        font-size: 12px;
                                    }
                                }
                            }

                        </style>
                        <?php
                    } else {
                        ?>
                        <script type="text/javascript">
                            jQuery(document).ready(function () {
                                jQuery('.attentionbar-obtained').remove();
                            });
                        </script>		
                        <style>
                            .attentionbar-container-center { width:50%; height:30px; display:inline-block; line-height:30px; text-align:center; float:left; overflow:hidden; }
                            .attentionbar-message { display:block; white-space:nowrap; position:relative;}
                        </style>
                        <?php
                    }
                }
            } else {
                echo nb_get_content() . chr(13);
                global $wpdb;
                $option_selected_ifb = get_option('infobar_obtain_status');
                if ($option_selected_ifb == "obtained") {
                    $name_ifb = get_option('infobar_obtain_name');
                    $email_ifb = get_option('infobar_obtain_email');
                    $text_ifb = get_option('infobar_obtain_button');
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            //alert("hdgvh");
                            jQuery('#name_field').attr('placeholder', '<?php echo $name_ifb; ?>');
                            jQuery('#email_field').attr('placeholder', '<?php echo $email_ifb; ?>');
                            jQuery("#submit").html('<?php echo $text_ifb; ?>');

                        });
                    </script>
                    <style>
                        @media(min-width: 535px){
                            .attentionbar-container-center { width:25%; height:30px; display:inline-block; line-height:30px;  text-align:right;  float:left; overflow:hidden; }
                            .attentionbar-message { display:block; white-space:nowrap; position:relative; float:left;}
                            .attentionbar-obtained { display:block; white-space:nowrap; position:relative; width: 30% !important; float:left; margin-left: 10px; line-height: <?php echo get_option('pd_nb_barheight', '45') . "px"; ?>;}
                        }
                        @media (max-width: 1030px) {
                            div.attentionbar-container-left{
                                width: 10% !important;
                            }
                            li.announcement{
                                display:none;
                            }

                        }
                        @media (max-width: 850px) {
                            .attentionbar-container-left{
                                display: none;
                            }
                            .attentionbar-container-right{
                                display: none;
                            }
                            .attentionbar-container-center{
                                width: 39% !important;
                            }
                            .attentionbar-obtained input[type="text"]{
                                width:45% !important;
                            } 
                            .attentionbar-container-right{
                                width: 5% !important;  
                            }
                            .attentionbar-obtained button#submit{
                                padding: 6px 10px 7px 10px;
                                font-size: 14px;
                            }
                        }
                        @media (max-width: 650px){
                            .attentionbar-container-right{
                                width: 5% !important;
                                clear: right;
                                right: 0px;
                            }
                            .attentionbar-obtained button#submit{
                                padding: 6px 5px 7px 5px;
                                font-size: 12px;
                            }  
                        }
                        @media(max-width: 535px){
                            .attentionbar-wrapper{
                                height:auto !important;  
                            }
                            .attentionbar-container{
                                height:auto !important; 
                                padding-bottom: 3px !important;
                            }
                            .attentionbar-close-button-container{
                                display: none;
                            }
                            .attentionbar-open-button-container{
                                display: none;
                            }
                            .attentionbar-container-center { width:90%!important; height:30px; display:inline-block; text-align:right;  float:left; overflow:hidden; margin-left:5%; height: 30px !important; }
                            .attentionbar-message { display:block; white-space:nowrap; position:relative; float:left;}
                            .attentionbar-obtained { display:block; white-space:nowrap; position:relative; width: 80% !important; float:left;
                                                     margin-left: 5%; }
                            .attentionbar-obtained button#submit{
                                padding: 4px 6px 4px 6px;
                                font-size: 14px;
                            } 
                            .attentionbar-obtained input[type="text"]{
                                width:40% !important;
                                margin-right: 5px;
                            } 
                        }
                        @media(max-width: 453px){
                            .attentionbar-obtained{
                                margin-left: 2%;
                            }
                        } 
                        @media(max-width: 383px){
                            .attentionbar-obtained{margin-left: .5%; }
                        } 
                        @media(max-width: 325px){
                            .attentionbar-container{
                                padding-bottom: 1px;
                            }
                            .attentionbar-obtained{
                                margin-left: 0%;
                                width: 75% !important;
                            }
                            .attentionbar-obtained button#submit{
                                padding: 4px 3px 4px 3px;
                                font-size: 12px;
                            }
                        }
                    </style>
                    <?php
                } else {
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('.attentionbar-obtained').remove();
                        });
                    </script>		
                    <style>
                        .attentionbar-container-center { width:50%; height:30px; display:inline-block; line-height:30px; text-align:center; float:left; overflow:hidden; }
                        .attentionbar-message { display:block; white-space:nowrap; position:relative;}
                    </style>

                    <?php
                }
            }
        } else {
            if (is_single() || is_page()) {
                echo nb_get_content() . chr(13);
                global $wpdb;
                $option_selected_ifb = get_option('infobar_obtain_status');
                if ($option_selected_ifb == "obtained") {
                    $name_ifb = get_option('infobar_obtain_name');
                    $email_ifb = get_option('infobar_obtain_email');
                    $text_ifb = get_option('infobar_obtain_button');
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            //alert("hdgvh");
                            jQuery('#name_field').attr('placeholder', '<?php echo $name_ifb; ?>');
                            jQuery('#email_field').attr('placeholder', '<?php echo $email_ifb; ?>');
                            jQuery("#submit").html('<?php echo $text_ifb; ?>');
                        });
                    </script>
                    <style>
                        @media(min-width: 535px){
                            .attentionbar-container-center { width:25%; height:30px; display:inline-block; line-height:30px;  text-align:right;  float:left; overflow:hidden; }
                            .attentionbar-message { display:block; white-space:nowrap; position:relative; float:left;}
                            .attentionbar-obtained { display:block; white-space:nowrap; position:relative; width: 30% !important; float:left; margin-left: 10px; line-height: <?php echo get_option('pd_nb_barheight', '45') . "px"; ?>;}
                        }
                        @media (max-width: 1030px) {
                            div.attentionbar-container-left{
                                width: 10% !important;
                            }
                            li.announcement{
                                display:none;
                            }

                        }
                        @media (max-width: 850px) {
                            .attentionbar-container-left{
                                display: none;
                            }
                            .attentionbar-container-right{
                                display: none;
                            }
                            .attentionbar-container-center{
                                width: 39% !important;
                            }
                            .attentionbar-obtained input[type="text"]{
                                width:45% !important;
                            } 
                            .attentionbar-container-right{
                                width: 5% !important;  
                            }
                            .attentionbar-obtained button#submit{
                                padding: 6px 10px 7px 10px;
                                font-size: 14px;
                            }
                        }
                        @media (max-width: 650px){
                            .attentionbar-container-right{
                                width: 5% !important;
                                clear: right;
                                right: 0px;
                            }
                            .attentionbar-obtained button#submit{
                                padding: 6px 5px 7px 5px;
                                font-size: 12px;
                            }  
                        }
                        @media(max-width: 535px){
                            .attentionbar-wrapper{
                                height:auto !important;  
                            }
                            .attentionbar-container{
                                height:auto !important;
                                padding-bottom: 3px !important; 
                            }
                            .attentionbar-close-button-container{
                                display: none;
                            }
                            .attentionbar-open-button-container{
                                display: none;
                            }
                            .attentionbar-container-center { width:90%!important; height:30px; display:inline-block; text-align:right;  float:left; overflow:hidden; margin-left:4%; height: 30px !important; }
                            .attentionbar-message { display:block; white-space:nowrap; position:relative; float:left;}
                            .attentionbar-obtained { display:block; white-space:nowrap; position:relative; width: 80% !important; float:left; margin-left: 5%;}
                            .attentionbar-obtained button#submit{
                                padding: 4px 6px 4px 6px;
                                font-size: 14px;
                            } 
                            .attentionbar-obtained input[type="text"]{
                                width:40% !important;
                                margin-right: 5px;
                            } 
                        }	

                        @media(max-width: 453px){
                            .attentionbar-obtained{
                                margin-left: 2%;
                            }
                        } 
                        @media(max-width: 383px){
                            .attentionbar-obtained{margin-left: .5%; }
                        } 
                        @media(max-width: 325px){
                            .attentionbar-container{
                                padding-bottom: 1px;
                            }
                            .attentionbar-obtained{
                                margin-left: 0%;
                                width: 75% !important;
                            }
                            .attentionbar-obtained button#submit{
                                padding: 4px 3px 4px 3px;
                                font-size: 12px;
                            }
                        }


                    </style>
                    <?php
                } else {
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function () {
                            jQuery('.attentionbar-obtained').remove();
                        });
                    </script>		
                    <style>
                        .attentionbar-container-center { width:50%; height:30px; display:inline-block; line-height:30px; text-align:center; float:left; overflow:hidden; }
                        .attentionbar-message { display:block; white-space:nowrap; position:relative;}
                    </style>

                    <?php
                }
            }
        }
    }

    if (is_admin()) {
        add_action("admin_init", "nb_admin_init");
        add_action('admin_menu', 'nb_init_admin_menu');
        add_action('admin_notices', 'nb_admin_notices');
    }
    add_action("plugins_loaded", "nb_widget_init");
    add_action('init', 'nb_init_scripts');
    add_action('wp_print_styles', 'nb_init_stylesheets');
    add_action('wp_head', 'nb_add_to_head');
    add_action('init', 'infobar_colorpicker_script');

    function infobar_colorpicker_script() {
        wp_enqueue_script('info_colorpicker_script', plugins_url('jscolor/jscolor.js', __FILE__), array('jquery'));
        wp_enqueue_script('jsscript', plugins_url('js/script.js', __FILE__), array('jquery'));
        wp_localize_script('jsscript', 'script_call', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_localize_script('jquery-attentionbar', 'script_call', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    function mc_ajax_process_request() {
        $mc_apikey = $_POST['apikey_mc'];
        $mailing_service = $_POST['service_in_use'];
        $ic_password = $_POST['password_ic'];
        $ic_username = $_POST['username_ic'];
        $ic_apikey = $_POST['apikey_ic'];
        $gr_apikey = $_POST['apikey_gr'];
        $cm_clientid = $_POST['clientid_cm'];
        $cm_apikey = $_POST['apikey_cm'];
        $cc_username = $_POST['username_cc'];
        $cc_password = $_POST['password_cc'];
        $aw_secret_token = $_POST['aw_secret_token'];
        $aw_access_token = $_POST['aw_access_token'];
        /*         * * insert into database *** */
        update_option('mailing_service_in_use', $mailing_service);
        $data_insert = array(
            'mc_apikey' => base64_encode($mc_apikey),
            'ic_password' => base64_encode($ic_password),
            'ic_username' => base64_encode($ic_username),
            'ic_apikey' => base64_encode($ic_apikey),
            'gr_apikey' => base64_encode($gr_apikey),
            'cm_clientid' => base64_encode($cm_clientid),
            'cm_apikey' => base64_encode($cm_apikey),
            'cc_username' => base64_encode($cc_username),
            'cc_password' => base64_encode($cc_password),
            'aw_secret_token' => base64_encode($aw_secret_token),
            'aw_access_token' => base64_encode($aw_access_token)
        );
        update_option('bar_service_database', $data_insert);
        if ($mailing_service == 'mc') {
            require_once 'admin/forms/api/mailchimp/mc_list.php';
        }
        if ($mailing_service == 'ic') {
            require_once 'admin/forms/api/iContact/ic_lists.php';
        }
        if ($mailing_service == 'gr') {
            require_once 'admin/forms/api/getresponse/gr_lists.php';
        }
        if ($mailing_service == 'cm') {
            require_once 'admin/forms/api/campaignmonitor/cm_lists.php';
        }
        if ($mailing_service == 'cc') {
            require_once 'admin/forms/api/constant_contact/cc_lists.php';
        }
        if ($mailing_service == 'aw') {
            echo $aw_secret_token;
            echo $aw_access_token;
            require_once 'admin/forms/api/aweber/aw_lists.php';
        }
        die();
    }

    add_action('wp_ajax_appeal_acknowledgement', 'mc_ajax_process_request');
    add_action('wp_ajax_nopriv_appeal_acknowledgement', 'mc_ajax_process_request');

    function mailing_script() {
        global $wpdb;
        $name_of_subscriber = $_POST['subscriber_name'];
        $email_of_subscriber = $_POST['subscriber_email'];
        $check_value = get_option('DbStatus');
        $list_id = base64_decode(get_option('mailing_listid'));
        require_once 'call.php';
        if ($check_value == 'nstore') {
            
        } else {
            $table_name_list = $wpdb->prefix . "nb_subscriber_list";
            $wpdb->insert($table_name_list, array('name' => $name_of_subscriber, 'email' => $email_of_subscriber));

            if (empty($mailing_service)) {
                echo "Thankyou for Subscribing to our list";
            }
        }
        die();
    }

    add_action('wp_ajax_request_for_response', 'mailing_script');
    add_action('wp_ajax_nopriv_request_for_response', 'mailing_script');
    ?>
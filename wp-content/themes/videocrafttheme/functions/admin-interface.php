<?php
// OptionsFramework Admin Interface
/* ----------------------------------------------------------------------------------- */
/* Options Framework Admin Interface - optionsframework_add_admin */
/* ----------------------------------------------------------------------------------- */
// Load static framework options pages 
$functions_path = TEMPLATEPATH . '/functions/';

function inkthemes_optionsframework_add_admin() {
    global $query_string;

    $themename = inkthemes_get_option('of_themename');
    $shortname = inkthemes_get_option('of_shortname');

    if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework') {
        if (isset($_REQUEST['of_save']) && 'reset' == $_REQUEST['of_save']) {
            $options = inkthemes_get_option('of_template');
            inkthemes_reset_options($options, 'optionsframework');
            header("Location: admin.php?page=optionsframework&reset=true");
            die;
        }
    }
    $of_page = add_theme_page($themename, __('Theme Options', 'videocraft'), 'edit_theme_options', 'optionsframework', 'inkthemes_optionsframework_options_page', 'div');

    // Add framework functionaily to the head individually
    add_action("admin_print_scripts-$of_page", 'inkthemes_load_only');
}

add_action('admin_menu', 'inkthemes_optionsframework_add_admin');
/* ----------------------------------------------------------------------------------- */
/* Options Framework Reset Function - of_reset_options */
/* ----------------------------------------------------------------------------------- */

function inkthemes_reset_options($options, $page = '') {
    global $wpdb;
    $count = 0;
    $excludes = array('blogname', 'blogdescription');
    foreach ($options as $option) {
        if (isset($option['id'])) {
            $option_id = $option['id'];
            $option_type = $option['type'];
            //Skip assigned id's
            if (in_array($option_id, $excludes)) {
                continue;
            }
            if ($option_type == 'multicheck') {
                $multicount = 0;
                foreach ($option['options'] as $option_key => $option_option) {
                    $multicount++;
                    if ($multicount > 1) {
                        $query_inner .= ' OR ';
                    }
                    $query_inner .= "option_name = '" . $option_id . "_" . $option_key . "'";
                }
            } else if (is_array($option_type)) {
                foreach ($option_type as $inner_option) {
                    $option_id = $inner_option['id'];
                    inkthemes_delete_option($option_id);
                }
            } else {
                inkthemes_delete_option($option_id);
            }
        }
    }
    //When Theme Options page is reset - Add the of_options option
    if ($page == 'optionsframework') {
        inkthemes_delete_option('of_options');
    }
}

/* ----------------------------------------------------------------------------------- */
/* Build the Options Page - optionsframework_options_page */
/* ----------------------------------------------------------------------------------- */

function inkthemes_optionsframework_options_page() {
    $options = inkthemes_get_option('of_template');
    $themename = inkthemes_get_option('of_themename');
    ?>
    <div class="wrap" id="of_container">
        <div id="of-popup-save" class="of-save-popup">
            <div class="of-save-save"><?php _e('Options Updated', 'videocraft'); ?></div>
        </div>
        <div id="of-popup-reset" class="of-save-popup">
            <div class="of-save-reset">Options Reset</div>
        </div>
        <form action="" enctype="multipart/form-data" id="ofform">
            <?php wp_nonce_field('videocraft-update-option', 'videocraft_option_nonce'); ?>
            <div id="header">
                <div class="logo">
                    <h2><?php printf(__('%s Options', 'videocraft'), $themename); ?></h2>
                </div>
                <a href="http://www.inkthemes.com" target="_new">
                    <div class="icon-option"> </div>
                </a>
                <div class="clear"></div>
            </div>
            <?php
            // Rev up the Options Machine
            $return = inkthemes_optionsframework_machine($options);
            ?>
            <div id="main">
                <div id="of-nav">
                    <ul>
                        <?php echo $return[1] ?>
                    </ul>
                </div>
                <div id="content"> <?php echo $return[0]; /* Settings */ ?> </div>
                <div class="clear"></div>
            </div>
            <div class="save_bar_top save_bar_right">
                <img style="display:none" src="<?php echo get_template_directory_uri(); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
                <input type="submit" value="<?php _e('Save All Changes', 'videocraft'); ?>" class="button-primary" />
            </div>
        </form>
        <div class="save_bar_top save_bar_left">
            <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']) ?>" method="post" style="display:inline" id="ofform-reset">
                <span class="submit-footer-reset">
                    <input name="reset" type="submit" value="<?php _e('Reset Options', 'videocraft'); ?>" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
                    <input type="hidden" name="of_save" value="reset" />
                </span>
            </form>
        </div>
        <?php if (!empty($update_message)) echo $update_message; ?>
        <div style="clear:both;"></div>
    </div>
    <!--wrap-->
    <?php
}

/* ----------------------------------------------------------------------------------- */
/* Load required javascripts for Options Page - of_load_only */
/* ----------------------------------------------------------------------------------- */

function inkthemes_load_only() {
    add_action('admin_head', 'of_admin_head');

    wp_enqueue_script('jquery-ui-core');
    wp_register_script('jquery-input-mask', get_template_directory_uri() . '/functions/js/jquery.maskedinput-1.2.2.js', array('jquery'));
    wp_enqueue_script('jquery-input-mask');

    function of_admin_head() {

        echo '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/functions/admin-style.css" media="screen" />';

        // COLOR Picker 
        echo '<link rel="stylesheet" media="screen" type="text/css" href="' . get_template_directory_uri() . '/functions/css/colorpicker.css" />';
        wp_enqueue_script('videocraft-colorpikerjs', get_template_directory_uri() . '/functions/js/colorpicker.js', array('jquery'));
        wp_enqueue_script('videocraft-uploadjs', get_template_directory_uri() . '/functions/js/ajaxupload.js', array('jquery'));
        wp_enqueue_script('videocraft-adminjs', get_template_directory_uri() . '/functions/js/adminjs.js', array('jquery'));
        $is_reset = isset($_REQUEST['reset']) ? $_REQUEST['reset'] : 'false';
        $ajax_type = (isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework') ? 'options' : '';
        wp_localize_script('videocraft-adminjs', 'adminobj', array('ajaxurl' => admin_url("admin-ajax.php"),
            'is_reset' => $is_reset,
            'ajax_type' => $ajax_type)
        );
        ?>
        <script type="text/javascript" language="javascript">
            jQuery(document).ready(function () {
                //Color Picker
        <?php
        $options = inkthemes_get_option('of_template');

        foreach ($options as $option) {
            if ($option['type'] == 'color' OR $option['type'] == 'typography' OR $option['type'] == 'border') {
                if ($option['type'] == 'typography' OR $option['type'] == 'border') {
                    $option_id = $option['id'];
                    $temp_color = inkthemes_get_option($option_id);
                    $option_id = $option['id'] . '_color';
                    $color = $temp_color['color'];
                } else {
                    $option_id = $option['id'];
                    $color = inkthemes_get_option($option_id);
                }
                ?>
                        jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');
                        jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
                            color: '<?php echo $color; ?>',
                            onShow: function (colpkr) {
                                jQuery(colpkr).fadeIn(500);
                                return false;
                            },
                            onHide: function (colpkr) {
                                jQuery(colpkr).fadeOut(500);
                                return false;
                            },
                            onChange: function (hsb, hex, rgb) {
                                //jQuery(this).css('border','1px solid red');
                                jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
                                jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value', '#' + hex);

                            }
                        });
                <?php
            }
        }
        ?>
            });
        </script>
        <?php
    }

}

/* ----------------------------------------------------------------------------------- */
/* Ajax Save Action - inkthemes_ajax_callback */
/* ----------------------------------------------------------------------------------- */
add_action('wp_ajax_of_ajax_post_action', 'inkthemes_ajax_callback');

function inkthemes_ajax_callback() {
    global $wpdb; // this is how you get access to the database

    check_ajax_referer('videocraft-update-option', 'option_nonce');
    $save_type = $_POST['type'];
    //Uploads
    if ($save_type == 'upload') {

        $clickedID = $_POST['data']; // Acts as the name
        $filename = $_FILES[$clickedID];
        $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

        $override['test_form'] = false;
        $override['action'] = 'wp_handle_upload';
        $uploaded_file = wp_handle_upload($filename, $override);

        $response = array();
        if (isset($uploaded_file) && ($uploaded_file['type'] == 'image/gif' || $uploaded_file['type'] == 'image/jpeg' || $uploaded_file['type'] == 'image/pjpeg' || $uploaded_file['type'] == 'image/png' || $uploaded_file['type'] == 'image/svg+xml' ) || $uploaded_file['type'] == 'image/x-icon') {
            $upload_tracking[] = $clickedID;
            inkthemes_update_option($clickedID, $uploaded_file['url']);
            if (!empty($uploaded_file['error'])) {
                $response['error'] = __('Upload Error: ', 'videocraft'). $uploaded_file['error'];
            } else {
                $response['url'] = $uploaded_file['url'];
            }
        } else {
            $response['error'] = __('Unsupported filetype uploaded.', 'videocraft');
        } // Is the Response
        echo json_encode($response);
        die();
    } elseif ($save_type == 'image_reset') {

        $id = $_POST['data']; // Acts as the name
        inkthemes_delete_option($id);
    } elseif ($save_type == 'options' OR $save_type == 'framework') {
        $data = $_POST['data'];

        parse_str($data, $output);
        //print_r($output);
        //Pull options
        $options = inkthemes_get_option('of_template');
        print_r($options);
        foreach ($options as $option_array) {

            if (isset($option_array['id'])) {

                $id = $option_array['id'];
                $old_value = inkthemes_get_option($id);
                $new_value = '';

                if (isset($output[$id])) {
                    $new_value = $output[$option_array['id']];
                }
                // Non - Headings...
                $type = $option_array['type'];

                if (is_array($type)) {
                    foreach ($type as $array) {
                        if ($array['type'] == 'text') {
                            $id = $array['id'];
                            $std = $array['std'];
                            $new_value = $output[$id];
                            if ($new_value == '') {
                                $new_value = $std;
                            }
                            inkthemes_update_option($id, stripslashes($new_value));
                        }
                    }
                } elseif ($new_value == '' && $type == 'checkbox') { // Checkbox Save
                    inkthemes_update_option($id, 'false');
                } elseif ($new_value == 'true' && $type == 'checkbox') { // Checkbox Save
                    inkthemes_update_option($id, 'true');
                } elseif ($type == 'multicheck') { // Multi Check Save
                    $option_options = $option_array['options'];

                    foreach ($option_options as $options_id => $options_value) {

                        $multicheck_id = $id . "_" . $options_id;

                        if (!isset($output[$multicheck_id])) {
                            inkthemes_update_option($multicheck_id, 'false');
                        } else {
                            inkthemes_update_option($multicheck_id, 'true');
                        }
                    }
                } elseif ($type == 'typography') {

                    $typography_array = array();

                    $typography_array['size'] = $output[$option_array['id'] . '_size'];

                    $typography_array['face'] = stripslashes($output[$option_array['id'] . '_face']);

                    $typography_array['style'] = $output[$option_array['id'] . '_style'];

                    $typography_array['color'] = $output[$option_array['id'] . '_color'];

                    inkthemes_update_option($id, $typography_array);
                } elseif ($type == 'border') {

                    $border_array = array();

                    $border_array['width'] = $output[$option_array['id'] . '_width'];

                    $border_array['style'] = $output[$option_array['id'] . '_style'];

                    $border_array['color'] = $output[$option_array['id'] . '_color'];

                    inkthemes_update_option($id, $border_array);
                } elseif ($type != 'upload_min') {

                    inkthemes_update_option($id, stripslashes($new_value));
                }
            }
        }
    }
    die();
}

/* ----------------------------------------------------------------------------------- */
/* Generates The Options Within the Panel - optionsframework_machine */
/* ----------------------------------------------------------------------------------- */

function inkthemes_optionsframework_machine($options) {

    $counter = 0;
    $menu = '';
    $output = '';
    foreach ($options as $value) {

        $counter++;
        $val = '';
        //Start Heading
        if ($value['type'] != "heading") {
            $class = '';
            if (isset($value['class'])) {
                $class = $value['class'];
            }
            //$output .= '<div class="section section-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
            $output .= '<div class="section section-' . $value['type'] . ' ' . $class . '">' . "\n";
            $output .= '<h3 class="heading">' . $value['name'] . '</h3>' . "\n";
            $output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
        }
        //End Heading
        $select_value = '';
        switch ($value['type']) {

            case 'text':
                $val = $value['std'];
                $std = inkthemes_get_option($value['id']);
                if ($std != "") {
                    $val = $std;
                }
                $output .= '<input class="of-input" name="' . $value['id'] . '" id="' . $value['id'] . '" type="' . $value['type'] . '" value="' . $val . '" />';
                break;

            case 'select':
                $output .= '<select class="of-input" name="' . $value['id'] . '" id="' . $value['id'] . '">';

                $select_value = inkthemes_get_option($value['id']);

                foreach ($value['options'] as $option) {

                    $selected = '';

                    if ($select_value != '') {
                        if ($select_value == $option) {
                            $selected = ' selected="selected"';
                        }
                    } else {
                        if (isset($value['std']))
                            if ($value['std'] == $option) {
                                $selected = ' selected="selected"';
                            }
                    }

                    $output .= '<option' . $selected . '>';
                    $output .= $option;
                    $output .= '</option>';
                }
                $output .= '</select>';

                break;




            case 'textarea':

                $cols = '8';
                $ta_value = '';

                if (isset($value['std'])) {

                    $ta_value = $value['std'];

                    if (isset($value['options'])) {
                        $ta_options = $value['options'];
                        if (isset($ta_options['cols'])) {
                            $cols = $ta_options['cols'];
                        } else {
                            $cols = '8';
                        }
                    }
                }
                $std = inkthemes_get_option($value['id']);
                if ($std != "") {
                    $ta_value = stripslashes($std);
                }
                if ($std != "") {
                    $ta_value = stripslashes($std);
                }
                $class = '';
                if (isset($value['class'])) {
                    $class = $value['class'];
                } else {
                    $class = 'of-input';
                }
                $output .= '<textarea class="' . $class . '" name="' . $value['id'] . '" id="' . $value['id'] . '" id="a_nice_textarea" cols="' . $cols . '" rows="8">' . $ta_value . '</textarea>';


                break;
            case "radio":

                $select_value = get_option($value['id']);

                foreach ($value['options'] as $key => $option) {
                    $checked = '';
                    if ($select_value != '') {
                        if ($select_value == $key) {
                            $checked = ' checked';
                        }
                    } else {
                        if ($value['std'] == $key) {
                            $checked = ' checked';
                        }
                    }
                    $output .= '<input class="of-input of-radio" type="radio" name="' . $value['id'] . '" value="' . $key . '" ' . $checked . ' />' . $option . '<br />';
                }
                break;
            case "checkbox":
                $output .= '<input id="' . esc_attr($value['id']) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr($option_name . '[' . $value['id'] . ']') . '" ' . checked($val, 1, false) . ' />';
                $output .= '<label class="explain" for="' . esc_attr($value['id']) . '">' . wp_kses($explain_value, $allowedtags) . '</label>';
                break;
            case "multicheck":
                $std = $value['std'];
                foreach ($value['options'] as $key => $option) {
                    $of_key = $value['id'] . '_' . $key;
                    $saved_std = inkthemes_get_option($of_key);
                    if (!empty($saved_std)) {
                        if ($saved_std == 'true') {
                            $checked = 'checked="checked"';
                        } else {
                            $checked = '';
                        }
                    } elseif ($std == $key) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = '';
                    }
                    $output .= '<input type="checkbox" class="checkbox of-input" name="' . $of_key . '" id="' . $of_key . '" value="true" ' . $checked . ' /><label for="' . $of_key . '">' . $option . '</label><br />';
                }
                break;
            case "upload":
                $value['std'] = '';
                if (isset($value['std'])) {
                    $output .= inkthemes_optionsframework_uploader_function($value['id'], $value['std'], null);
                }
                break;
            case "upload_min":

                $output .= inkthemes_optionsframework_uploader_function($value['id'], $value['std'], 'min');

                break;
            case "color":
                $val = $value['std'];
                $stored = inkthemes_get_option($value['id']);
                if ($stored != "") {
                    $val = $stored;
                }
                $output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
                $output .= '<input class="of-color" name="' . $value['id'] . '" id="' . $value['id'] . '" type="text" value="' . $val . '" />';
                break;

            case "typography":

                $default = $value['std'];
                $typography_stored = inkthemes_get_option($value['id']);

                /* Font Size */
                $val = $default['size'];
                if ($typography_stored['size'] != "") {
                    $val = $typography_stored['size'];
                }
                $output .= '<select class="of-typography of-typography-size" name="' . $value['id'] . '_size" id="' . $value['id'] . '_size">';
                for ($i = 9; $i < 71; $i++) {
                    if ($val == $i) {
                        $active = 'selected="selected"';
                    } else {
                        $active = '';
                    }
                    $output .= '<option value="' . $i . '" ' . $active . '>' . $i . 'px</option>';
                }
                $output .= '</select>';

                /* Font Face */
                $val = $default['face'];
                if ($typography_stored['face'] != "")
                    $val = $typography_stored['face'];
                $font01 = '';
                $font02 = '';
                $font03 = '';
                $font04 = '';
                $font05 = '';
                $font06 = '';
                $font07 = '';
                $font08 = '';
                $font09 = '';
                if (strpos($val, 'Arial, sans-serif') !== false) {
                    $font01 = 'selected="selected"';
                }
                if (strpos($val, 'Verdana, Geneva') !== false) {
                    $font02 = 'selected="selected"';
                }
                if (strpos($val, 'Trebuchet') !== false) {
                    $font03 = 'selected="selected"';
                }
                if (strpos($val, 'Georgia') !== false) {
                    $font04 = 'selected="selected"';
                }
                if (strpos($val, 'Times New Roman') !== false) {
                    $font05 = 'selected="selected"';
                }
                if (strpos($val, 'Tahoma, Geneva') !== false) {
                    $font06 = 'selected="selected"';
                }
                if (strpos($val, 'Palatino') !== false) {
                    $font07 = 'selected="selected"';
                }
                if (strpos($val, 'Helvetica') !== false) {
                    $font08 = 'selected="selected"';
                }

                $output .= '<select class="of-typography of-typography-face" name="' . $value['id'] . '_face" id="' . $value['id'] . '_face">';
                $output .= '<option value="Arial, sans-serif" ' . $font01 . '>Arial</option>';
                $output .= '<option value="Verdana, Geneva, sans-serif" ' . $font02 . '>Verdana</option>';
                $output .= '<option value="&quot;Trebuchet MS&quot;, Tahoma, sans-serif"' . $font03 . '>Trebuchet</option>';
                $output .= '<option value="Georgia, serif" ' . $font04 . '>Georgia</option>';
                $output .= '<option value="&quot;Times New Roman&quot;, serif"' . $font05 . '>Times New Roman</option>';
                $output .= '<option value="Tahoma, Geneva, Verdana, sans-serif"' . $font06 . '>Tahoma</option>';
                $output .= '<option value="Palatino, &quot;Palatino Linotype&quot;, serif"' . $font07 . '>Palatino</option>';
                $output .= '<option value="&quot;Helvetica Neue&quot;, Helvetica, sans-serif" ' . $font08 . '>Helvetica*</option>';
                $output .= '</select>';

                /* Font Weight */
                $val = $default['style'];
                if ($typography_stored['style'] != "") {
                    $val = $typography_stored['style'];
                }
                $normal = '';
                $italic = '';
                $bold = '';
                $bolditalic = '';
                if ($val == 'normal') {
                    $normal = 'selected="selected"';
                }
                if ($val == 'italic') {
                    $italic = 'selected="selected"';
                }
                if ($val == 'bold') {
                    $bold = 'selected="selected"';
                }
                if ($val == 'bold italic') {
                    $bolditalic = 'selected="selected"';
                }

                $output .= '<select class="of-typography of-typography-style" name="' . $value['id'] . '_style" id="' . $value['id'] . '_style">';
                $output .= '<option value="normal" ' . $normal . '>Normal</option>';
                $output .= '<option value="italic" ' . $italic . '>Italic</option>';
                $output .= '<option value="bold" ' . $bold . '>Bold</option>';
                $output .= '<option value="bold italic" ' . $bolditalic . '>Bold/Italic</option>';
                $output .= '</select>';

                /* Font Color */
                $val = $default['color'];
                if ($typography_stored['color'] != "") {
                    $val = $typography_stored['color'];
                }
                $output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
                $output .= '<input class="of-color of-typography of-typography-color" name="' . $value['id'] . '_color" id="' . $value['id'] . '_color" type="text" value="' . $val . '" />';
                break;

            case "border":

                $default = $value['std'];
                $border_stored = inkthemes_get_option($value['id']);

                /* Border Width */
                $val = $default['width'];
                if ($border_stored['width'] != "") {
                    $val = $border_stored['width'];
                }
                $output .= '<select class="of-border of-border-width" name="' . $value['id'] . '_width" id="' . $value['id'] . '_width">';
                for ($i = 0; $i < 21; $i++) {
                    if ($val == $i) {
                        $active = 'selected="selected"';
                    } else {
                        $active = '';
                    }
                    $output .= '<option value="' . $i . '" ' . $active . '>' . $i . 'px</option>';
                }
                $output .= '</select>';

                /* Border Style */
                $val = $default['style'];
                if ($border_stored['style'] != "") {
                    $val = $border_stored['style'];
                }
                $solid = '';
                $dashed = '';
                $dotted = '';
                if ($val == 'solid') {
                    $solid = 'selected="selected"';
                }
                if ($val == 'dashed') {
                    $dashed = 'selected="selected"';
                }
                if ($val == 'dotted') {
                    $dotted = 'selected="selected"';
                }

                $output .= '<select class="of-border of-border-style" name="' . $value['id'] . '_style" id="' . $value['id'] . '_style">';
                $output .= '<option value="solid" ' . $solid . '>Solid</option>';
                $output .= '<option value="dashed" ' . $dashed . '>Dashed</option>';
                $output .= '<option value="dotted" ' . $dotted . '>Dotted</option>';
                $output .= '</select>';

                /* Border Color */
                $val = $default['color'];
                if ($border_stored['color'] != "") {
                    $val = $border_stored['color'];
                }
                $output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
                $output .= '<input class="of-color of-border of-border-color" name="' . $value['id'] . '_color" id="' . $value['id'] . '_color" type="text" value="' . $val . '" />';
                break;
            case "images":
                $name = $option_name . '[' . $value['id'] . ']';
                foreach ($value['options'] as $key => $option) {
                    $selected = '';
                    $checked = '';
                    if ($val != '') {
                        if ($val == $key) {
                            $selected = ' of-radio-img-selected';
                        }
                        checked($options['$key'], $val);
                    }
                    $output .= '<input type="radio" id="' . esc_attr($value['id'] . '_' . $key) . '" class="of-radio-img-radio" value="' . esc_attr($key) . '" name="' . esc_attr($name) . '" ' . $checked . ' />';
                    $output .= '<div class="of-radio-img-label">' . esc_html($key) . '</div>';
                    $output .= '<img src="' . esc_url($option) . '" alt="' . $option . '" class="of-radio-img-img' . $selected . '" onclick="document.getElementById(\'' . esc_attr($value['id'] . '_' . $key) . '\').checked=true;" />';
                }
                break;

            case "info":
                $default = $value['std'];
                $output .= $default;
                break;

            case "heading":

                if ($counter >= 2) {
                    $output .= '</div>' . "\n";
                }
                $jquery_click_hook = preg_replace("/[^a-zA-Z0-9._\-]/", "", strtolower($value['name']));
                $jquery_click_hook = "of-option-" . $jquery_click_hook;
                $menu .= '<li><a title="' . $value['name'] . '" href="#' . $jquery_click_hook . '">' . $value['name'] . '</a></li>';
                $output .= '<div class="group" id="' . $jquery_click_hook . '"><h2>' . $value['name'] . '</h2>' . "\n";
                break;
        }

        // if TYPE is an array, formatted into smaller inputs... ie smaller values
        if (is_array($value['type'])) {
            foreach ($value['type'] as $array) {

                $id = $array['id'];
                $std = $array['std'];
                $saved_std = inkthemes_get_option($id);
                if ($saved_std != $std) {
                    $std = $saved_std;
                }
                $meta = $array['meta'];

                if ($array['type'] == 'text') { // Only text at this point
                    $output .= '<input class="input-text-small of-input" name="' . $id . '" id="' . $id . '" type="text" value="' . $std . '" />';
                    $output .= '<span class="meta-two">' . $meta . '</span>';
                }
            }
        }
        if ($value['type'] != "heading") {
            if ($value['type'] != "checkbox") {
                $output .= '<br/>';
            }
            if (!isset($value['desc'])) {
                $explain_value = '';
            } else {
                $explain_value = $value['desc'];
            }
            $output .= '</div><div class="explain">' . $explain_value . '</div>' . "\n";
            $output .= '<div class="clear"> </div></div></div>' . "\n";
        }
    }
    $output .= '</div>';
    return array($output, $menu);
}

/* ----------------------------------------------------------------------------------- */
/* OptionsFramework Uploader - inkthemes_optionsframework_uploader_function */
/* ----------------------------------------------------------------------------------- */

function inkthemes_optionsframework_uploader_function($id, $std, $mod) {
    //$uploader .= '<input type="file" id="attachement_'.$id.'" name="attachement_'.$id.'" class="upload_input"></input>';
    //$uploader .= '<span class="submit"><input name="save" type="submit" value="Upload" class="button upload_save" /></span>';

    $uploader = '';
    $upload = inkthemes_get_option($id);

    if ($mod != 'min') {
        $val = $std;
        if (inkthemes_get_option($id) != "") {
            $val = inkthemes_get_option($id);
        }
        $uploader .= '<input class=\'of-input\' name=\'' . $id . '\' id=\'' . $id . '_upload\' type=\'text\' value=\'' . str_replace("'", "", $val) . '\' readonly />';
    }

    $uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="' . $id . '">' . __('Upload Image', 'videocraft') . '</span>';

    if (!empty($upload)) {
        $hide = '';
    } else {
        $hide = 'hide';
    }

    $uploader .= '<span class="button image_reset_button ' . $hide . '" id="reset_' . $id . '" title="' . $id . '">' . __('Remove', 'videocraft') . '</span>';
    $uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
    $findme = 'wp-content/uploads';
    $imgvideocheck = strpos($upload, $findme);
    if ((!empty($upload)) && ($imgvideocheck === true)) {
        $uploader .= '<a class="of-uploaded-image" href="' . $upload . '">';
        $uploader .= '<img class="of-option-image" id="image_' . $id . '" src="' . $upload . '" alt="" />';
        $uploader .= '</a>';
    }
    $uploader .= '<div class="clear"></div>' . "\n";
    return $uploader;
}
?>

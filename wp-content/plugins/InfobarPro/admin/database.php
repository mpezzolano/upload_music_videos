<?php

// database options
function nb_insert_entry() {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_data";
    $name = $_POST['nb_name'];
    $content = str_replace(array("\n", "\r"), array(" ", ""), trim($_POST['nb_content']));
    $selected_option = $_POST['nb_optionselect'];
    $name_placeholder = $_POST['nb_nameplaceholder'];
    $email_placeholder = $_POST['nb_emailplaceholder'];
    $button_text = $_POST['nb_buttontext'];
    $status = $_POST['nb_status'];
    $begin = isset($_POST['nb_timebegin']) ? $_POST['nb_timebegin'] : NULL;
    $end = isset($_POST['nb_timeend']) ? $_POST['nb_timeend'] : NULL;
    $bgcolor = $_POST['nb_bgcolor'];
    $fontcolor = $_POST['nb_fontcolor'];
    $nottype = $_POST['nb_nottype'];
    if (empty($begin) || empty($end)) {
        $wpdb->insert($table_name, array('status' => 0, 'timecreated' => current_time('mysql', 0), 'name' => $name, 'content' => $content, 'status' => $status, 'bgcolor' => $bgcolor, 'fontcolor' => $fontcolor, 'nottype' => $nottype, 'selected_option' => $selected_option, 'placeholder_name' => $name_placeholder, 'placeholder_email' => $email_placeholder, 'button_text' => $button_text));
    } else {
        $wpdb->insert($table_name, array('status' => 0, 'timecreated' => current_time('mysql', 0), 'name' => $name, 'content' => $content, 'status' => $status, 'epochtimebegin' => (int) strtotime($begin), 'epochtimeend' => (int) strtotime($end), 'bgcolor' => $bgcolor, 'fontcolor' => $fontcolor, 'nottype' => $nottype, 'selected_option' => $selected_option, 'customized_subscription_field' => $subscription_fields));
    }
}

function nb_delete_entry($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_data";
    $wpdb->query('DELETE FROM ' . $table_name . ' WHERE id = ' . $id);
}

function nb_change_status($id, $status) {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_data";
    $wpdb->update($table_name, array('status' => $status), array('id' => $id));
}

function nb_edit_entry($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_data";
    $content = str_replace(array("\n", "\r"), array(" ", ""), trim($_POST['nb_content']));
    $bgcolor = $_POST['nb_bgcolor'];
    $fontcolor = $_POST['nb_fontcolor'];
    $begin = $_POST['nb_timebegin'];
    $end = $_POST['nb_timeend'];
    $status = $_POST['nb_status'];
    $name = $_POST['nb_name'];
    $selected_option = $_POST['nb_optionselect'];
    $name_placeholder = $_POST['nb_nameplaceholder'];
    $email_placeholder = $_POST['nb_emailplaceholder'];
    $button_text = $_POST['nb_buttontext'];
    if (empty($begin) || empty($end)) {
        $sql = 'UPDATE ' . $table_name . ' SET epochtimebegin=NULL, epochtimeend=NULL,status="' . $status . '", name="' . $name . '",content="' . $content . '",selected_option="' . $selected_option . '",placeholder_name="' . $name_placeholder . '",placeholder_email="' . $email_placeholder . '", button_text="' . $button_text . '", bgcolor="' . $bgcolor . '",fontcolor="' . $fontcolor . '" WHERE id="' . $id . '"';
        $wpdb->query($sql);
    } else {
        $wpdb->update($table_name, array('status' => $_POST['nb_status'], 'epochtimebegin' => (int) strtotime($begin), 'epochtimeend' => (int) strtotime($end), 'name' => $_POST['nb_name'], 'content' => $_POST['nb_content'], 'bgcolor' => $bgcolor, 'fontcolor' => $fontcolor, 'nottype' => $_POST['nb_nottype'], 'selected_option' => $selected_option, 'placeholder_name' => $name_placeholder, 'placeholder_email' => $email_placeholder, 'button_text' => $button_text), array('id' => $id));
    }
}

function nb_insert_nottype() {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_nottypes";
    $icon = $_POST['nb_noticon'];
    $name = $_POST['nb_notname'];
    $bgcolor = $_POST['nb_notbgcolor'];
    $fontcolor = $_POST['nb_notfontcolor'];
    $noturl = $_POST['nb_noturl'];
    $size = $_POST['nb_notsize'];
    $wpdb->insert($table_name, array('size' => $size, 'name' => $name, 'icon' => $icon, 'bgcolor' => $bgcolor, 'fontcolor' => $fontcolor, 'url' => $noturl));
}

function nb_edit_nottype($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_nottypes";
    $wpdb->update($table_name, array('size' => $_POST['nb_notsize'], 'name' => $_POST['nb_notname'], 'icon' => $_POST['nb_noticon'], 'bgcolor' => $_POST['nb_notbgcolor'], 'fontcolor' => $_POST['nb_notfontcolor'], 'url' => $_POST['nb_noturl']), array('id' => $id));
}

function nb_delete_nottype($id) {
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_nottypes";
    $wpdb->query('DELETE FROM ' . $table_name . ' WHERE id = ' . $id);
}

// end database options
?>
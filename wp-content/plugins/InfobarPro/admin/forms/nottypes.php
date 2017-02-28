<?php

function nb_sub_notificationtypes() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'infobar'));
    }
    echo '<div id="icon-edit-pages" class="icon32"></div><h2>' . __('Notification types', 'infobar');
    if (isset($_REQUEST['edit'])) {
        echo ' <a class="button-secondary" href="admin.php?page=pd_sub_nottypes" title="' . __('New entry', 'infobar') . '">' . __('New entry', 'infobar') . '</a></h2>';
    } else {
        echo '</h2>';
    }
    $msg = '';
    if (!empty($_POST) && check_admin_referer('nb_submit', 'nb_nonce')) {
        if ($_POST['notbar_hidden_post'] == 'Y') {
            if ($_POST['notbar_hidden_edit'] == 'Y') {
                // entry has been edited, only update the existing entry
                nb_edit_nottype($_POST['nb_notid']);
                if (function_exists('w3tc_pgcache_flush')) {
                    w3tc_pgcache_flush();
                    $msg .= __(' &amp; W3 Total Cache Page Cache flushed', 'infobar');
                }
                echo '<div id="message" class="updated"><p>' . __('Updated:', 'infobar') . ' ' . $_POST['nb_notname'] . $msg . '</p></div>';
            } else {
                nb_insert_nottype();
                if (function_exists('w3tc_pgcache_flush')) {
                    w3tc_pgcache_flush();
                    $msg .= __(' &amp; W3 Total Cache Page Cache flushed', 'infobar');
                }
                echo '<div id="message" class="updated"><p>' . __('Saved:', 'infobar') . ' ' . $_POST['nb_notname'] . $msg . '</p></div>';
            }
        }
    }
    if (isset($_REQUEST['delete'])) {
        nb_delete_nottype($_REQUEST['id']);
        if (function_exists('w3tc_pgcache_flush')) {
            w3tc_pgcache_flush();
            $msg .= __(' &amp; W3 Total Cache Page Cache flushed', 'infobar');
        }
        echo '<div id="message" class="updated"><p>' . __('Deleted:', 'infobar') . ' ' . $_REQUEST['id'] . $msg . '</p></div>';
    }
    global $wpdb;
    $table_name = $wpdb->prefix . "nb_nottypes";
    $myrows = $wpdb->get_results("SELECT * FROM " . $table_name . ' ORDER BY id');
    echo '<div class="postbox-container" style="width:70%;">
		<div class="metabox-holder">	
			<div class="meta-box-sortables ui-sortable">
				<div id="nottype-entries" class="postbox">
					<div class="handlediv" title="Click to toggle">
						<br>
					</div>
					<h3 class="hndle">
						<span>' . __('Entries', 'infobar') . '</span>
					</h3>
					<div class="inside">
					<table id="pd-nb-table" class="widefat" cellspacing="0">
		            <thead><tr class="thead">
		            <th style="width: 35px;">ID</th>
        		    <th style="width: 50px;">' . __('Icon', 'infobar') . '</th>
				    <th style="width: 150px;">' . __('Name', 'infobar') . '</th>
					<th style="width: 50px;">' . __('Background color', 'infobar') . '</th>
		            <th style="width: 50px;">' . __('Font color', 'infobar') . '</th>
					 <th style="width: 50px;">' . __('Edit', 'infobar') . '</th>
					</tr></thead>
					<tfoot><tr class="tfoot">
		            <th style="width: 35px;">ID</th>
	    			<th style="width: 50px;">' . __('Icon', 'infobar') . '</th>
		            <th style="width: 150px;">' . __('Name', 'infobar') . '</th>
        		    <th style="width: 50px;">' . __('Background color', 'infobar') . '</th>
		            <th style="width: 50px;">' . __('Font color', 'infobar') . '</th>
					 <th style="width: 50px;">' . __('Edit', 'infobar') . '</th>
        		    </tr></tfoot>';
    foreach ($myrows as $myrows) {
        if (empty($myrows->bgcolor)) {
            $bgcolor = __('Not set', 'infobar');
            $bgcolorpreview = "";
        } else {
            $bgcolor = $myrows->bgcolor;
            $bgcolorpreview = $bgcolor;
        }
        if (empty($myrows->fontcolor)) {
            $fontcolor = __('Not set', 'infobar');
            $fontcolorpreview = "";
        } else {
            $fontcolor = $myrows->fontcolor;
            $fontcolorpreview = $fontcolor;
        }
        if (empty($myrows->icon)) {
            $icon = '<b>' . __('No icon', 'infobar') . '</b>';
        } else {
            $icon = '<img src="' . $myrows->icon . '">';
        }
        $deletelink = 'admin.php?page=pd_sub_nottypes&amp;delete&amp;id=' . $myrows->id;
        $editlink = 'admin.php?page=pd_sub_nottypes&amp;edit&amp;id=' . $myrows->id;
        echo '<tr><td><a href="' . $deletelink . '"><img src="' . NB_URL . '../../css/images/admin/delete.png"></a>' . $myrows->id . '</td><td>' . $icon . '</td><td><a href="' . $editlink . '">' . $myrows->name . '</a></td><td style="background-color:' . $bgcolorpreview . ';color:' . $fontcolorpreview . ';">' . $bgcolor . '</td><td style="background-color:' . $bgcolorpreview . ';color:' . $fontcolorpreview . ';">' . $fontcolor . '</td><td><a href="' . $editlink . '"> <img src="' . NB_URL . '../../css/images/admin/edit.png"> </a></td></tr>';
    }
    echo '</table></div></div>';
    $noticonvalue = '';
    $notnamevalue = '';
    $notbgcolorvalue = '';
    $notfontcolorvalue = '';
    $notsizevalue = '';
    $noturlvalue = '';
    $edithidden = 'N';
    $idhidden = '';
    // check if we are in edit mode
    if (isset($_REQUEST['edit'])) {
        $table_name = $wpdb->prefix . "nb_nottypes";
        $editrow = $wpdb->get_results("SELECT * FROM " . $table_name . ' WHERE id = ' . $_REQUEST['id']);
        foreach ($editrow as $editrow) {
            $noticonvalue = $editrow->icon;
            $noturlvalue = $editrow->url;
            $notnamevalue = $editrow->name;
            $notbgcolorvalue = $editrow->bgcolor;
            $edithidden = "Y";
            $idhidden = $editrow->id;
            $notfontcolorvalue = $editrow->fontcolor;
            $notsizevalue = $editrow->size;
        }
    }
    echo '<div id="nottype-entry" class="postbox">
					<div class="handlediv" title="Click to toggle">
						<br>
					</div>
					<h3 class="hndle">
						<span>' . __('New / edit entry', 'infobar') . '</span>
					</h3>
					<div class="inside">
					<form method="POST" action="admin.php?page=pd_sub_nottypes">
        <input type="hidden" name="notbar_hidden_post" value="Y">
        <input type="hidden" name="notbar_hidden_edit" value="' . $edithidden . '">
        <input type="hidden" name="nb_notid" value="' . $idhidden . '">';
    wp_nonce_field('nb_submit', 'nb_nonce');
    nb_createinput('text', array(
        'id' => 'nb_noticon',
        'name' => 'nb_noticon',
        'label' => __('Icon path', 'infobar'),
        'desc' => __('If you leave this empty, no icon will be displayed in the info bar', 'infobar'),
        'sel' => $noticonvalue,
        'size' => 30
    ));
    echo '<br class="clear">';
    nb_createinput('text', array(
        'id' => 'nb_noturl',
        'name' => 'nb_noturl',
        'label' => __('URL', 'infobar'),
        'desc' => __('Makes the image clickable, linking to this URL', 'infobar'),
        'sel' => $noturlvalue,
        'size' => 30
    ));
    echo '<br class="clear">';
    nb_createinput('text', array(
        'id' => 'nb_notname',
        'name' => 'nb_notname',
        'label' => __('Notification name', 'infobar'),
        'desc' => __('This text will be displayed as announcement message', 'infobar'),
        'sel' => $notnamevalue,
        'size' => 30
    ));
    echo '<br class="clear">';
    nb_createinput('smalltext', array(
        'id' => 'nb_notsize',
        'name' => 'nb_notsize',
        'label' => __('Notification size', 'infobar'),
        'sel' => $notsizevalue,
        'size' => 20
    ));
    echo '<br class="clear">';
    nb_createinput('color', array(
        'id' => 'nb_notbgcolor',
        'name' => 'nb_notbgcolor',
        'label' => __('Background color', 'infobar'),
        'sel' => $notbgcolorvalue,
        'size' => 20
    ));
    echo '<br class="clear">';
    nb_createinput('color', array(
        'id' => 'nb_notfontcolor',
        'name' => 'nb_notfontcolor',
        'label' => __('Font color', 'infobar'),
        'sel' => $notfontcolorvalue,
        'size' => 20
    ));
    echo '<br class="clear">
        <p class="submit">
        <input type="submit" name="Submit" value="' . __('Save', 'infobar') . '" />
        </p></form>					</div>
				</div>
			</div>
		</div>
	</div>';
    echo nb_get_info_box();
}

?>
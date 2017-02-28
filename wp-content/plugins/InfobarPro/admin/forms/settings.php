<?php

function nb_sub_settings() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'infobar'));
    }
    if (isset($_REQUEST['versioncheck']) == true) {
        update_option('pd_nb_installnotification', NB_VERSION);
        nb_redirect(wp_get_referer());
    }
    if (isset($_REQUEST['betacheck']) == true) {
        update_option('pd_nb_betanotification', NB_VERSION);
        nb_redirect(wp_get_referer());
    }
    echo '<div id="icon-options-general" class="icon32"></div><h2>' . __('Notifications settings', 'infobar') . '</h2>';
    echo '<form method="POST" action="options.php">';
    settings_fields('pd_nb_settings');
    echo '<div class="metabox-holder"><div class = "postbox">
        <div class="handlediv" title="Click to toggle"><br></div>
        <h3 class="hndle"><span>' . __('Settings', 'infobar') . '</span></h3>
        <div class="inside">
        <table class="form-table">
        <tbody>';
    echo '
	<tr><th><label for="pd_nb_bartype">' . __('Bar type:', 'infobar') . '</label></th>
	<td><select name="pd_nb_bartype">
	<option value="fixed"' . selected('fixed', get_option('pd_nb_bartype', 'fixed'), false) . '>' . __('Fixed', 'infobar') . '</option>
	<option value="inline"' . selected('inline', get_option('pd_nb_bartype', 'fixed'), false) . '>' . __('Inline', 'infobar') . '</option>
	</select><small> ' . __('Inline = scrolls with the page, Fixed = stays on top of the screen also when scrolling the page', 'infobar') . '</small>
	</td></tr>
        <tr><th><label for="pd_nb_inserttype">' . __('Insert type:', 'infobar') . '</label></th>
        <td><select name="pd_nb_inserttype">
	<option value="widget"' . selected('widget', get_option('pd_nb_inserttype', 'header'), false) . '>' . __('Widget', 'infobar') . '</option>
        <option value="header"' . selected('header', get_option('pd_nb_inserttype', 'header'), false) . '>' . __('Header', 'infobar') . '</option>
        </select><small> ' . __('Widget = you need to insert the widget, Header = Inserts the info bar automaticly on all pages / posts', 'infobar') . '</small>
        </td></tr>
	 <tr><th><label for="pd_nb_easingtype">' . __('Easing type:', 'infobar') . '</label></th>        <td><select name="pd_nb_easingtype">
        <option value="swing"' . selected('swing', get_option('pd_nb_easingtype', 'swing'), false) . '>' . __('Swing', 'infobar') . '</option>
        <option value="linear"' . selected('linear', get_option('pd_nb_easingtype', 'swing'), false) . '>' . __('Linear', 'infobar') . '</option>
        </select>
        </td></tr>
	<tr><th><label for="pd_nb_bartext">' . __('Bar announcement text:', 'infobar') . '</label></th>
        <td><input type="text" size="10" id="pd_nb_bartext" name="pd_nb_bartext" value="' . get_option('pd_nb_bartext', 'IMPORTANT!') . '"><small> ' . __('The message here will be static on the LEFT of the Info bar.', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_bartextsize">' . __('Bar announcement text size:', 'infobar') . '</label></th>
        <td><input type="text" size="3" id="pd_nb_bartextsize" name="pd_nb_bartextsize" value="' . get_option('pd_nb_bartextsize', '16') . '">
        </td></tr>
	<tr><th><label for="pd_nb_displaytime">' . __('Display time:', 'infobar') . '</label></th>
	<td><input type="text" size="6" id="pd_nb_displaytime" name="pd_nb_displaytime" value="' . get_option('pd_nb_displaytime', '5000') . '"><small> ' . __('Display in milliseconds (for ex: 2000 = 2 seconds)', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_barheight">' . __('Bar height:', 'infobar') . '</label></th>
        <td><input type="text" size="6" id="pd_nb_barheight" name="pd_nb_barheight" value="' . get_option('pd_nb_barheight', '45') . '"><small> ' . __('Height of the bar in pixels', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_buttonheight">' . __('Button height:', 'infobar') . '</label></th>
        <td><input type="text" size="6" id="pd_nb_buttonheight" name="pd_nb_buttonheight" value="' . get_option('pd_nb_buttonheight', '40') . '"><small> ' . __('Height of the button in pixels (button is visible when the bar is colapsed)', 'infobar') . '</small>
	</td></tr>
	<tr><th><label for="pd_nb_displaytype">' . __('Display type:', 'infobar') . '</label></th>
        <td>
	<select name="pd_nb_displaytype">
        <option value="delayed"' . selected('delayed', get_option('pd_nb_displaytype', 'delayed'), false) . '>' . __('Delayed', 'infobar') . '</option>
	<option value="expanded"' . selected('expanded', get_option('pd_nb_displaytype', 'delayed'), false) . '>' . __('Expanded', 'infobar') . '</option>
	<option value="collapsed"' . selected('collapsed', get_option('pd_nb_displaytype', 'delayed'), false) . '>' . __('Collapsed', 'infobar') . '</option>
	<option value="onscroll"' . selected('onscroll', get_option('pd_nb_displaytype', 'delayed'), false) . '>' . __('On Scroll', 'infobar') . '</option>
        </select><small> ' . __('The options delayed & on scroll, depend on the Display delay settings', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_displaydelay">' . __('Display delay:', 'infobar') . '</label></th>
        <td><input type="text" size="6" id="pd_nb_displaydelay" name="pd_nb_displaydelay" value="' . get_option('pd_nb_displaydelay', '2000') . '"><small> ' . __('When the site is visited the bar is colapsed by default, it will be expanded after this delay (in milliseconds)', 'infobar') . '</small>
	</td></tr>
        <tr><th><label for="pd_nb_displayspeed">' . __('Display speed:', 'infobar') . '</label></th>
        <td>
        <select name="pd_nb_displayspeed">
        <option value="10"' . selected('10', get_option('pd_nb_displayspeed', '50'), false) . '>' . __('Extreme slow', 'infobar') . '</option>
	<option value="25"' . selected('25', get_option('pd_nb_displayspeed', '50'), false) . '>' . __('Slow', 'infobar') . '</option>
        <option value="50"' . selected('50', get_option('pd_nb_displayspeed', '50'), false) . '>' . __('Normal', 'infobar') . '</option>
        <option value="75"' . selected('75', get_option('pd_nb_displayspeed', '50'), false) . '>' . __('Fast', 'infobar') . '</option>
	<option value="100"' . selected('100', get_option('pd_nb_displayspeed', '50'), false) . '>' . __('Extreme fast', 'infobar') . '</option>
        </select><small> ' . __('The speed of scrolling when a message is too long to display', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_cookie">' . __('Enable cookie:', 'infobar') . '</label></th>
        <td><select name="pd_nb_cookie">
        <option value="true"' . selected('true', get_option('pd_nb_cookie', 'false'), false) . '>' . __('Enabled', 'infobar') . '</option>
        <option value="false"' . selected('false', get_option('pd_nb_cookie', 'false'), false) . '>' . __('Disabled', 'infobar') . '</option>
        </select><small> ' . __('When enabled, the colapsed or expanded position of the bar will be saved in a cookie, for future visits', 'infobar') . '</small>
        </td></tr>
        <tr><th><label for="pd_nb_cookiehash">' . __('New message new Cookie:', 'infobar') . '</label></th>
        <td><select name="pd_nb_cookiehash">
        <option value="true"' . selected('true', get_option('pd_nb_cookiehash', 'true'), false) . '>' . __('Enabled', 'infobar') . '</option>
        <option value="false"' . selected('false', get_option('pd_nb_cookiehash', 'true'), false) . '>' . __('Disabled', 'infobar') . '</option>
        </select><small> ' . __('If a new notification is scheduled to display, the cookie will be refreshed and all saved states will be ignored. (basicly this means: if anything changes in the set of messages which need to being displayed or you create a new message, the info bar will be expanded by default again, and the new notification will be visible to the user)', 'infobar') . '</small>
        </td></tr>
	 <tr><th><label for="pd_nb_cookieexpire">' . __('Cookie expire time:', 'infobar') . '</label></th>
        <td><input type="text" size="6" id="pd_nb_cookieexpire" name="pd_nb_cookieexpire" value="' . get_option('pd_nb_cookieexpire', '1') . '"><small> ' . __('Cookie expire time in days. If the cookie expires, the user saved states will be ignored (The Info bar will be auto expanded then!)', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_fontsize">' . __('Font size:', 'infobar') . '</label></th>
        <td><input type="text" size="6" id="pd_nb_fontsize" name="pd_nb_fontsize" value="' . get_option('pd_nb_fontsize', '10') . '">
        </td></tr>
	<tr><th><label for="pd_nb_buttonposition">' . __('Close / Open button position:', 'infobar') . '</label></th>
        <td><select name="pd_nb_buttonposition">
	<option value="left"' . selected('left', get_option('pd_nb_buttonposition', 'left'), false) . '>' . __('Left', 'infobar') . '</option>
	<option value="right"' . selected('right', get_option('pd_nb_buttonposition', 'left'), false) . '>' . __('Right', 'infobar') . '</option>
	</select>
        </td></tr>
	<tr><th><label for="pd_nb_roles">' . __('Roles for notifications:', 'infobar') . '</label></th>
        <td>';
    $roles = get_option('pd_nb_roles');
    foreach (nb_get_roles() as $roletmp) {
        $roletmp = explode("|", $roletmp);
        $role = $roletmp[0];
        if (isset($roles[strtolower($role)])) {
            $checked_roles = $roles[strtolower($role)];
        } else {
            $checked_roles = '';
        }
        if (strtolower($role) == nb_get_currentrole()) {
            echo '<input type="checkbox" name="pd_nb_roles[' . strtolower($role) . ']" value="true" ' . checked($checked_roles, 'true', false) . ' disabled> ' . $role . '<br />';
            echo '<input type="hidden" name="pd_nb_roles[' . strtolower($role) . ']" value="true">';
        } else {
            echo '<input type="checkbox" name="pd_nb_roles[' . strtolower($role) . ']" value="true" ' . checked($checked_roles, 'true', false) . ' > ' . $role . '<br />';
        }
    }
    echo '<small> ' . __('The roles selected here, can create/edit/delete notifications. No roles selected gives access to administrator only', 'infobar') . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_showversion">' . __('Show version numbering in HTML source:', 'infobar') . '</label></th>
        <td><select name="pd_nb_showversion">
        <option value="true"' . selected('true', get_option('pd_nb_showversion', 'true'), false) . '>' . __('Enabled', 'infobar') . '</option>
        <option value="false"' . selected('false', get_option('pd_nb_showversion', 'true'), false) . '>' . __('Disabled', 'infobar') . '</option>
        </select><small> ' . sprintf(__('(Shows the versionnumber of the Info Bar (%s) in the HTML source code)', 'infobar'), NB_VERSION) . '</small>
        </td></tr>
	<tr><th><label for="pd_nb_debug">' . __('Debug:', 'infobar') . '</label></th>
        <td><select name="pd_nb_debug">
        <option value="true"' . selected('true', get_option('pd_nb_debug', 'false'), false) . '>' . __('Enabled', 'infobar') . '</option>
        <option value="false"' . selected('false', get_option('pd_nb_debug', 'false'), false) . '>' . __('Disabled', 'infobar') . '</option>
        </select><small> ' . __('Only enable when developers instruct you to do, this will speed up things when fixes are needed :)', 'infobar') . '</small>
        </td></tr>
        </tbody></table>
        <p class="submit">
        <input type="submit" name="Submit" value="' . __('Save', 'infobar') . '" />
        </p></form></div></div>';
}

?>
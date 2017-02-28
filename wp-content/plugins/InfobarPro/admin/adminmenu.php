<?php

function nb_init_admin_menu() {
    if (nb_check_access()) {
        add_menu_page(
                __('Info Bar', 'infobar'), __('Info Bar', 'infobar'), 'edit_posts', 'pd_nb_entries', 'nb_sub_entries', plugins_url('../css/images/admin/wp_admin_menu_icon.png', __FILE__)
        );
        $entriespage = add_submenu_page(
                'pd_nb_entries', __('Notification entries', 'infobar'), __('Notification entries', 'infobar'), 'edit_posts', 'pd_nb_entries', 'nb_sub_entries'
        );
        add_action('admin_print_styles-' . $entriespage, 'nb_admin_styles');
    }
    $notificationtypespage = add_submenu_page(
            'pd_nb_entries', __('Notification types', 'infobar'), __('Notification types', 'infobar'), 'manage_options', 'pd_sub_nottypes', 'nb_sub_notificationtypes'
    );
    add_action('admin_print_styles-' . $notificationtypespage, 'nb_admin_styles');
    $mailchimpsetting = add_submenu_page(
            'pd_nb_entries', __('mailsettings', 'infobar'), __('Mailing List', 'infobar'), 'manage_options', 'pd_sub_mailsettings', 'nb_sub_mailsettings'
    );
    add_action('admin_print_styles-' . $mailchimpsetting, 'nb_admin_styles');
    $settingspage = add_submenu_page(
            'pd_nb_entries', __('Settings', 'infobar'), __('Settings', 'infobar'), 'manage_options', 'pd_sub_settings', 'nb_sub_settings'
    );
    $subscriberpage = add_submenu_page(
            'pd_nb_entries', __('subscriberlist', 'infobar'), __('Subscriber List', 'infobar'), 'manage_options', 'pd_sub_subscriberlist', 'nb_sub_subscriberlist'
    );
    add_action('admin_print_styles-' . $subscriberpage, 'nb_admin_styles');
}

?>
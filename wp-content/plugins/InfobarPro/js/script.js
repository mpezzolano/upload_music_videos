jQuery(document).ready(function () {
    //alert('hdhd');
    jQuery('input.infobar_entries').click(function (e) {
        var infobar_name = jQuery('div.inside').find('input[name="nb_name"]').val();
        var infobar_content = jQuery('div.inside').find('textarea[name="nb_content"]').val();
        if (infobar_name == "" || infobar_content == "") {
            if (infobar_name == "") {
                jQuery('input#nb_name').css({
                    "border": "1px solid red"
                });
                e.preventDefault();
            }
            if (infobar_content == "") {
                jQuery('textarea#nb_content').css({
                    "border": "1px solid red"
                });
                e.preventDefault();
            }
        }
    });

    jQuery('input[name=nb_optionselect]').click(function () {
        var radio_value = jQuery('input[name=nb_optionselect]:checked').val();
        if (radio_value == '2') {
            jQuery('.obtain_division').css("display", "block");
        }
        else {
            jQuery('.obtain_division').css("display", "none");
        }
    });

    //tab initalize
    jQuery('.group').hide();
    jQuery('.group:first').fadeIn();
    jQuery('#of-nav li:first').addClass('current');
    jQuery('#of-nav li a').click(function (evt) {
        jQuery('#of-nav li').removeClass('current');
        jQuery(this).parent().addClass('current');
        var clicked_group = jQuery(this).attr('href');
        jQuery('.group').hide();
        jQuery(clicked_group).fadeIn();
        evt.preventDefault();
    });

    //mailing list
    jQuery('.mc_getlist').click(function () {
        jQuery('.mailing-ajax-loading').show();
        var mc_apikey = jQuery('#mc_apikey').val();
        //alert(mc_apikey);  
        var data = {
            action: 'appeal_acknowledgement',
            apikey_mc: mc_apikey,
            service_in_use: 'mc'
        };

        jQuery.post(script_call.ajaxurl, data, function (acknowledgment) {
            if (acknowledgment) {
                jQuery('.mailing-ajax-loading').hide();
                jQuery('#info_mailservice').val('mailchimp');
                jQuery('.mc_mailing_list').html(acknowledgment);
            }
            else {
                jQuery('.mailing-ajax-loading').hide();
                alert('error');
            }
        });

    });

    jQuery('.ic_getlist').click(function () {
        jQuery('.mailing-ajax-loading').show();
        var ic_password = jQuery('#ic_password').val();
        var ic_username = jQuery('#ic_username').val();
        var ic_apikey = jQuery('#ic_apikey').val();

        var data = {
            action: 'appeal_acknowledgement',
            password_ic: ic_password,
            username_ic: ic_username,
            apikey_ic: ic_apikey,
            service_in_use: 'ic'
        }
        jQuery.post(script_call.ajaxurl, data, function (acknowledgment) {
            if (acknowledgment) {
                jQuery('.mailing-ajax-loading').hide();

                jQuery('.ic_mailing_list').html(acknowledgment);
            }
            else {
                jQuery('.mailing-ajax-loading').hide();
                alert('error');
            }
        });

    });

    jQuery('.gr_getlist').click(function () {
        jQuery('.mailing-ajax-loading').show();
        var gr_apikey = jQuery('#gr_apikey').val();
        var data = {
            action: 'appeal_acknowledgement',
            apikey_gr: gr_apikey,
            service_in_use: 'gr'
        }
        jQuery.post(script_call.ajaxurl, data, function (acknowledgment) {
            if (acknowledgment) {
                jQuery('.mailing-ajax-loading').hide();
                jQuery('.gr_mailing_list').html(acknowledgment);
            }
            else {
                jQuery('.mailing-ajax-loading').hide();
                alert('error');
            }
        });
    });

    jQuery('.cm_getlist').click(function () {
        jQuery('.mailing-ajax-loading').show();
        var cm_clientid = jQuery('#cm_clientid').val();
        var cm_apikey = jQuery('#cm_apikey').val();

        var data = {
            action: 'appeal_acknowledgement',
            clientid_cm: cm_clientid,
            apikey_cm: cm_apikey,
            service_in_use: 'cm'
        }
        jQuery.post(script_call.ajaxurl, data, function (acknowledgment) {
            if (acknowledgment) {
                jQuery('.mailing-ajax-loading').hide();
                jQuery('.cm_mailing_list').html(acknowledgment);
            }
            else {
                jQuery('.mailing-ajax-loading').hide();
                alert('error');
            }
        });
    });

    jQuery('.cc_getlist').click(function () {
        jQuery('.mailing-ajax-loading').show();
        var cc_username = jQuery('#cc_username').val();
        var cc_password = jQuery('#cc_password').val();

        var data = {
            action: 'appeal_acknowledgement',
            username_cc: cc_username,
            password_cc: cc_password,
            service_in_use: 'cc'
        }
        jQuery.post(script_call.ajaxurl, data, function (acknowledgement) {
            if (acknowledgement) {
                jQuery('.mailing-ajax-loading').hide();
                jQuery('.cc_mailing_list').html(acknowledgement);
            }
            else {
                jQuery('.mailing-ajax-loading').hide();
                alert('error');
            }
        });

    });

    jQuery('.aw_getlist').click(function () {
        jQuery('.mailing-ajax-loading').show();
        var secret_token = jQuery('#aw_tokensecret').val();
        var access_token = jQuery('#aw_accesstoken').val();
        //alert(secret_token);
        //alert(access_token);
        var data = {
            action: 'appeal_acknowledgement',
            aw_secret_token: secret_token,
            aw_access_token: access_token,
            service_in_use: 'aw'
        }
        jQuery.post(script_call.ajaxurl, data, function (acknowledgement) {
            if (acknowledgement) {
                alert(acknowledgement);
                jQuery('.mailing-ajax-loading').hide();
                jQuery('.aw_mailing_list').html(acknowledgement);
            }
            else {
                jQuery('.mailing-ajax-loading').hide();
                alert('error');
            }
        });
    });

});
<?php
$mailing_service = get_option('mailing_service_in_use');
if(!empty($mailing_service)){
    if ($mailing_service == 'mc'){
        require_once 'admin/forms/api/mailchimp/mc_subscribe.php';
    }
    if($mailing_service == 'ic'){
        require_once 'admin/forms/api/iContact/subscribe.php';
    }
     if($mailing_service == 'gr'){
        require_once 'admin/forms/api/getresponse/subscribe.php';
    }
    if($mailing_service == 'cm'){
        require_once 'admin/forms/api/campaignmonitor/subscribe.php';
    }
     if($mailing_service == 'cc'){
        require_once 'admin/forms/api/constant_contact/subscribe.php';        
    }
     if($mailing_service == 'aw'){
        require_once 'admin/forms/api/aweber/subscribe.php';        
    }
    if($mailing_service == 'email'){
        require_once 'admin/forms/api/direct_email.php'; 
    }   
}
?>
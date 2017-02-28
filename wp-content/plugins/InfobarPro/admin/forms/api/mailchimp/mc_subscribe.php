<?php
/**
This Example shows how to Subscribe a New Member to a List using the MCAPI.php 
class and do some basic error checking.
**/
require_once 'MCAPI.class.php';
 $value =  get_option('bar_service_database');
 $apikey = base64_decode($value['mc_apikey']);
 $api = new MCAPI($apikey);
$email= $email_of_subscriber;
$name= $name_of_subscriber;

$merge_vars = array('FNAME' => $name);
if($api->listSubscribe($list_id, $email,$merge_vars) === true) {
	echo 'Thank you for subscribing to our mailing list';
}
?>
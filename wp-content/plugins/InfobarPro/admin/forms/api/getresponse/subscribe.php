<?php
require_once 'jsonRPCClient.php';
$value =  get_option('bar_service_database');
$apikey = base64_decode($value['gr_apikey']);
$apiurl = 'http://api2.getresponse.com';
$client = new jsonRPCClient($apiurl);
$result = NULL;

try {
	$result = $client->add_contact(
		$apikey,
		    array (
		        'campaign' => $list_id,
		        'name' => $name_of_subscriber,
		        'email' => $email_of_subscriber,
		        'cycle_day' => '0'
		    )
	);
	echo 'Thank you for subscribing to our mailing list';
}
catch (Exception $e) {

    echo $e->getMessage();
}

?>
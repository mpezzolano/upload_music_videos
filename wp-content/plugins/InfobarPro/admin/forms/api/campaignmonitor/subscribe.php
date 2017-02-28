<?php
	error_reporting(0);
	require_once ('csrest_subscribers.php');
        $value =  get_option('bar_service_database');
	$apikey = base64_decode($value['cm_apikey']);
	
	$wrap = new CS_REST_Subscribers($list_id, $apikey);
	$result = $wrap->add(array(
		    'EmailAddress' => $email_of_subscriber,
		    'Name' => $name_of_subscriber
	));
	

	if($result->was_successful()) {
	    echo "Thank you for subscribing to our mailing list";
	}else {
	    echo 'Failed with code '.$result->http_status_code."\n<br /><pre>";
	    var_dump($result->response);
	}

?>
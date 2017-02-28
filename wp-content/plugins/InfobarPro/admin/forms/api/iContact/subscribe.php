<?php
require_once( 'icontact.php' );

 $value =  get_option('bar_service_database');
$user_name = base64_decode($value['ic_username']);
$password = base64_decode($value['ic_password']);
$apikey = base64_decode($value['ic_apikey']);
$icontact = new Icontact('https://app.icontact.com/icp', $user_name, $password, $apikey);
 
try {
	$account_id = $icontact->LookUpAccountId();
	$client_folder_id = $icontact->LookUpClientFolderId();
           
	$contact_id = $icontact->AddContact( array(
		'firstName' => $name_of_subscriber,
		'email' => $email_of_subscriber,
	));
        	
	$ret = $icontact->SubscribeContactToList($contact_id, $list_id);
	echo 'Thank you for subscribing to our mailing list';
} catch ( IcontactException $ex ) {	
	 $ex->GetErrorData();
}
?>
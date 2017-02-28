<?php
include_once('ctctsupport-ctct_php_library/ConstantContact.php');
 $value =  get_option('bar_service_database');
$username = base64_decode($value['cc_username']);
$password = base64_decode($value['cc_password']);
$apikey = '515faf7a-6f1a-4421-bf6f-17d32db7c33b';
$ConstantContact = new ConstantContact('basic', $apikey, $username, $password);
$search = $ConstantContact->searchContactsByEmail($email_of_subscriber);

//if($search == false){
try{
    $Contact = new Contact();
    $Contact->emailAddress = $email_of_subscriber;
    $Contact->firstName = $name_of_subscriber;
    $contactList = $list_id;
    $Contact->lists = (!is_array($contactList)) ? array($contactList) : $contactList;


    $NewContact = $ConstantContact->addContact($Contact);
    if($NewContact){
        echo "Thank you for subscribing to our mailing list";
    }
}
catch ( IcontactException $ex ) {	
	 $ex->GetErrorData();
}
//} else {
    echo "Contact already exist.";
//}

?>
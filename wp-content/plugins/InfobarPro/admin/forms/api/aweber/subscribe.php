<?php
$value = get_option('bar_service_database');
$aw_access_token = base64_decode($value['aw_access_token']);
$aw_secret_token = base64_decode($value['aw_secret_token']);
require_once('aweber_api.php');
// Replace with the keys of your application
// NEVER SHARE OR DISTRIBUTE YOUR APPLICATIONS'S KEYS!
$consumerKey = "AkrKSYMkyxSzH5tfpU282XJI";
$consumerSecret = "LtLq9Pilg62ytgv0LYf6U0W6zAiWHujclMJIP80J";
$aweber = new AWeberAPI($consumerKey, $consumerSecret);
$account = $aweber->getAccount($aw_access_token, $aw_secret_token);
$account_id = $account->id;

try {
    $listURL = "/accounts/{$account_id}/lists/{$list_id}";
    $list = $account->loadFromUrl($listURL);
    # create a subscriber
    $params = array(
        'email' => $email_of_subscriber,
        'name' => $name_of_subscriber,
    );
    $subscribers = $list->subscribers;
    $new_subscriber = $subscribers->create($params);    
    echo "success";
} 
catch (Exception $exc) {
    print $exc->message;
       
}
?>
<?php
$output='';
$token = $aw_access_token;
$tokensec = $aw_secret_token;

if($token && $tokensec){
require_once('aweber_api.php');
// Replace with the keys of your application
// NEVER SHARE OR DISTRIBUTE YOUR APPLICATIONS'S KEYS!
$consumerKey    = "AkrKSYMkyxSzH5tfpU282XJI";
$consumerSecret = "LtLq9Pilg62ytgv0LYf6U0W6zAiWHujclMJIP80J";
$aweber = new AWeberAPI($consumerKey, $consumerSecret);

//$account = $aweber->getAccount($_COOKIE['accessToken'], $_COOKIE['accessTokenSecret']);
$account = $aweber->getAccount($token, $tokensec);
$output .= '<span class="mailing-list-small">Your Aweber Mailing Lists</span><select name="listsid" id="mc_lists" class="mailing_lists">';
foreach($account->lists as $offset => $list) {
		$output.= '<option name="mc_'.$list->data['name'].'" value="'.$list->data['id'].'">'.$list->data['name'].'</option>';
}
$output.= '</select>';
}else{
	$output.='<div class="error fade">';
	$output.='Please connect to Aweber using the button above before syncing your Mailing Lists.';
	$output.='</div>';
	}
echo $output;	
?>
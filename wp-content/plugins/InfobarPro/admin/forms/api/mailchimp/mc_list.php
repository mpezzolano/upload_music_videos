<?php
/**
This Example shows how to pull the Members of a List using the MCAPI.php 
class and do some basic error checking.
**/
require_once 'MCAPI.class.php';
$api = new MCAPI($mc_apikey);
$retval = $api->lists();
$output = '';
if ($api->errorCode){
	$output.='<div class="error fade">';
	$output.= "Unable to load lists()! <br>";
	$output.= "\n\tError Code=".$api->errorCode;
	$output.= "<br>\n\tMessage=".$api->errorMessage."\n";
	$output.='</div>';
}
else {
$output.= '<span class="mailing-list-small">Your MailChimp Mailing Lists</span><select name="listsid" class="mailing_lists" id="mc_lists">';
		foreach ($retval['data'] as $list){
			$output.= '<option name="mc_'.$list['name'].'" value="'.$list['id'].'">'.$list['name'].'</option>';
		}
		$output.= '</select>';
}
echo $output;

?>
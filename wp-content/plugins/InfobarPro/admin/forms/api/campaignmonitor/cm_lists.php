<?php
error_reporting(0);
$output='';
if(!empty($cm_clientid) && !empty($cm_apikey)){
$output= '<div class="error fade">Please enter all your details into the inputs above and please double check that they are correct.</div>';

require_once 'csrest_clients.php';

$wrap = new CS_REST_Clients($cm_clientid, $cm_apikey);
$result = $wrap->get_lists();
if($result){
$output = '<span class="mailing-list-small">Your Campaign Monitor Mailing Lists</span><select name="listsid" class="mailing_lists" >';
foreach($result->response as $r){
	$output.= '<option name="cm_list_option" value="'.$r->ListID.'">'.$r->Name.'</option>';
}

$output.= '</select>';
}

}else{
	$output= '<div class="error fade">Please enter all your details into the inputs above and please double check that they are correct.</div>';
}

echo $output;

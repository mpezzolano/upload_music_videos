<?php 
$output='';
error_reporting(0);
require_once 'jsonRPCClient.php';
$apikey =  $gr_apikey;
$apiurl = 'http://api2.getresponse.com';
$client = new jsonRPCClient($apiurl);

$result = NULL;
try {
	$output.= '<span class="mailing-list-small">Your GetResponse Mailing Lists</span><select name="listsid" class="mailing_lists"  id="mc_lists">';
	$name = array();
    $result = $client->get_campaigns($apikey);
    foreach($result as $r){
    	$name = $r['name'];
    	$result2 = $client->get_campaigns(
	        $apikey,
	        array (
	        	'name' => array ( 'EQUALS' => $name )
	        )
	    );
	    $CAMPAIGN_ID = array_pop(array_keys($result2));
	    $output .= '<option name="mc_'.$name.'" value="'.$CAMPAIGN_ID.'">'.$name.'</option>';
    }
    $output.= '</select>';
}
catch (Exception $e) {
		
    $output='<div class="error fade">'.$e->getMessage().'</div>';
}

echo $output;
?>
<?php
include_once('ctctsupport-ctct_php_library/ConstantContact.php');
$apikey = '515faf7a-6f1a-4421-bf6f-17d32db7c33b';

//constructor for constant contact class
$Datastore = new CTCTDataStore();

$ConstantContact = new ConstantContact('basic', $apikey, $cc_username, $cc_password);
$ContactLists = $ConstantContact->getLists();
if($ContactLists){
 $output.= '<span class="mailing-list-small">Your Constant Contact Mailing Lists</span><select class="mailing_lists" name="listsid" >';
    foreach($ContactLists['lists'] as $list){
       $output.= '<option name="'.$list->name.'" value="'.$list->id.'"> '.$list->name.'<br />';
    }
	$output.= '</select>'; 
   
} else {
	$output.= '<div class="error fade">You are not connected, please try again</div>';
        
 }

echo $output;
?>
<?php
error_reporting(0);
$output=''; 
require_once( 'icontact.php' );

$icontact = new Icontact('https://app.icontact.com/icp', $ic_username, $ic_password, $ic_apikey);

$account_id = $icontact->LookUpAccountId();
$client_folder_id = $icontact->LookUpClientFolderId();

try{	
    $lists = $icontact->getLists();

      $output.= '<span class="mailing-list-small">iContact Mailing Lists</span><select name="listsid" class="mailing_lists"  id="ic_lists">'; 
	foreach($lists as $l){
		$output.= '<option name="mc_'.$l['name'].'" value="'.$l['listId'].'">'.$l['name'].'</option>';
	}
	$output.='</select>';
	}
 catch ( IcontactException $ex) {
		
		$output='<div class="error fade">'. $ex->GetErrorData().'</div>';     
	}	
	
echo $output;
//end of file
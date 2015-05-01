<?php
if($AccountID>0){
	$text = $mysqli->real_escape_string($_REQUEST['gallery-name']);
	$mysqli->query("INSERT INTO ".$prefix."Gallery (UserID,Name,Created) VALUES ('".$AccountID."','".$text."','".time()."')");
	$_REQUEST['s']='gallery';
	$_REQUEST['id']=$mysqli->insert_id;
}	
?>
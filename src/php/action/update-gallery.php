<?php
if($AccountID>0){
	$name = $mysqli->real_escape_string($_REQUEST['name']);
	$id = intval($_REQUEST['id']);
	$mysqli->query("UPDATE ".$prefix."Gallery SET Name = '".$name."' WHERE UserID = '".$AccountID."' AND ID = '".$id."'");
}
	
?>
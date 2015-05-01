<?php

if($AccountID>0){
	$text = $mysqli->real_escape_string($_REQUEST['photobook-name']);
	$mysqli->query("INSERT INTO ".$prefix."Book (UserID,Name,Created) VALUES ('".$AccountID."','".$text."','".time()."')");
}

?>
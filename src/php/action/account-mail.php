<?php

if($AccountID>0){
	$mail = $mysqli->real_escape_string($_REQUEST['mail']);
	$sendOK = $mysqli->query("UPDATE ".$prefix."User SET Mail = '".$mail."' WHERE ID = '".$AccountID."'");
	if($sendOK){
		$User->Mail = $mail;
	}
}
	
?>
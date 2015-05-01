<?php
if($AccountID>0){
	$pw = sha1($mysqli->real_escape_string($_REQUEST['pw']));
	$pw1 = sha1($mysqli->real_escape_string($_REQUEST['pw1']));
	$pw2 = sha1($mysqli->real_escape_string($_REQUEST['pw2']));
	if($pw1==$pw2 && $pw!=$pw1){
		$result = $mysqli->query("SELECT ID FROM ".$prefix."User WHERE ID = '".$AccountID."' AND Password_SHA1 = '".$pw."'");
		if($result->num_rows == 1){
			$sendOK = $mysqli->query("UPDATE ".$prefix."User SET Password_SHA1 = '".$pw1."' WHERE ID = '".$AccountID."'");
		}
	}
}
	
?>
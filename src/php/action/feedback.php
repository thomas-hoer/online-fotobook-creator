<?php
$text = $mysqli->real_escape_string($_REQUEST['text']);
if($text == ''){
	$sendFail = true;
}else{
	$sendOK = $mysqli->query("INSERT INTO ".$prefix."Feedback (UserID,Text,Time) VALUES ('".$AccountID."','".$text."','".time()."')");
}

?>
<?php
$login = $mysqli->real_escape_string($_REQUEST['login']);
$pw = sha1($mysqli->real_escape_string($_REQUEST['password']));
$result = $mysqli->query("SELECT ID FROM ".$prefix."User WHERE Name = '".$login."' AND Password_SHA1 = '".$pw."'");
if($result->num_rows == 1){
	$row = $result->fetch_object();
	$AccountID = $row->ID;
	$mysqli->query("UPDATE ".$prefix."Session SET UserID = '".$AccountID."' WHERE ID = '".$SessionID."'");
	header('Location: index'); 
	$_REQUEST['s']='index';
}

?>
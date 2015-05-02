<?php
$login = $mysqli->real_escape_string($_REQUEST['login']);
$mail = $mysqli->real_escape_string($_REQUEST['mail']);
$pw1 = sha1($mysqli->real_escape_string($_REQUEST['password']));
$pw2 = sha1($mysqli->real_escape_string($_REQUEST['password2']));
if($login != '' && $pw1 == $pw2){
	$result = $mysqli->query("SELECT ID FROM ".$prefix."User WHERE Name = '".$login."'");
	if($result->num_rows == 0){
		$mysqli->query("INSERT INTO ".$prefix."User (Name,Password_SHA1,Mail) VALUES ('".$login."','".$pw1."','".$mail."')");
		$AccountID = $mysqli->insert_id;
		$mysqli->query("UPDATE ".$prefix."Session SET UserID = '".$AccountID."' WHERE ID = '".$SessionID."'");
		$mysqli->query("INSERT INTO ".$prefix."Gallery (UserID,`Name`,Created) VALUES ('".$AccountID."','Default Gallery','".time()."')");
		header('Location: index'); 
		$_REQUEST['s']='index';
	}else{
		$error = "login_exists";
	}
}else{
	if($login == ''){
		$error = "nologin";
	}
	if($pw1!=$pw2){
		$error = "password_wrong";
	}
}
?>
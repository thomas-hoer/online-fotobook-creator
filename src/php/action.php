<?php

switch($_REQUEST['type']){
	case 'login':
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
	break;
	case 'register':
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
				$mysqli->query("INSERT INTO ".$prefix."Gallery (UserID,`Name`) VALUES ('".$AccountID."','Default Gallery')");
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
	break;
	case 'logout':
		if($AccountID>0){
			$mysqli->query("UPDATE ".$prefix."Session SET UserID = '0' WHERE ID = '".$SessionID."'");
			$AccountID = 0;
			$User = null;
		}
		header('Location: index'); 
		$_REQUEST['s']='index';
	break;
	case 'feedback':
		$text = $mysqli->real_escape_string($_REQUEST['text']);
		if($text == ''){
			$sendFail = true;
		}else{
			$sendOK = $mysqli->query("INSERT INTO ".$prefix."Feedback (UserID,Text,Time) VALUES ('".$AccountID."','".$text."','".time()."')");
		}
	break;
	case 'account-mail':
		if($AccountID>0){
			$mail = $mysqli->real_escape_string($_REQUEST['mail']);
			$sendOK = $mysqli->query("UPDATE ".$prefix."User SET Mail = '".$mail."' WHERE ID = '".$AccountID."'");
			if($sendOK){
				$User->Mail = $mail;
			}
		}
	break;
	case 'account-pw':
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
	break;
}

	
?>
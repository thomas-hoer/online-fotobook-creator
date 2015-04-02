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
				header('Location: index'); 
				$_REQUEST['s']='index';
			}
		}
	break;
	case 'logout':
		$mysqli->query("UPDATE ".$prefix."Session SET UserID = '0' WHERE ID = '".$SessionID."'");
		$AccountID = 0;
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
}

	
?>
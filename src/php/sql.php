<?php
$prefix = "Photobook_";
$mysqli = new mysqli("host", "user", "password", "database");

$token = $mysqli->real_escape_string($_COOKIE['Session']);
$code = $mysqli->real_escape_string($_REQUEST['code']);
$SessionID = 0;
$AccountID = 0;

// Test current Session-Cookie 
if(strlen($token)==64){
	$result = $mysqli->query("SELECT * FROM ".$prefix."Session WHERE Cookie='".$token."'");
	if($result->num_rows == 1){
		$row = $result->fetch_object();
		$SessionID = $row->ID;
		$AccountID = $row->UserID;
		$result = $mysqli->query("SELECT ID,Name,Mail FROM ".$prefix."User WHERE ID = '".$AccountID."'");
		if($result->num_rows == 1){
			$User = $result->fetch_object();
		}else{
			$AccountID = 0;
		}
	}
}

// if there is no cookie or the cookie does not relate to a sesseion in the database create a new session
if($SessionID == 0){
	$token = createSessionID(64);
	setcookie("Session",$token);
	$mysqli->query("INSERT INTO ".$prefix."Session (Cookie) VALUES ('".$token."')");
	$SessionID = $mysqli->insert_id;

}


/**
 * Creates a random string of letters and numbers of size $len
 */
function createSessionID($len){
	$Password="";
	// We only use distinct glyphs preventing some uncertainty  in some font types (like O and 0 or 1, I and l)
	$Letters = array("a", "b", "c", "d", "e", "f", "g", "h", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z","A", "B", "C", "D", "E", "F", "G", "H", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	$Numbers = array("2", "3", "4", "5", "6", "7", "8", "9");
	for($i = 0, $Password = ""; strlen($Password) < $len; $i++)
	{
		if(rand(0, 1))
		{
			$Password .= $Letters[rand(0, count($Letters)-1)];
		}
		else
		{	
			$Password .= $Numbers[rand(0, count($Numbers)-1)];
		}
	}
	return $Password;
}


?>
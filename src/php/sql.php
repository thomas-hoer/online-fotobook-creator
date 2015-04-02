<?php
$prefix = "Photobook_";
$mysqli = new mysqli("host", "user", "password", "database");

$token = $mysqli->real_escape_string($_COOKIE['Session']);
$code = $mysqli->real_escape_string($_REQUEST['code']);
$SessionID = 0;
$AccountID = 0;

if(strlen($token)==64){
	$result = $mysqli->query("SELECT * FROM ".$prefix."Session WHERE Cookie='".$token."'");
	if($result->num_rows == 1){
		$row = $result->fetch_object();
		$SessionID = $row->ID;
		$AccountID = $row->UserID;
		$result = $mysqli->query("SELECT ID,Name FROM ".$prefix."User WHERE ID = '".$AccountID."'");
		$User = $result->fetch_object();
	}
}
if($SessionID == 0){
	$token = createSessionID(64);
	setcookie("Session",$token);
	$mysqli->query("INSERT INTO ".$prefix."Session (Cookie) VALUES ('".$token."')");
	$SessionID = $mysqli->insert_id;

}



function createSessionID($Laenge){
	$Passwort="";
	$Buchstaben = array("a", "b", "c", "d", "e", "f", "g", "h", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z","A", "B", "C", "D", "E", "F", "G", "H", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
	$Zahlen = array("2", "3", "4", "5", "6", "7", "8", "9");
	for($i = 0, $Passwort = ""; strlen($Passwort) < $Laenge; $i++)
	{
		if(rand(0, 1))
		{
			$Passwort .= $Buchstaben[rand(0, count($Buchstaben)-1)];
		}
		else
		{	
			$Passwort .= $Zahlen[rand(0, count($Zahlen)-1)];
		}
	}
	return $Passwort;
}


?>
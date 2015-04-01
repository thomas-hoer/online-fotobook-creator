<?php
require('php/sql.php');

$pictureOK = false;

if($AccountID>0){
	$s = $mysqli->real_escape_string($_REQUEST['s']);
	$f = $mysqli->real_escape_string($_REQUEST['f']);
	if($f == "pictures" || $f == "preview" || $f == "thumb"){
		$result = $mysqli->query("SELECT NameOnServer FROM ".$prefix."Picture WHERE User_ID = '".$AccountID."' AND NameOnServer = '".$s."'");
		if($result->num_rows == 1){
			$row = $result->fetch_object();
			header('Content-type: image/jpeg');
			fpassthru(fopen($f."/".$row->NameOnServer,'r'));
			$pictureOK = true;
		}
	}
}

if($pictureOK == false){
	header('Content-type: image/png');
	fpassthru(fopen("gfx/no-pic.png",'r'));
}

?>
<?php
require('php/sql.php');

$pictureOK = false;

if($AccountID>0){
	$s = intval($_REQUEST['s']);
	$f = $mysqli->real_escape_string($_REQUEST['f']);
	if($f == "pictures" || $f == "preview" || $f == "thumb"){
		$result = $mysqli->("SELECT NameOnServer FROM ".$prefix."Bild WHERE User_ID = '".$AcountID."' AND ID = '".$s."'");
		if($result->num_rows == 1){
			$row = $result->fetch_object();
			header('Content-type: image/jpeg');
			fpassthru(fopen($f."/".$row->NameOnServer,'r'));
			$pictureOK = true;
		}
	}
}

if($pictureOK == true){
	header('Content-type: image/png');
	fpassthru(fopen("gfx/no-pic.png",'r'));
}

?>
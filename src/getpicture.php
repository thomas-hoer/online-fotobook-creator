<?php
require('php/sql.php');

$pictureOK = false;

if($AccountID>0){
	$s = $mysqli->real_escape_string($_REQUEST['s']);
	$f = $mysqli->real_escape_string($_REQUEST['f']);
	if($f == "pictures" || $f == "preview" || $f == "thumb"){
		$result = $mysqli->query("SELECT NameOnServer FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' AND NameOnServer = '".$s."'");
		if($result->num_rows == 1){
			$row = $result->fetch_object();
			header('Content-type: image/jpeg');
			$filename = $f."/".$row->NameOnServer;
			if($_REQUEST['type']=='rect'){
				
				$ImageSize = getimagesize($filename);
				$p = min($ImageSize[0],$ImageSize[1]);
				$image = ImageCreateFromJPEG($filename);
				$image2 = ImageCreateTrueColor(150, 150);
				imagecopyresized($image2,$image,0,0,0,0,150,150,$p,$p);
				imagejpeg($image2);
			}else{
				fpassthru(fopen($filename,'r'));
			}
			$pictureOK = true;
		}
	}
	if($f == "preview-book"){
		if($s == ''){
			header('Content-type: image/png');
			fpassthru(fopen('gfx/logo.png','r'));
		}else{
			$result = $mysqli->query("SELECT Bild FROM ".$prefix."Book WHERE UserID = '".$AccountID."' AND Bild = '".$s."'");
			if($result->num_rows == 1){
				$row = $result->fetch_object();
				header('Content-type: image/jpeg');
				$filename = $f."/".$row->NameOnServer;
				fpassthru(fopen($filename,'r'));
				$pictureOK = true;
			}
		}
	}
}

if($pictureOK == false){
	header('Content-type: image/png');
	fpassthru(fopen("gfx/unallowed.png",'r'));
}

?>
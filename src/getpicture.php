<?php
/*
 * This script is for the protection of the user data. 
 * Requests to the folders 'pictures', 'preview', 'thumb' and 'preview-book'
 * will be rewritten to this script. We only return the right image if the 
 * user is creator of the requested content. Otherwise an error-image will
 * be returned.
 */
 
// initialise database connection and user session
require('php/sql.php');

// http://stackoverflow.com/questions/2978496/make-php-page-return-304-not-modified-if-it-hasnt-been-modified
function sanitize_output($buffer) {
    $headers = apache_request_headers();
    $tt5=md5($buffer);  
    header('ETag: '.$tt5);
    if (isset($headers['If-None-Match']) && $headers['If-None-Match']===$tt5) {
        header('HTTP/1.1 304 Not Modified');
        header('Connection: close');
        exit();
    }
    return $buffer;
}

ob_start("sanitize_output");

// variable is set true when a picture has been found
// if it remains false the default not-allowed picture will be shown
// this is for example the case when no user is logged in or the picture belongs to another user
$pictureOK = false;

if($AccountID>0){
	$s = $mysqli->real_escape_string($_REQUEST['s']);
	$f = $mysqli->real_escape_string($_REQUEST['f']);
	
	// show normal pictures
	if($f == "pictures" || $f == "preview" || $f == "thumb"){
		$result = $mysqli->query("SELECT NameOnServer FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' AND NameOnServer = '".$s."'");
		if($result->num_rows == 1){
			$row = $result->fetch_object();
			header('Content-type: image/jpeg');
			$filename = $f."/".$row->NameOnServer;
			
			// if the rect type is active we clip the image on the upper left
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
	
	// show photobook previews
	if($f == "preview-book"){
		if($s == ''){
			header('Content-type: image/png');
			fpassthru(fopen('gfx/logo.png','r'));
			$pictureOK = true;
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

// show default picture when no other picture was found
if($pictureOK == false){
	header('Content-type: image/png');
	fpassthru(fopen("gfx/unallowed.png",'r'));
}

?>
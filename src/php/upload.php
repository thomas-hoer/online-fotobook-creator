<?php
/*
 * This file is used for handle fileupload and store reference in the database.
 * This script stores each picture in 3 different copies. One Thumbnail with
 * maximum width 150. One preview version with max width/height of 500 and the 
 * original picture in full resolution. We keep the aspect ratio in all pictures.
 *
 *
 * The following variables are required to be set before including this file
 * $Gallery     The gallery in which the picture shall be uploaded
 * $baseDir     The relative file position from the calling script and the root
 *              of the application. This is required since ajax starts from the
 *              /ajax directory and need to set $baseDir = "../"
 */
 
$id = 0;
if($_FILES['file']['tmp_name']){
	$Tmpname = $_FILES['file']['tmp_name'];
	$OriginalFilename = $mysqli->real_escape_string($_FILES['file']['name']);
	$imagesize = @getimagesize($Tmpname);
	if($imagesize){
		$Width = $imagesize[0];
		$Height = $imagesize[1];
		$mysqli->query("INSERT INTO ".$prefix."Picture (W,H,UserID,Name,NameOnServer,GalleryID) VALUES ('".$Width."','".$Height."','".$AccountID."','".$OriginalFilename."','','".$Gallery->ID."')");
		$id = $mysqli->insert_id;
		$mysqli->query("UPDATE ".$prefix."Picture SET NameOnServer = '".$id.".jpg' WHERE ID = '".$id."'");
		// we simply call the picture on the server as the autoincrement id 
		// in the database
		$NameOnServer = $id.".jpg";
		if($imagesize[2] == 1){
			$Image = ImageCreateFromGIF($Tmpname);
		}elseif($imagesize[2] == 2){
			$Image = ImageCreateFromJPEG($Tmpname);
		}elseif($imagesize[2] == 3){
			$Image = ImageCreateFromPNG($Tmpname);
		}
		
		// Create a preview version of the picture with max width/height of 
		// 500. If the original picture smaller than this we do not upscale 
		// the picture
		$thumbnailSize = 500;
		if($Width>=$Height){
			$scale = $Width/$thumbnailSize;
		}else{
			$scale = $Height/$thumbnailSize;
		}
		if($scale<1){
			$h = $Height;
			$w = $Width;
			ImageJPEG($Image, $baseDir."preview/".$NameOnServer);
		}else{
			$h = intval($Height/$scale);
			$w = intval($Width/$scale);
			ImageJPEG(ImageScale($Image,$w,$h), $baseDir."preview/".$NameOnServer);
		}
		
		// Create the Thumbnail version with max with of 150
		$thumbnailSize = 150;
		$scale = $Width/$thumbnailSize;
		$h = intval($Height/$scale);
		$w = intval($Width/$scale);
		$s = ImageScale($Image,$w,$h);
		ImageJPEG($s, $baseDir."thumb/".$NameOnServer);

		
		// Save the picture in full resolution
		move_uploaded_file($_FILES['file']['tmp_name'],$baseDir."pictures/".$NameOnServer);
	}
}

?>
<?php
$id = 0;
if($_FILES['file']['tmp_name']){
	$Tmpname = $_FILES['file']['tmp_name'];
	$Filename = $mysqli->real_escape_string($_FILES['file']['name']);
	$imagesize = @getimagesize($Tmpname);
	if($imagesize){
		$Width = $imagesize[0];
		$Height = $imagesize[1];
		$mysqli->query("INSERT INTO ".$prefix."Picture (W,H,UserID,Name,NameOnServer,GalleryID) VALUES ('".$Width."','".$Height."','".$AccountID."','".$Filename."','','".$Gallery->ID."')");
		echo $mysqli->error;
		$id = $mysqli->insert_id;
		$mysqli->query("UPDATE ".$prefix."Picture SET NameOnServer = '".$id.".jpg' WHERE ID = '".$id."'");
		$bild = $id.".jpg";
		if($imagesize[2] == 1){
			$Image = ImageCreateFromGIF($Tmpname);
		}elseif($imagesize[2] == 2){
			$Image = ImageCreateFromJPEG($Tmpname);
		}elseif($imagesize[2] == 3){
			$Image = ImageCreateFromPNG($Tmpname);
		}
		
		
		$thumbnailSize = 500;
		if($Width>=$Height){
			$scale = $Width/$thumbnailSize;
		}else{
			$scale = $Height/$thumbnailSize;
		}
		if($scale<1){
			$h = $Height;
			$w = $Width;
			ImageJPEG($Image, $baseDir."preview/".$bild);
		}else{
			$h = intval($Height/$scale);
			$w = intval($Width/$scale);
			ImageJPEG(ImageScale($Image,$w,$h), $baseDir."preview/".$bild);
		}
		
		
		$thumbnailSize = 150;
		$scale = $Width/$thumbnailSize;
		$h = intval($Height/$scale);
		$w = intval($Width/$scale);
		$s = ImageScale($Image,$w,$h);
		ImageJPEG($s, $baseDir."thumb/".$bild);

		move_uploaded_file($_FILES['file']['tmp_name'],$baseDir."pictures/".$bild);
	}
}
?>
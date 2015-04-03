<?php
if($_FILES['file']['tmp_name']){
	$Grafikdatei = $_FILES['file']['tmp_name'];
	$Filename = $mysqli->real_escape_string($_FILES['file']['name']);
	$Bilddaten = @getimagesize($Grafikdatei);
	if($Bilddaten){
		$OriginalBreite = $Bilddaten[0];
		$OriginalHoehe = $Bilddaten[1];
		$mysqli->query("INSERT INTO ".$prefix."Picture (W,H,UserID,Name,NameOnServer,GalleryID) VALUES ('".$OriginalBreite."','".$OriginalHoehe."','".$AccountID."','".$Filename."','','".$Gallery->ID."')");
		$id = $mysqli->insert_id;
		$mysqli->query("UPDATE ".$prefix."Picture SET NameOnServer = '".$id.".jpg' WHERE ID = '".$id."'");
		$bild = $id.".jpg";
		if($Bilddaten[2] == 1){
			$Originalgrafik = ImageCreateFromGIF($Grafikdatei);
		}elseif($Bilddaten[2] == 2){
			$Originalgrafik = ImageCreateFromJPEG($Grafikdatei);
		}elseif($Bilddaten[2] == 3){
			$Originalgrafik = ImageCreateFromPNG($Grafikdatei);
		}
		$ThumbnailGroese = 500;
		if($OriginalBreite>=$OriginalHoehe){
			$Skalierungsfaktor = $OriginalBreite/$ThumbnailGroese;
		}else{
			$Skalierungsfaktor = $OriginalHoehe/$ThumbnailGroese;
		}
		if($Skalierungsfaktor<1){
			$ThumbnailHoehe = $OriginalHoehe;
			$ThumbnailBreite = $OriginalBreite;
			$Thumbnailgrafik=$Originalgrafik;
		}else{
			$ThumbnailHoehe = intval($OriginalHoehe/$Skalierungsfaktor);
			$ThumbnailBreite = intval($OriginalBreite/$Skalierungsfaktor);
			$Thumbnailgrafik = ImageCreateTrueColor($ThumbnailBreite, $ThumbnailHoehe);
			ImageCopyResized($Thumbnailgrafik, $Originalgrafik, 0, 0, 0, 0, $ThumbnailBreite, $ThumbnailHoehe, $OriginalBreite, $OriginalHoehe);
		}
		ImageJPEG($Thumbnailgrafik, $baseDir."preview/".$bild);
		$ThumbnailGroese = 150;
		$Skalierungsfaktor = $OriginalBreite/$ThumbnailGroese;
		$ThumbnailHoehe = intval($OriginalHoehe/$Skalierungsfaktor);
		$ThumbnailBreite = intval($OriginalBreite/$Skalierungsfaktor);
		$Thumbnailgrafik = ImageCreateTrueColor($ThumbnailBreite, $ThumbnailHoehe);
		ImageCopyResized($Thumbnailgrafik, $Originalgrafik, 0, 0, 0, 0, $ThumbnailBreite, $ThumbnailHoehe, $OriginalBreite, $OriginalHoehe);
		ImageJPEG($Thumbnailgrafik, $baseDir."thumb/".$bild);
		
		move_uploaded_file($_FILES['file']['tmp_name'],$baseDir."pictures/".$bild);
	}
}
?>
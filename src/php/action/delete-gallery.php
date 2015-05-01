<?php
if($AccountID>0){
	$id = intval($_REQUEST['id']);
	$result = $mysqli->query("SELECT COUNT(*) FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."'");
	$row = $result->fetch_array();
	if($row[0]>1){
		$result = $mysqli->query("SELECT NameOnServer FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' AND GalleryID = '".$id."'");
		while($row = $result->fetch_object()){
			@unlink('pictures/'.$row->NameOnServer);
			@unlink('thumb/'.$row->NameOnServer);
			@unlink('preview/'.$row->NameOnServer);
		}
		$mysqli->query("DELETE FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' AND ID = '".$id."'");
		$mysqli->query("DELETE FROM `".$prefix."Element` WHERE PictureID IN ( SELECT ID FROM `".$prefix."Picture` WHERE UserID = '".$AccountID."' AND GalleryID = '".$id."')");
		$mysqli->query("DELETE FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' AND GalleryID = '".$id."'");
	}
}

?>
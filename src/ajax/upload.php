<?php
require('../php/sql.php');

if($AccountID>0){
	$GalleryID = intval($_REQUEST['id']);
	$result = $mysqli->query("SELECT ID FROM ".$prefix."Gallery WHERE ID = '".$GalleryID."' AND UserID = '".$AccountID."'");
	if($result->num_rows == 0){
		$result = $mysqli->query("SELECT ID FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' ORDER BY ID ASC LIMIT 1");
	}
	$Gallery = $result->fetch_object();
	$baseDir = "../";
	include('../php/upload.php');
	echo $id;
}
?>
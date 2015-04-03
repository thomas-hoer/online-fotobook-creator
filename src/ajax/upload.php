<?php
require('../php/sql.php');

if($AccountID>0){
	$result = $mysqli->query("SELECT ID FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' ORDER BY ID ASC LIMIT 1");
	$Gallery = $result->fetch_object();
	$baseDir = "../";
	include('../php/upload.php');
	echo $id;
}
?>
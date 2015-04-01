<?php
require('../php/sql.php');

$str = file_get_contents('php://input');
echo $str;
$json = json_decode($str);
foreach($json as $item) {
	$id = $mysqli->real_escape_string($item->{'id'});
	$result = $mysqli->query("SELECT ID FROM ".$prefix."Element WHERE Name = '".$id."'");
	if($result->num_rows == 1){
		$obj = $result->fetch_object();
		$elementID = $obj->ID;
	}else{
		$elementID = 0;
	}
	$result = $mysqli->query("SELECT ID FROM ".$prefix."Text WHERE Name = '".$id."'");
	if($result->num_rows == 1){
		$obj = $result->fetch_object();
		$textID = $obj->ID;
	}else{
		$textID = 0;
	}
	
	if(array_key_exists('action',$item)){
		if($item->{'action'}=="remove"){
			if($elementID>0){
				$mysqli->query("DELETE FROM ".$prefix."Element WHERE ID = '".$elementID."'");
			}
			if($textID>0){
				$mysqli->query("DELETE FROM ".$prefix."Text WHERE ID = '".$textID."'");
			}
		}else if ($item->{'action'}=="addimg"){
			$mysqli->query("INSERT INTO ".$prefix."Element (Session_ID,Name,X,Y,Bild_ID,User_ID,W,H,R,Seite_ID) VALUES ('".$SessionID."','".$id."','".floatval($item->{'left'})."','".floatval($item->{'top'})."','".floatval($item->{'pid'})."','".$AccountID."','".floatval($item->{'width'})."','".floatval($item->{'height'})."','".floatval($item->{'rotate'})."','".intval($item->{'page'})."')");
		}else if ($item->{'action'}=="addtext"){
			$mysqli->query("INSERT INTO ".$prefix."Text (Session_ID,Name,X,Y,User_ID,Text,R,Size,Seite_ID) VALUES ('".$SessionID."','".$id."','".floatval($item->{'left'})."','".floatval($item->{'top'})."','".$AccountID."','','".floatval($item->{'rotate'})."','".intval($item->{'size'})."','".intval($item->{'page'})."')");
		}
	}else{
		if($elementID > 0){
			$update = "UPDATE ".$prefix."Element SET ";
		}else if($textID > 0){
			$update = "UPDATE ".$prefix."Text SET ";
		}
		$sep="";
		if(array_key_exists('width',$item)){$update .= $sep." `W` = '".floatval($item->{'width'})."'";$sep=",";}
		if(array_key_exists('height',$item)){$update .= $sep." `H` = '".floatval($item->{'height'})."'";$sep=",";}
		if(array_key_exists('top',$item)){$update .= $sep." `Y` = '".floatval($item->{'top'})."'";$sep=",";}
		if(array_key_exists('left',$item)){$update .= $sep." `X` = '".floatval($item->{'left'})."'";$sep=",";}
		if(array_key_exists('z',$item)){$update .= $sep." `Z` = '".intval($item->{'z'})."'";$sep=",";}
		if(array_key_exists('size',$item)){$update .= $sep." `Size` = '".intval($item->{'size'})."'";$sep=",";}
		if(array_key_exists('rotate',$item)){$update .= $sep." `R` = '".floatval($item->{'rotate'})."'";$sep=",";}
		if(array_key_exists('text',$item)){$update .= $sep." `Text` = '".$mysqli->real_escape_string($item->{'text'})."'";$sep=",";}
		if($elementID > 0){
			$update.= " WHERE ID = '".$elementID."'";
			$mysqli->query($update);
		}else if($textID > 0){
			$update.= " WHERE ID = '".$textID."'";
			$mysqli->query($update);
		}
	}
	echo $mysqli->error;
}

$mysqli->query("INSERT INTO ".$prefix."CMD (CMD) VALUES ('".$str."')");

?>
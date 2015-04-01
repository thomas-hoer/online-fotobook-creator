<?php
require('../php/sql.php');

$str = file_get_contents('php://input');
echo $str;
$json = json_decode($str);
foreach($json as $item) {
	$id = $mysqli->real_escape_string($item->{'id'});
	$result = $mysqli->query("SELECT * FROM ".$prefix."Element WHERE Name = '".$id."'");
	if($result->num_rows == 1){
		$obj = $result->fetch_object();
		$elementID = $obj->ID;
	}else{
		$elementID = 0;
	}
	$result = $mysqli->query("SELECT * FROM ".$prefix."Text WHERE Name = '".$id."'");
	if($result->num_rows == 1){
		$obj = $result->fetch_object();
		$textID = $obj->ID;
	}else{
		$textID = 0;
	}
	
	if(array_key_exists('action',$item)){
		switch($item->{'action'}){
			case 'remove':
				if($elementID>0){
					$mysqli->query("DELETE FROM ".$prefix."Element WHERE ID = '".$elementID."'");
				}
				if($textID>0){
					$mysqli->query("DELETE FROM ".$prefix."Text WHERE ID = '".$textID."'");
				}
			break;
			case 'addimg':
				$z = getMaxZFromPage($item->{'page'});
				$mysqli->query("INSERT INTO ".$prefix."Element (Name,X,Y,Z,PictureID,UserID,W,H,R,PageID) VALUES ('".$id."','".floatval($item->{'left'})."','".floatval($item->{'top'})."','".$z."','".floatval($item->{'pid'})."','".$AccountID."','".floatval($item->{'width'})."','".floatval($item->{'height'})."','".floatval($item->{'rotate'})."','".intval($item->{'page'})."')");
			break;
			case 'addtext':
				$mysqli->query("INSERT INTO ".$prefix."Text (Name,X,Y,UserID,Text,R,Size,PageID) VALUES ('".$id."','".floatval($item->{'left'})."','".floatval($item->{'top'})."','".$AccountID."','','".floatval($item->{'rotate'})."','".intval($item->{'size'})."','".intval($item->{'page'})."')");
			break;
			case 'layertop':
				$z = getMaxZFromPage($obj->PageID);
				updateZ($z);
			break;
			case 'layerbottom':
				$z = getMinZFromPage($obj->PageID);
				updateZ($z);
			break;
			case 'swapz':
				$swapid = $mysqli->real_escape_string($item->{'swapid'});
				$result = $mysqli->query("SELECT ID,Z FROM ".$prefix."Element WHERE Name = '".$swapid."'");
				if($result->num_rows == 1){
					$sobj = $result->fetch_object();
					$mysqli->query("UPDATE ".$prefix."Element SET Z = '".$obj->Z."' WHERE ID = '".$sobj->ID."'");
					updateZ($sobj->Z);
				}
				$result = $mysqli->query("SELECT ID,Z FROM ".$prefix."Text WHERE Name = '".$swapid."'");
				if($result->num_rows == 1){
					$sobj = $result->fetch_object();
					$mysqli->query("UPDATE ".$prefix."Text SET Z = '".$obj->Z."' WHERE ID = '".$sobj->ID."'");
					updateZ($sobj->Z);
				}
			break;
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


function getMaxZFromPage($page){
	global $prefix,$mysqli;
	$result = $mysqli->query("SELECT Max(Z) FROM ".$prefix."Element WHERE PageID = '".intval($page)."'");
	$row1 = $result->fetch_array();
	$result = $mysqli->query("SELECT Max(Z) FROM ".$prefix."Text WHERE PageID = '".intval($page)."'");
	$row2 = $result->fetch_array();
	return max($row1[0],$row2[0])+1;
}
function getMinZFromPage($page){
	global $prefix,$mysqli;
	$result = $mysqli->query("SELECT Min(Z) FROM ".$prefix."Element WHERE PageID = '".intval($page)."'");
	$row1 = $result->fetch_array();
	$result = $mysqli->query("SELECT Min(Z) FROM ".$prefix."Text WHERE PageID = '".intval($page)."'");
	$row2 = $result->fetch_array();
	return max($row1[0],$row2[0])-1;
}
function updateZ($z){
	global $elementID,$textID,$mysqli,$prefix;
	if($elementID>0){
		$mysqli->query("UPDATE ".$prefix."Element SET Z = '".$z."' WHERE ID = '".$elementID."'");
	}
	if($textID>0){
		$mysqli->query("UPDATE ".$prefix."Text SET Z = '".$z."' WHERE ID = '".$textID."'");
	}
}
?>
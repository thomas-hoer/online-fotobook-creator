<?php

if($AccountID>0){
	$id = intval($_REQUEST['id']);
	$result = $mysqli->query("SELECT * FROM ".$prefix."Book WHERE ID='".$id."' AND UserID = '".$AccountID."'");
	if($result->num_rows == 1){
		$row = $result->fetch_object();
		if($row->Bild != ''){
			@unlink('preview-book/'.$row->Bild);
		}
		$mysqli->query("DELETE FROM ".$prefix."Book WHERE UserID = '".$AccountID."' AND ID = '".$id."'");
	}
}
?>
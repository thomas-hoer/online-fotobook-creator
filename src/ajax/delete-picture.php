<?php
require('../php/sql.php');

if($AccountID>0){
	$id = intval($_REQUEST['id']);
	$result = $mysqli->query("SELECT * FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' AND ID = '".$id."'");
	while($row = $result->fetch_object()){
		@unlink('../pictures/'.$row->NameOnServer);
		@unlink('../thumb/'.$row->NameOnServer);
		@unlink('../preview/'.$row->NameOnServer);
		$mysqli->query("DELETE FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' AND ID = '".$id."'");
	}
}
?>
<?php

if($AccountID>0){
	$mysqli->query("UPDATE ".$prefix."Session SET UserID = '0' WHERE ID = '".$SessionID."'");
	$AccountID = 0;
	$User = null;
}
header('Location: index'); 
$_REQUEST['s']='index';

?>
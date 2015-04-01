<?php
require('sql.php');

if($SessionID>0){
	$mysqli->query("DELETE ".$prefix."Session WHERE ID = ".$SessionID);
	setcookie("Session",'');
}

fpassthru(fopen("index.html",'r'));
?>
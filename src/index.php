<?php
require('php/sql.php');
if($_REQUEST['s']=='logout'){
	$_REQUEST['type']='logout';
}
if(isset($_REQUEST['type'])){
	include('php/action.php');
}

$s = $_REQUEST['s'];
if($AccountID>0){
	switch($s){
		case 'photobook':
		case 'photobooks':
		case 'feedback':
		case 'galleries':
		case 'gallery':
		case 'account':
			include('php/private/'.$s.'.php');
			break;
		default:
			include('php/private/index.php');
			break;
	}
}else{
	switch($s){
		case 'register':
			include('php/public/register.php');
			break;
		default:
			include('php/public/index.php');
			break;
	}
	
}
?>
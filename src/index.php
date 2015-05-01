<?php

// initialise database connection and user session
require('php/sql.php');

// if user calls the 'logout' create an action 'logout'
if($_REQUEST['s']=='logout'){
	$_REQUEST['type']='logout';
}

// start the action framework only if there is an action declared
if(isset($_REQUEST['type'])){
	include('php/action.php');
}

// Check wheater a user is logged in or not
// $AccountID will be set in 'php/sql.php'
if($AccountID>0){
	// check for valid page
	switch($_REQUEST['s']){
		case 'photobook':
		case 'photobooks':
		case 'feedback':
		case 'galleries':
		case 'gallery':
		case 'account':
			include('php/private/'.$_REQUEST['s'].'.php');
			break;
		default:
			include('php/private/index.php');
			break;
	}
}else{
	// check for valid page
	switch($_REQUEST['s']){
		case 'register':
			include('php/public/'.$_REQUEST['s'].'.php');
			break;
		default:
			include('php/public/index.php');
			break;
	}
	
}
?>
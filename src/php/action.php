<?php
// Check for valid action
switch($_REQUEST['type']){
	case 'login':
	case 'register':
	case 'logout':
	case 'feedback':
	case 'account-mail':
	case 'account-pw':
	case 'add-gallery':
	case 'add-photobook':
	case 'delete-gallery':
	case 'delete-photobook':
	case 'upload-file':
	case 'delete-picture':
	case 'update-gallery':
		include 'action/'.$_REQUEST['type'].'.php';
	break;
}

	
?>
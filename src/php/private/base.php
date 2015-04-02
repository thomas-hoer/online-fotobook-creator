<?php

function printHead(){
global $User;
$menuitem == 0;
switch($_REQUEST['s']){
	case 'account':
		$menuitem = 3;
		break;
	case 'photobook':
	case 'photobooks':
		$menuitem = 2;
		break;
	case 'feedback':
		$menuitem = 4;
		break;
	case 'galleries':
	case 'gallery':
		$menuitem = 1;
		break;
}
?>
<html>
<head>
<title>Online Photobook Creator</title>
<script type="text/javascript" src="js/jquery-2.1.3.js"> </script>
<script type="text/javascript" src="js/intern.js"> </script>
<link rel="stylesheet" type="text/css" href="css/intern.css"/>
</head>
<body>
<div class="header">
	<div class="content">
		<a href="index"><img src="gfx/logo_small.png" class="logo"/></a>
		Online Photobook Creator
		<div class="username">
		<?php echo $User->Name; ?>
		</div>
	</div>
</div>
<div class="menu">
	<div class="content">
		<a href="index" class="menuentry<?php if($menuitem==0){echo " active-menuentry";}?>">Overview</a><a href="galleries" class="menuentry<?php if($menuitem==1){echo " active-menuentry";}?>">Pictures</a><a href="photobooks" class="menuentry<?php if($menuitem==2){echo " active-menuentry";}?>">Photobooks</a><a href="account" class="menuentry<?php if($menuitem==3){echo " active-menuentry";}?>">Account</a>
	</div>
</div>
<div class="body">
	<div class="content">
<?php
}
function printFoot(){
?>
	</div>
</div>
<div class="account-menu">
	<a href="logout">Logout</a>
</div>
</body>
</html>
<?php
}
?>
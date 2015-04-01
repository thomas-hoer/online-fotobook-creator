<?php
require('php/sql.php');

if(isset($_REQUEST['type'])){
	include('php/action.php');
}

$s = $_REQUEST['s'];
if($AccountID>0){
	include('php/fotobuch.php');
}else{
	if($s=='' || $s=='index'){
		include('php/index.php');
	}else if($s=='register'){
		include('php/register.php');
	}
	
}
?>
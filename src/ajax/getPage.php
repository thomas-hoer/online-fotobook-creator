<?php
require('../php/sql.php');

if($AccountID>0){

	$book = intval($_REQUEST['b']);
	$page = intval($_REQUEST['p']);

	$result = $mysqli->query("SELECT * FROM ".$prefix."Book WHERE ID = '".$book."' AND UserID = '".$AccountID."'");
	if($result->num_rows == 1){

		$abfrage = "SELECT `Name` AS `id`,`X` AS `left`,`Y` AS `top`,`W` AS `width`,`H` AS `height`,`R` AS `rotate`,`PictureID` AS `pid` FROM ".$prefix."Element WHERE BookID = '".$book."' AND Page = '".$page."' ORDER BY `Z` ASC";
		$ergebnis=$mysqli->query($abfrage);
		$pics = array();
		while($nachricht = $ergebnis->fetch_object()){
			$nachricht->left = floatval($nachricht->left);
			$nachricht->top = floatval($nachricht->top);
			$nachricht->width = floatval($nachricht->width);
			$nachricht->height = floatval($nachricht->height);
			$nachricht->rotate = floatval($nachricht->rotate);
			$nachricht->pid = intval($nachricht->pid);

			$pics[$nachricht->id]=$nachricht;
		}

		

		
		$abfrage = "SELECT `Name` AS `id`,`X` AS `left`,`Y` AS `top`,`R` AS `rotate`,`Text` AS `text`,`Size` AS `size` FROM ".$prefix."Text WHERE BookID = '".$book."' AND Page = '".$page."' AND `Text` <> '' ORDER BY `Z` ASC";
		$ergebnis=$mysqli->query($abfrage);
		$texts = array();
		while($nachricht = $ergebnis->fetch_object()){
			$nachricht->left = floatval($nachricht->left);
			$nachricht->top = floatval($nachricht->top);
			$nachricht->rotate = floatval($nachricht->rotate);
			$nachricht->size = intval($nachricht->size);

			$texts[$nachricht->id]=$nachricht;
		}
		echo json_encode(array("elements"=>$pics,"textElements"=>$texts));
	}
}
?>
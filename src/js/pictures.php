<?php
header('Content-type: text/javascript');

require('../php/sql.php');


if($SessionID>0){

	$abfrage = "SELECT ID FROM ".$prefix."Picture WHERE UserID = '".$AccountID."' ORDER BY ID ASC";
	$ergebnis=$mysqli->query($abfrage);
	$out = array();
	while($nachricht = $ergebnis->fetch_object()){
		$out[$nachricht->ID]=$nachricht->ID;
	}
	echo "var pictureids = ";
	echo json_encode(array_values($out));
	echo ";\n";
	
	
	$abfrage = "SHOW TABLE STATUS LIKE '".$prefix."Element'";
	$ergebnis=$mysqli->query($abfrage);
	$maxid = $ergebnis->fetch_object()->Auto_increment;
	echo "var elementID = ".$maxid.";\n";
	
	
	$abfrage = "SELECT `Name` AS `id`,`X` AS `left`,`Y` AS `top`,`W` AS `width`,`H` AS `height`,`R` AS `rotate`,`PictureID` AS `pid`,Z FROM ".$prefix."Element WHERE PageID = '1' ORDER BY `Z` ASC";
	$ergebnis=$mysqli->query($abfrage);
	$out = array();
	while($nachricht = $ergebnis->fetch_object()){
		$nachricht->left = floatval($nachricht->left);
		$nachricht->top = floatval($nachricht->top);
		$nachricht->width = floatval($nachricht->width);
		$nachricht->height = floatval($nachricht->height);
		$nachricht->rotate = floatval($nachricht->rotate);
		$nachricht->pid = intval($nachricht->pid);
		$nachricht->Z = intval($nachricht->Z);

		$out[$nachricht->id]=$nachricht;
	}
	echo "var elements = ";
	echo json_encode($out);
	echo ";\n";

	
	$abfrage = "SHOW TABLE STATUS LIKE '".$prefix."Text'";
	$ergebnis=$mysqli->query($abfrage);
	$maxid = $ergebnis->fetch_object()->Auto_increment;
	echo "var textID = ".$maxid.";\n";
	
	
	$abfrage = "SELECT `Name` AS `id`,`X` AS `left`,`Y` AS `top`,`R` AS `rotate`,`Text` AS `text`,`Size` AS `size`,Z FROM ".$prefix."Text WHERE PageID = '1' AND `Text` <> '' ORDER BY `Z` ASC";
	$ergebnis=$mysqli->query($abfrage);
	$out = array();
	while($nachricht = $ergebnis->fetch_object()){
		$nachricht->left = floatval($nachricht->left);
		$nachricht->top = floatval($nachricht->top);
		$nachricht->rotate = floatval($nachricht->rotate);
		$nachricht->size = intval($nachricht->size);
		$nachricht->Z = intval($nachricht->Z);

		$out[$nachricht->id]=$nachricht;
	}
	echo "var textElements = ";
	echo json_encode($out);
	echo ";";

}
?>
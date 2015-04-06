<?php
include "base.php";
printHead();
$result = $mysqli->query("SELECT * FROM ".$prefix."Book WHERE UserID = '".$AccountID."' ORDER BY ID ASC");
?>
		<h1>
			Photobooks
		</h1>
		<form action="photobooks" method="post" class="box">
			<div class="boxheader">Create new Photobook:</div>
			<input type="hidden" name="type" value="add-photobook"/>
			<input type="text" name="photobook-name" value="Photobook Name"/>
			<input type="submit" value="Create"/>
		</form>
		<h2>My Photobooks</h2>
		<div class="boxes3">
<?php
while($row = $result->fetch_object()){
	if($row->Name == ''){$row->Name = 'Unnamed Photobook';}
echo '
			<a href="photobook-'.$row->ID.'" class="box">
				<div class="boxheader">'.$row->Name.'
				</div>
				<img src="preview-book/'.$row->Bild.'" class="gallerynopic"/>
			</a>
			<a href="photobooks?type=delete-photobook&id='.$row->ID.'" class="boxicon">
				<img src="gfx/icon_delete.png"/>
			</a>
';
}
?>
		</div>		
<?php
printFoot();
?>
<?php
include "base.php";
printHead();
$stmt = $mysqli->prepare("SELECT NameOnServer FROM ".$prefix."Picture WHERE GalleryID=? ORDER BY ID DESC LIMIT 4");
$result = $mysqli->query("SELECT * FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' ORDER BY ID ASC");
?>
		<h1>
			Galleries
		</h1>
		<form action="galleries" method="post" class="box">
			<div class="boxheader">Create new Gallery:</div>
			<input type="hidden" name="type" value="add-gallery"/>
			<input type="text" name="gallery-name" value=""/>
			<input type="submit" value="Submit"/>
		</form>
		<h2>My Galleries</h2>
		<div class="boxes3">
<?php
while($row = $result->fetch_object()){
	if($row->Name == ''){$row->Name = 'Unnamed Gallery';}
echo '
			<a href="gallery-'.$row->ID.'" class="box">
				<div class="boxheader">'.$row->Name.'
				</div>';
	$stmt->bind_param("i", $row->ID);
    $stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows == 0){
echo '
					<img src="gfx/no-picture.png" class="gallerynopic"/>
';
	}else{
		$stmt->bind_result($filename);
		while($stmt->fetch()){
echo '
					<img src="thumb/'.$filename.'?type=rect" class="gallerypic"/>
';
		}
	}
echo'
			</a>
			<a href="galleries?type=delete-gallery&id='.$row->ID.'" class="boxicon">
				<img src="gfx/icon_delete.png"/>
			</a>
';
}
?>
		</div>		
<?php
printFoot();
?>
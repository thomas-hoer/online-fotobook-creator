<?php
include "base.php";
printHead();
$GalleryID = intval($_REQUEST['id']);
$result = $mysqli->query("SELECT * FROM ".$prefix."Gallery WHERE ID = '".$GalleryID."' AND UserID = '".$AccountID."'");
if($result->num_rows == 0){
	$result = $mysqli->query("SELECT * FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' ORDER BY ID ASC LIMIT 1");
}
$Gallery = $result->fetch_object();
if($Gallery->Name == ''){$Gallery->Name = 'Unnamed Gallery';}
$result = $mysqli->query("SELECT * FROM ".$prefix."Picture WHERE GalleryID = '".$GalleryID."' ORDER BY ID ASC");
?>
		<h1>
			<?php echo $Gallery->Name; ?>
		</h1>
		<form action="gallery-<?php echo $GalleryID; ?>" enctype="multipart/form-data" method="post" class="box">
			<div class="boxheader">Upload Picture</div>
			<input type="hidden" name="type" value="upload-file"/>
			<input type="file" name="file" value=""/>
			<input type="submit" value="Upload"/>
		</form>

		<p style="text-align:justify">
<?php
while($row = $result->fetch_object()){
echo '<img src="thumb/'.$row->NameOnServer.'" style="height:150px;" /> ';
}
?>
		</p>

<?php

printFoot();
?>
<?php
include "base.php";
$GalleryID = intval($_REQUEST['id']);
if($_REQUEST['action']=='edit'){
	$script = '<script type="text/javascript" src="js/delete-picture.js"> </script>';
}else{
	$script = '<script type="text/javascript" src="js/upload-picture-gallery.js"> </script>
		<script type="text/javascript">var galleryID ='.$GalleryID.'; </script>';
}
printHead($script);
$result = $mysqli->query("SELECT * FROM ".$prefix."Gallery WHERE ID = '".$GalleryID."' AND UserID = '".$AccountID."'");
if($result->num_rows == 0){
	$result = $mysqli->query("SELECT * FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' ORDER BY ID ASC LIMIT 1");
}
$Gallery = $result->fetch_object();
if($Gallery->Name == ''){$Gallery->Name = 'Unnamed Gallery';}
$result = $mysqli->query("SELECT * FROM ".$prefix."Picture WHERE GalleryID = '".$GalleryID."' ORDER BY ID ASC");


if($_REQUEST['action']=='edit'){
?>
		<form action="gallery-<?php echo $GalleryID; ?>" method="post" class="box">
			<input type="hidden" name="type" value="update-gallery"/>
			<input type="text" name="name" value="<?php echo $Gallery->Name; ?>" /><br/>
			<input type="submit" value="Save"/>
		</form>
			

<?php
if($result->num_rows==0){
echo '
		<h2 class="no-pictures">There are no Pictures in this Gallery</h2>
';
}
?>
		<p class="piccontainer">
<?php
while($row = $result->fetch_object()){
echo '			<img src="thumb/'.$row->NameOnServer.'" />
			<a href="gallery-'.$GalleryID.'-edit?type=delete-picture&pid='.$row->ID.'" class="boxicon" style="left: -48px;top: -10px;margin-right:-52px" pid="'.$row->ID.'">
				<img src="gfx/icon_delete.png"/>
			</a>
 ';
}
?>
		</p>
<?php
}else{

?>
		<h1>
			<?php echo $Gallery->Name; ?>
		</h1>
		<form action="gallery-<?php echo $GalleryID; ?>" enctype="multipart/form-data" method="post" class="box">
			<div class="boxheader">Upload Picture</div>
			<input type="hidden" name="type" value="upload-file"/>
			<input type="file" name="file" value="" accept="image/*;capture=camera"/>
			<input type="submit" value="Upload"/>
		</form>
<?php
if($result->num_rows==0){
echo '
		<h2 class="no-pictures">There are no Pictures in this Gallery</h2>
';
}
?>
		
		<p class="piccontainer">
<?php
while($row = $result->fetch_object()){
echo '<img src="thumb/'.$row->NameOnServer.'" /> ';
}
?>
		</p>
		<p>
			<a href="gallery-<?php echo $Gallery->ID; ?>-edit" class="box">Edit </a>
			<a href="galleries?type=delete-gallery&id=<?php echo $Gallery->ID; ?>" class="box">Delete</a>
		</p>
<?php
}
printFoot();
?>
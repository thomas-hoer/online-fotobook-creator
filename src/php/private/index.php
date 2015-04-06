<?php
include "base.php";
printHead();
$stmt = $mysqli->prepare("SELECT NameOnServer FROM ".$prefix."Picture WHERE GalleryID=? ORDER BY ID DESC LIMIT 4");
$result = $mysqli->query("SELECT * FROM ".$prefix."Gallery WHERE UserID = '".$AccountID."' ORDER BY ID ASC LIMIT 3");
?>
		<h1>
			Wellcome Stranger,
		</h1>
		<p>
			you are here to create to create a Photobook online without install any Software on your Computer. Curently there is no possibity to export those Photobooks, but this will be changed soon. However your design is stored online and you can export your Book as soon as the first export is implemented.
		</p>
		<p>
			You might also want to give a feedback or probably you wanna tell us what to improve next. For this please use the Feedback button below.<br/>
			<a href="feedback">Feedback</a>
		</p>
		<h2>
			Latest Galleries
		</h2>
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
';
}
?>
		</div>
<?php
printFoot();
?>
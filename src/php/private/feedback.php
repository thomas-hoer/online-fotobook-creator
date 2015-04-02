<?php
include "base.php";
printHead();
	$msg = "";
if($sendOK==true){
	$msg = '<div class="msg-success">Thank you for your Feedback.</div>';
}
if($sendFail==true){
	$msg = '<div class="msg-fail">Please write some text for your Feedback</div>';
}
?>
		<h1>
			Feedback
		</h1>
		<p>
			Please let us know how to improve our services.
			<?php echo $msg;?>
		</p>
		<form action="feedback" method="post">
			<input type="hidden" name="type" value="feedback"/>
			<textarea name="text" rows="10"></textarea>
			<input type="submit" value="Submit"/>
		</form>
<?php
printFoot();
?>
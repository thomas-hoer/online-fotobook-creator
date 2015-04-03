<?php
include "base.php";
printHead();
?>
		<h1>
			My Account
		</h1>
		<div class="boxes2">
			<form action="account" method="post" class="box">
				<div class="boxheader">Change E-Mail:</div>
				<?php 
				if($_REQUEST['type']=='account-mail'){
					if($sendOK){echo '<div class="msg-success">The update of your new E-Mail was successfull</div>';} 
					if(!$sendOK){echo '<div class="msg-fail">The update of your new E-Mail was not successfull</div>';} 
				}
				?>
				<input type="hidden" name="type" value="account-mail"/>
				<input type="text" name="mail" value="<?php echo $User->Mail; ?>"/>
				<input type="submit" value="Submit"/>
			</form>
			<form action="account" method="post" class="box pwform">
				<div class="boxheader">Change Password:</div>
				<?php 
				if($_REQUEST['type']=='account-pw'){
					if($sendOK){echo '<div class="msg-success">The update of your Password was successfull</div>';}
					if(!$sendOK){echo '<div class="msg-fail">The update of your Password was not successfull</div>';}
				}
				?>
				<input type="hidden" name="type" value="account-pw"/>
				<input type="password" name='pw' class="pw" value=""/>
				<input type="password" name='pw1' class="pw1" value=""/>
				<input type="password" name='pw2' class="pw2" value=""/>
				<input type="submit" value="Submit"/>
			</form>
		</div>

<?php
printFoot();
?>
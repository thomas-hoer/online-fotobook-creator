<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Online Fotobook Creator</title>
		<script type="text/javascript" src="js/jquery-2.1.3.js"> </script>
		<script type="text/javascript" src="js/register.js"> </script>
		<link rel="stylesheet" type="text/css" href="css/register.css"/>
	</head>
	<body>
		<div class="logo">
			<a href="index"><img src="gfx/logo_small.png" class="logoimg" /></a>
			<div class="title">
				Register for <br/>
				Online Fotobook Creator
			</div>
		</div>
		<?php
			switch($error){
				case 'login_exists':
					echo '<div class="error">Loginname already exists</div>';
				break;
				case 'nologin':
					echo '<div class="error">Please type in a Loginname</div>';
				break;
				case 'password_wrong':
					echo '<div class="error">The control Password did not mach with the first Password</div>';
				break;
			}
		?>
		<form action="register" method="post" class="content">
			<input type="hidden" name="type" value="register"/>
			<input type="text" name="login" class="login" value="Login" /><br/><br/>
			<input type="text" name="mail" class="mail" value="E-Mail" /><br/><br/>
			<input type="password" name="password" class="password" value="Password" /><br/><br/>
			<input type="password" name="password2" class="password2" value="Repeat Password" /><br/><br/>
			<input type="submit" value="Register"/>
		</form>
	</body>
</html>
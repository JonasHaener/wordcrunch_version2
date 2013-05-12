<?php
// DB connection
require_once('../application/modules/helpers/wc-db-class-connect.inc.php');
// PW hashing library
require_once('../library/password_compat/lib/password.php');
// login controller class
require_once('../application/modules/login/controllers/wc-login-class-control.inc.php');
// login logic
require_once("../application/modules/login/wc-login-logic.inc.php");
// session
require_once("../application/modules/login/wc-session-class.inc.php");
?>
<!DOCTYPE HTML>
<html class="cssgradients">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>login|wordcrunch</title>
<link type="text/css" rel="stylesheet" href="css/wc-main.css">
</head>
<body>
<div class="login_module backgr-grey-l">
		<div class="top_bar @backgr-win-blue backgr-win-purple"></div>
		<div id="container">
			<section id="login_page" class="border-thin-grey">
				<div id="login_form" class="backgr-win-white">
				<?php 
				if ($LOGIN_ERROR) { echo "<p class='error margin-bottom-1em'>{$LOGIN_ERROR}</p>";
				} ?>
				<form action="" method="post">
						<label for="username" class="margin-bottom-0_5em">Name:&nbsp;</label>
						<input type="text" id="username" name="username" class="focus field-border" required placeholder="Your username">
						<label for="password" class="margin-bottom-0_5em">Password:&nbsp;</label>
						<input type="password" id="password" name="password" class="focus field-border" required placeholder="Your password">
						<input type="submit" class="gradient-black-rgb-vlight box-shadow-lit" id="submit" name="login" value="Submit">	
					</form>				
				</div>
			</section>
		</div>
	</div>
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src=""></script>
</body>
</html>

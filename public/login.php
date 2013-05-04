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
<html class="cssgradients"><!-- InstanceBegin template="/Templates/wordcruch.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>login|wordcrunch</title>
	<!-- InstanceEndEditable -->
	<!-- InstanceBeginEditable name="head" -->
	<link type="text/css" rel="stylesheet" href="css/wc-main.css">
	<script src="libs/js/calculator/modernizr.custom.59742_all_features.js"></script>
	<!-- InstanceEndEditable -->
</head>
<body>
<!-- InstanceBeginEditable name="body2" -->
	<div id="login_module" class="backgr-grey-l">
		<div class="top_bar backgr-win-blue"></div>
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
						<input type="submit" class="gradient-black-rgb-vlight box-shadow-lit" id="submit" name="login">	
					</form>				
				</div>
			</section>
		</div>
	</div>
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src=""></script>
<!-- InstanceEndEditable -->
<!--<script src="../js/libs/jQuery-v1.8.2.js"></script>-->
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src="js/modules/helpers/wc-helpers.js"></script>
<script src="js/modules/db/control/wc-db-control.js"></script>
<script src="js/modules/db/model/wc-db-model.js"></script>
<script src="js/modules/db/view/wc-db-view-update.js"></script>
<script src="js/modules/interface/wc-db-navi.js"></script>
</body>

<!-- InstanceEnd --></html>

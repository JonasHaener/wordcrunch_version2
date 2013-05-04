<?php
/*
 * Login logic
 * Controls login procedure
 *
 *
 */
$LOGIN_ERROR = "";

function WC_login_logic( $user_input, &$error, &$session ) {
	
	// redirect to main page on successfull login
	$REDIRECT = "http://localhost/wordcrunch_5/public";
	// db connection
	$db = new WC_DB_connect("localhost", "wordcrunch", "<88>>cru99**ncher", "wordcrunch", "mysqli");
	// call model and pass db connection
	$model = new WC_LOGIN_model($db->conn);
	// call controller, pass model and userinput
	$controller = new WC_LOGIN_controller($model, $user_input);
	// call view, pass model, controller
	$view = new WC_LOGIN_view($model, $controller);
	// close connection
	$db->conn->close();
	// if login successful redirect
	// if not successfull call error and display on login page
	// create user session
	if ($view->get_login() === true) {
		session_start();
		ob_start();
		$_SESSION = array();
		$_SESSION['authenticated'] = "login_ok";
		// loged in username
		$_SESSION['username'] = $view->get_user();
		// access rights level 0, 1 or 2
		$_SESSION['rights_level'] = $view->get_rights();
		session_regenerate_id();
		// redirect to main page
		header("Location:{$REDIRECT}");
		exit;
	} else {
		$error = $view->get_error();
	}
	
}
// if $_POST is set run login logic
if( isset($_POST['username']) && isset($_POST['password']) ) {
	WC_login_logic( $_POST, $LOGIN_ERROR, $session);
}


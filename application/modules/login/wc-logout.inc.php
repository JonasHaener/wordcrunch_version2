<?php
session_start();
ob_start();
$redirect_to_login = "login.php";
if (isset($_SESSION['authenticated'])) {
		echo "SET";
		//empty session array
		$_SESSION = array();
		// invalidate session cookie
		if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(),'', time()-86400, '/');
		}
		//end session and redirect
		session_destroy();
		header("Location: {$redirect_to_login}");
		exit;	
} else {
	header("Location: {$redirect_to_login}");
}

<?php
session_start();
ob_start();

// ===================
// ===================
// ===================
// 203-04-27 Continue here working with sessin login
// ===================
// ===================
// ===================
// redirect to login page
$redirect_to_login = "login.php";
//set a time limit in seconds
$timelimit = 20*60; //15 minutes
//get current time
$now = time();
// if session variable not set redirect to login
if (!isset($_SESSION['authenticated'])) {
		header("Location: {$redirect_to_login}");
		exit;
		
} elseif ($now > $_SESSION['start'] + $timelimit) {
// time limit reached
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-86400, '/');
	}
	// end session and destroy
	session_destroy();
	header("Location: {$redirect_to_login}?expired=yes");
	exit;

} else {
	// if this far session can be updated
	$_SESSION['start'] = time();
}

/*
if ($tmp[0] == $username && rtrim($tmp[1]) == $password) {
						$_SESSION['authenticated'] = "Hello";
						//register time when login was successful
						$_SESSION['start'] = time();
						session_regenerate_id();
						$login_ok = true; //used for login button confirmation
						break;
				}









*/



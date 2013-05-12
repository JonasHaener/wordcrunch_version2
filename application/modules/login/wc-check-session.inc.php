<?php
session_start();
ob_start();
// variable for redirection to login page
$redirect_to_login = "http://127.0.0.1/wordcrunch_version2/public/login.php";
// if session variable not set redirect to login
if (!isset($_SESSION['authenticated'])) {
	header("Location: {$redirect_to_login}");
	exit;
} else {
	$SESS_AUTH 		= $_SESSION['authenticated'];
	$SESS_USER		= $_SESSION['username'];
	$SESS_RIGHTS	= $_SESSION['rights_level'];
}
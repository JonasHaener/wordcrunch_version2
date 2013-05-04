<?php
session_start();
ob_start();
// variable for redirection to login page
$redirect_to_login = "login.php";
// if session variable not set redirect to login
if (!isset($_SESSION['authenticated'])) {
	header("Location: {$redirect_to_login}");
	exit;
} else {
	$sess_auth 		= $_SESSION['authenticated'];
	$sess_user 		= $_SESSION['username'];
	$sess_rights	= $_SESSION['rights_level'];
}
<?php
class WC_LOGIN_session
{
		public $sess_auth;
		public $sess_user;
		public $sess_rights;
		// constructor
		public function __construct( $view ) {
			session_start();
			ob_start();
			$_SESSION = array();
			// authorization
			$_SESSION['authenticated'] = "login_ok";
			$this->sess_auth = $_SESSION['authenticated'];
			// loged in username
			$_SESSION['username'] = $view->get_user();
			$this->sess_user = $_SESSION['username'];
			// access rights level 0, 1 or 2
			$_SESSION['rights_level'] = $view->get_rights();
			$this->sess_rights = $_SESSION['rights_level'];
			session_regenerate_id();
		}
}
<?php
/*
 * LOGIN CONTROLLER
 *
 */

class WC_LOGIN_model
{		
		public $model;
		public $conn;
		public $res;
		public $err = "";
		public $user;
		public $rights;
		// constructor
		public function __construct( $conn ) {
			$this->conn = $conn;
		}
		// fetcher query function
		public function fetch( $user_name, $pw ) {
			$sql_pw = "SELECT username, password, rights FROM users WHERE username = ?";
			$user_pw = "";
			$search_term = "{$user_name}";
			$stmt = $this->conn->stmt_init();
			
			if ( $stmt->prepare($sql_pw) ) {
				$stmt->bind_param('s', $search_term);
				$stmt->bind_result($username, $password, $rights);
				$stmt->execute();
				$stmt->store_result();
				
				while ( $stmt -> fetch() ) {
					$user_pw = $password;
					$this->rights = $rights;
					$this->user = $username;
					
				}
				// free results
				$stmt->free_result();
				// assign results
				//$this->res = ( crypt($pw, $user_pw) === $user_pw ) ? true : false;
				
				// uses PASSWORD_COMPAT library
				$this->res = ( password_verify($pw, $user_pw) ) ? true : false;
				//echo 'works';
				$this->err = ( $this->res === true ) ? "" : "Username or password incorrect :(";
				
				/*
				$hash = password_hash($password, PASSWORD_BCRYPT);
				*/
			}
	}
}


class WC_LOGIN_controller
{		
		public $model;
		// constructor
		public function __construct($model, $user_input) {
			
			$this->model = $model;
			$this->model->fetch($user_input['username'], $user_input['password']);
			
		}
}

class WC_LOGIN_view
{		
		public $error;
		public $model;
		public $controller;
		public $user;
		public $rights;
		// constructor
		public function __construct($model, $controller) {
			$this->model = $model;
			$this->controller = $controller;
			$this->error = $model->err;
			$this->user = $model->user;
			$this->rights = $model->rights;
		}
		// fetcher query function
		public function get_login() {
			// return model result
			return $this->model->res;
		}
		// send error message
		public function get_error() {
			return $this->error;
		}
		public function get_user() {
			return $this->user;
		}
		public function get_rights() {
			return $this->rights;
		}
}


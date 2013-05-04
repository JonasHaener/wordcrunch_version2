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
		// constructor
		public function __construct( $conn ) {
			
			$this->conn = $conn;

		}
		
		// fetcher query function
		public function fetch( $user_name, $pw ) {
			
			 $sql = "SELECT username, password FROM users WHERE username = '{$user_name}' AND password = '{$pw}'";
			 $sub_res = $this->conn->query($sql);
			 $this->res = ($sub_res->num_rows < 1) ? false : true;
			 $this->err = ($this->res === false) ? "Username or password incorrect :(" : "";
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
		// constructor
		public function __construct($model, $controller) {
			$this->model = $model;
			$this->controller = $controller;
			$this->error = $model->err;	
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
}


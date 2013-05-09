<?php
/*
 * DB KW DATALIST MODEL
 *
 */

/**---------------------------
		CLASS – Fetch data from database
 ---------------------------**/
class WC_DATALIST_model
{		
		private $db_conn;
		private $data_type;
		private	$res_arr = array();
		public $res_data = "";
		// write json data
		private function write_json($data) {
			return json_encode( $data );
		}
		// return result
		public function fetch_result() {
			return $this->res_data;
		}
		// fetcher query function
		public function fetch($data_type, $dtl_lang) {
			$lang = $dtl_lang;
			// avoid injection, acceptable values "german" and "english"
			if ($lang === "german" || $lang === "english") {
				// sql query for is search
				$sql = "SELECT $lang FROM keywords";
				$res = $this->db_conn->query($sql);
				while( $row = $res->fetch_assoc() ) {
					$this->res_arr[] = $row;
				}
				$res->free_result();
				if ($data_type === 'json') {
					$this->res_data = $this->write_json($this->res_arr);
				}
			}
		}
		// constructor
		public function __construct($connection, $data_type)
		{
			$this->db_conn = $connection;
			$this->data_type = $data_type;
		}
}

class WC_DATALIST_controller
{
		private $model;
		// constructor
		public function __construct($model, $data_type, $dtl_lang)
		{
			$this->model = $model;
			// initialize data_fetch from model
			$this->model->fetch($data_type, $dtl_lang);
		}
}


class WC_DATALIST_view
{
		private $model;
		private	$controller;
		// return result
		public function get_result() {
			return $this->model->fetch_result();
		}
		// constructor
		public function __construct($model, $controller)
		{
			$this->model 			= $model;
			$this->controller	= $controller;
		}
}
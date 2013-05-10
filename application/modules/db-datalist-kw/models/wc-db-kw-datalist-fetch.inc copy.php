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
		public $res_data = "";
		// return result
		public function fetch_result() {
			//return $this->res_data;
			return $this->res_data;
		}
		private function write_tubed($res, $dtl_lang) {
			$res_tubed = "";
			$row;
			while( $row = $res->fetch_assoc() ) {
				// only assign if result is not empty
				if ($row[$dtl_lang] !== "") {
					$res_tubed = ($res_tubed !== "") ? $res_tubed."|".$row[$dtl_lang] : $row[$dtl_lang];
				}
			}
			// release result
			$res->free_result();
			return $res_tubed;
		}
		// fetcher query function
		public function fetch($data_type, $dtl_lang) {
			// $datatype is used to output different formats
			// avoid injection, acceptable values "german" and "english"
			if ($dtl_lang === "german" || $dtl_lang === "english") {
				// sql query for is search
				$sql = "SELECT $dtl_lang FROM keywords";
				$res = $this->db_conn->query($sql);
				// $data_type tubes
				if ($data_type === "tubed") {
					$this->res_data = $this->write_tubed($res, $dtl_lang);
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
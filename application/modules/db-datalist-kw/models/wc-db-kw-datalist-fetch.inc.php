<?php
/*
 * DB MODEL
 *
 */

/**---------------------------
		CLASS – WC_DB_fetch
		fetch data from database
 ---------------------------**/
class WC_DB_fetch
{		
		private $db_conn;
		public $res_arr = array();
		// fetcher query function
		private function fetcher() {
			// sql query for is search
			$sql_id = "SELECT german FROM keywords";
			$res = $this->db_conn->query($sql_id);
		
			while( $row = $res->fetch_assoc() ) {
				$this->res_arr[] = $row;
				$res->free_result();
			}
			$this->db_conn->close();	
		}

		// constructor
		public function __construct($connection)
		{
			$this->db_conn = $connection;
		}
}


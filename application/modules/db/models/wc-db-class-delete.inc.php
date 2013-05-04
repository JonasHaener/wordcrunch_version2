<?php
/*
 * DB MODEL
 *
 */

/**---------------------------
		CLASS – WC_DB_update
		delete from database
 ---------------------------**/
class WC_DB_delete
{	
		private $db_conn;
		public $db_res = array();
		private $stmt;
		// constructor
		public function __construct($host, $user, $passw, $db, $connectionType, $update)
		{
			
			// call DB connection class establish connection
			$connected = new WC_DB_connect($host, $user, $passw, $db, $connectionType);
			// assign connection
			$this->db_conn = $connected->conn; 													
			// in case of error assign error to result
			if ($connected->err) {
				$this->db_res = $connected->err;
			} else {		
				// call fetcher and send db query
				$this->fetcher( $update );
			}
		}
		// fetcher query function
		private function fetcher( $input ) {	
				// if the id to update is not numeric then return immediately	
				if ( !is_numeric($input['id_to_edit']) ) {
						return;
				}
				//prepare statement	
				// sql query for term search
				$sql = "DELETE FROM keywords WHERE id='{$input['id_to_edit']}'"; 
				// if query yields results execute search			
				$this->db_conn->query($sql);
				// assign success message
				if($this->db_conn->affected_rows > 0) {
					$this->db_res[0] = array('status' => "Entry deleted");
				} else {
					$this->db_res[0] = array('status' => "Entry not deleted");
				}
				$this->db_conn->close();
		}
		// destructor
		private function __destruct()
		{
			
		}
}
<?php
/*
 * DB MODEL
 *
 */

/**---------------------------
		CLASS – WC_DB_create
		add records to database
 ---------------------------**/
class WC_DB_create
{		
		public $db_res = array();
		private $db_conn;
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
		private function fetcher( $insert ) {
				//prepare statement	
				$stmt = $this->db_conn->stmt_init();
				// sql query for term search
				// id > auto_increment !!
				$sql_term = "INSERT INTO keywords (german,english,french,dutch,japanese,italian,spanish,comments)
				VALUES(?,?,?,?,?,?,?,?)";
				// if query yields results execute search			
				if ($stmt->prepare( $sql_term )) {
					//var_dump($stmt);
					$stmt->bind_param(
							'ssssssss',
							$insert['edit_german'],
							$insert['edit_english'], // string
							$insert['edit_french'], // string
							$insert['edit_dutch'], // string
							$insert['edit_japanese'], // string
							$insert['edit_italian'], // string
							$insert['edit_spanish'], // string
							$insert['edit_comments'] // string
							);
					$stmt->execute();
					$r = $stmt->store_result();
					// assign result of operation
					if($r > 0) {
						$this->db_res[0] = array('status' => "Entry created");
					} else {
						$this->db_res[0] = array('status' => "Entry not created");
					}
					// free results
					$stmt->free_result();
					// close connection
					$stmt->close();
					$this->db_conn->close();
					
				}
		}
		// destructor
		private function __destruct()
		{
			
		}
}

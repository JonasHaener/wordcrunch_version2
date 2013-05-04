<?php
/*
 * DB MODEL
 *
 */


/**---------------------------
		CLASS – WC_DB_update
		update and enter to database
 ---------------------------**/
class WC_DB_updater
{	
		public $db_res = array();
		private $db_conn;
		private $stmt;
		// constructor
		public function __construct($host, $user, $passw, $db, $connectionType, $upd)
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
				$this->fetcher( $upd );
			}
		}
		// fetcher query function
		private function fetcher( $upd ) {	
				// if the id to update is not numeric then return immediately	
				if ( !is_numeric( $upd['id_to_edit']) ) {
						return;
				}
						
				//prepare statement	
				$stmt = $this->db_conn->stmt_init();
				// sql query for term search
				$sql_term = "UPDATE keywords 
								SET 
								german	= ?,
								english	= ?,
								french	= ?,
								dutch		= ?,
								japanese	= ?,
								italian	= ?,
								spanish	= ?,
								comments	= ?
								WHERE id	= ?";
				// if query yields results execute search			
				
				if ($stmt->prepare( $sql_term )) {
					//var_dump($stmt);
					$stmt->bind_param(
							'ssssssssi',
							$upd['edit_german'],
							$upd['edit_english'], // string
							$upd['edit_french'], // string
							$upd['edit_dutch'], // string
							$upd['edit_japanese'], // string
							$upd['edit_italian'], // string
							$upd['edit_spanish'], // string
							$upd['edit_comments'], // string
							$upd['id_to_edit'] // (id) integer
							);
					
					$stmt->execute();
					$r = $stmt->store_result();
					// assign result of operation
					// free results
					$stmt->free_result();
					// close connection
					$stmt->close();
					$this->db_conn->close();
				
					if( $r > 0 ) {
						$this->db_res[0] = array('status' => "Entry updated");
						//WC_db_writer($this->db_res);
					} else {
						$this->db_res[0] = array('status' => "Not updated, try again");
					}
						//echo 'works';
				}
		}
		// destructor
		private function __destruct()
		{
			
		}
}


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
		private $usr_id;
		// constructor
		public function __construct($host, $user, $passw, $db, $connectionType, $upd, $user_id)
		{
			$this->usr_id = (int)$user_id;
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
				
				$sql_lock = "LOCK TABLES keywords WRITE";		
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
								comments	= ?,
								user_id = ?
								WHERE id	= ?";
								
				//prepare statement	
				$stmt = $this->db_conn->stmt_init();
				if ($stmt->prepare( $sql_term )) {
					//var_dump($stmt);
					$stmt->bind_param(
							'ssssssssii',
							$upd['edit_german'],
							$upd['edit_english'], // string
							$upd['edit_french'], // string
							$upd['edit_dutch'], // string
							$upd['edit_japanese'], // string
							$upd['edit_italian'], // string
							$upd['edit_spanish'], // string
							$upd['edit_comments'], // string
							$this->usr_id,
							$upd['id_to_edit'] // (id) integer
							);
							
					$this->db_conn->query($sql_lock);
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
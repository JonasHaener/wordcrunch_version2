<?php
/*
 * DB HELPERS
 *
 */

/**---------------------------------------
		CLASS – WC_DB_connect
		connect to database mysqli or PDO
 ---------------------------------------**/
class WC_DB_connect
{
		// holds public DB connection
		public $conn;
		// holds errors
		public $err="";
		// construct
		public function __construct($host, $user, $passw, $db, $connectionType) {		
				if ($connectionType === 'mysqli') {
					$this->conn = new mysqli("localhost", "jonasCanAll", "fridolin88", "wordcrunch") or die ('Cannot open database');
					// assign error in case
					if ($this->conn->connect_errno) {
						$this->err = "failed to connect:{$conn->connect_error}";
					}
				} elseif ($connectionType === 'pdo') {
				  	try {
					$this->conn = new PDO("mysql:host = $host; dbname = $db", $user, $pwd); 
					// catch connection error
					} catch(PDOException $e) {
					  return 'Cannot connect to database';
					  // exit connection if error
					  exit;
					}
				}
		}
		// destruct
		public function __destruct()
		{
			
		}	
}
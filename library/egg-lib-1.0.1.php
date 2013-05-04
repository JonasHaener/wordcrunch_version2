<?php

//=== Connection class =======
class SayName {
	
	public $myName = "";
	
	public function __construct($name) {
			$this->myName = $name;
	}
	
	public function returnName() {
		return $this->myName;
	
	}
}

/*
 * getRows() // returns query result
 * numRows() // returns rows count after query
 * releaseDB() // releases query result
 * getResultsTable() // assembles results into a HTML table <tr>...</tr><tr>...</tr>
 * dbConnect() // !! private // establishes connection
 *
*/

class DBconnect {
	
	public $db;
	public $result;
	
	public function getRows($query) {
		$this->result = $this->db->query($query);
		return $this->result;
	}
	public function numRows($query) {
		return $this->result->num_rows;
	}
	public function releaseDB() {
		$this->result->free_result();
	}

	public function getResultsTable($cols) {
		$res = $this->result;
		$row = "";
		$rowFrag = "";
		$table = "";
		$c;
		while ($row = $res->fetch_assoc() ) {
				
			for ($c = 0; $c < count($cols); $c++) {
					$rowFrag .= "<td>".$row[$cols[$c]]."</td>";
				
			}
		$table .= "<tr>".$rowFrag."</tr>";
		$rowFrag = "";
		
		}
		return $table;
	}

	private function dbConnect($host, $user, $passw, $db, $connectionType) {
			// establish connection
			if ($connectionType === 'mysqli') {
					$conn = new mysqli($host, $user, $passw, $db) or die ('Cannot open database');
					if ($conn->connect_errno) {
							echo "failed to connect:{$conn->connect_error}";
					}
					$this->db = $conn;
				} else {
				try {
						$conn = new PDO("mysql:host = $host; dbname = $db", $user, $pwd); 
						$this->db = $conn;
	
					} catch(PDOException $e) {
						return 'Cannot connect to database';
						exit;
					}
				}
			}
	
	function __construct($host, $user, $passw, $db, $connectionType = 'mysqli') {
		$this->dbConnect($host, $user, $passw, $db, $connectionType);
	}

}

//==== Connect MySQL ========

function dbConnect($host, $user, $passw, $db, $connectionType = 'mysqli') {
	// establish connection
	if ($connectionType === 'mysqli') {
			$conn = new mysqli($host, $user, $passw, $db) or die ('Cannot open database');
			if ($conn->connect_errno) {
					echo "failed to connect:{$conn->connect_error}";
			} else if ($conn) {
				//	echo "db connection established";
				
			}
			return $conn;
			
	} else {
			try {
				$conn = new PDO("mysql:host = $host; dbname = $db", $user, $pwd); 
				return $conn;
	
			} catch(PDOException $e) {
				return 'Cannot connect to database';
				exit;
				
			}
	}

}


//==== return special chars ENT_QUO ========

function specialCharENT_QUO($inp) {
	return htmlspecialchars($inp);
}

//==== validate a password against an input ========
/*
 * returns true if match
 * returns false when no match
 */
function validate_pwd($name,$pwd,$db_name,$db_pwd) {
		if ($name === $db_name && $pwd === $db_pwd) {
				return true;
		} else {
				return false;
		}
}







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
		public $db_res = array();
		private $db_conn;
		private $stmt;
		private $sear_arr;
		// fetcher query function
		private function fetcher( $search ) {
			
			// split input into array
			$this->sear_arr = explode(",", $search);
			// initialize prepared statement
			$this->stmt = $this->db_conn->stmt_init();
			/*======================================
				if first array item is numeric
			======================================*/
			function search_id($array, $connection) {
				
				$c;
				$res_arr = array();
				foreach ($array as $item ) {
					 $search_id = $item;
					 // sql query for is search
					 $sql_id = "SELECT id, german, english, french, dutch, japanese, italian, spanish,comments, updated 
									FROM keywords WHERE id = '{$search_id}'";
					 $res = $connection->query($sql_id);
	
					 // if results loop results
					 while( $row = $res->fetch_assoc() ) {
						$res_arr[] = $row;
						$res->free_result();	
					}
				}
				// return results to class
				return $res_arr;
			}
			/*======================================
				if no numeric assign as string
			======================================*/
			function search_term ( $array, $connection, $stmt ) {
				// prepare search term for prepared statement
				$search_term_1 = '%' . $array[0] . '%';
				$search_term_2 = '%' . $array[0] . '%';
				$search_term_3 = '%' . $array[0] . '%';
				$search_term_4 = '%' . $array[0] . '%';
				$search_term_5 = '%' . $array[0] . '%';
				$search_term_6 = '%' . $array[0] . '%';
				$search_term_7 = '%' . $array[0] . '%';
				$search_term_8 = '%' . $array[0] . '%';
				// sql query for term search
				$sql_term = "SELECT id, german, english, french, dutch, japanese, italian, spanish,comments, updated 
								FROM keywords WHERE (german LIKE ?) OR (english LIKE ?) OR (french LIKE ?) OR (dutch LIKE ?) OR
								(japanese LIKE ?) OR (italian LIKE ?) OR (spanish LIKE ?) OR (comments LIKE ?)";
				// if query yields results execute search			
				if ($stmt->prepare( $sql_term )) {
					$arr_res = array();
					$stmt->bind_param('ssssssss', $search_term_1, 
											$search_term_2, $search_term_3, 
											$search_term_4, $search_term_5, 
											$search_term_6, $search_term_7, $search_term_8);
					$stmt->bind_result($id, $german, $english, $french, $dutch, $japanese, $italian, $spanish, $comments, $updated);
					$stmt->execute();
					$stmt->store_result();
					// push results rows!! into array
					while ($stmt -> fetch() ) {
							$temp_arr = array();
							$temp_arr['id']				= $id;
							$temp_arr['german']		= $german;
							$temp_arr['english']	= $english;
							$temp_arr['french'] 	= $french; 
							$temp_arr['dutch'] 		= $dutch;
							$temp_arr['japanese']	= $japanese;
							$temp_arr['italian'] 	= $italian;
							$temp_arr['spanish'] 	= $spanish;
							$temp_arr['comments'] = $comments;
							$temp_arr['updated'] 	= $updated;
							// push subresults in results array	
							$arr_res[] = $temp_arr;
					}
					// free results
					$stmt->free_result();
					// return result
					return $arr_res;
				}
			}
			/*======================================
				controls search functions
			======================================*/
			if ( is_numeric($this->sear_arr[0]) ) {
				
				$this->db_res = search_id($this->sear_arr, $this->db_conn);
				$this->db_conn->close();
			} else {
				$this->db_res = search_term( $this->sear_arr, $this->db_conn, $this->stmt );  
				// close statement				
				$this->stmt->close();
				$this->db_conn->close();
			} 
		}
		// release DB
		public function freeRes() {
				//$this->db_res->free_result();
		}
		// constructor
		public function __construct($host, $user, $passw, $db, $connectionType, $search)
		{
			// call DB connection class establish connection
			$connected = new WC_DB_connect($host, $user, $passw, $db, $connectionType);
			// assign connection
			$this->db_conn = $connected->conn; 			
			// in case of error assign error to result
			if ( $connected->err ) {
				$this->db_res = $connected->err;
			} else {		
				// call fetcher and send db query
				$this->fetcher($search);
			}
		}
		// destructor
		private function __destruct()
		{
			// release search result
		}
}


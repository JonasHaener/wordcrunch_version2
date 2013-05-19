<?php
session_start();
//ob_start();
/*
 * DB CONTROLLER
 *
 */
/**---------------------------
		Dependencies
 ---------------------------**/
// abs path

// absolute path included with wc-ajax-kw.php from public folder
//require_once("../../../../config_global/wc-abs-path.inc.php");
require_once($ABS_PATH.'application/modules/helpers/wc-db-class-connect.inc.php');
require_once($ABS_PATH.'application/modules/db-kw/models/wc-db-class-create.inc.php'); //blocking MySQL
require_once($ABS_PATH.'application/modules/db-kw/models/wc-db-class-fetch.inc.php');
require_once($ABS_PATH.'application/modules/db-kw/models/wc-db-class-update.inc.php'); //blocking MySQL
require_once($ABS_PATH.'application/modules/db-kw/models/wc-db-class-delete.inc.php'); //blocking MySQL
require_once($ABS_PATH.'application/modules/db-kw/view/wc-db-view.inc.php');


// AJAX error testing
//sleep(1);
//header("HTTP/1.0 404 Not Found");
//exit();


/**---------------------------
		Controller
 ---------------------------**/
//JSON

$user_id = $_SESSION['id'];

function WC_db_controller( $inp, $user_id ) 
{	
		// database connection
		$db;
		// search data
		if (isset($inp['search'])) {	
			$db = new WC_DB_fetch("localhost", "", "", "wordcrunch", "mysqli", $inp['search']);
		}
		// create data
		if (isset($inp['change_db']) && $inp['change_db'] === "new_entry") {
			$db = new WC_DB_create("localhost", "", "", "wordcrunch", "mysqli", $inp, $user_id);
			//echo 'NEW';
		}
		// update data
		if (isset($inp['change_db']) && $inp['change_db'] === "edit_entry" && isset($inp['id_to_edit']) && $inp['id_to_edit'] !== "") {
			
				$db = new WC_DB_updater("localhost", "", "", "wordcrunch", "mysqli", $inp, $user_id);
				//echo 'UPDATE';
		
		}
		// delete data
		if (isset($inp['change_db']) && $inp['change_db'] === "delete_entry" && isset($inp['id_to_edit']) && $inp['id_to_edit'] !== "" ) {
			$db = new WC_DB_delete("localhost", "", "", "wordcrunch", "mysqli", $inp, $user_id);	
		}
		
		// fetch data for editor form >> Must be last to avoid conflict
		// !! checks if input is_numeric (if blank then it no numeric)
		if (is_numeric($inp['id_to_edit']) && !isset($inp['change_db']) && $inp['change_db'] !== "") {
			$db = new WC_DB_fetch("localhost", "", "", "wordcrunch", 'mysqli', $inp['id_to_edit']);
			//echo 'FETCH';
		}
		
		// send data to returner
		WC_db_writer($db->db_res);
}


// call DB controller
WC_db_controller($_POST, $user_id);
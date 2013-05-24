<?php
/*
 * Keyword datalist fetch
 * retrieves new items via Ajax to search form
 * Controls fetch procedure
 *
 *
 */
 
/**---------------------------
		Dependencies
 ---------------------------**/
// asolute path
require_once($ABS_PATH.'application/modules/helpers/wc-db-class-connect.inc.php');
require_once($ABS_PATH.'application/modules/db-datalist-kw/models/wc-db-kw-datalist-fetch.inc.php');


 
function WC_datalist_logic($data_type, $dtl_lang) {
	// db connection
	$db = new WC_DB_connect("localhost", "wordcrunch", "<88>>cru99**ncher", "wordcrunch", "mysqli");
	// call model and pass db connection

	$model = new WC_DATALIST_model($db->conn);
	
	// call controller, pass model and userinput
	$controller = new WC_DATALIST_controller($model, $data_type, $dtl_lang);
	// call view, pass model, controller
	$view = new WC_DATALIST_view($model, $controller);
	
	// close connection
	$db->conn->close();
	// return JSON
	echo $view->get_result();
}
WC_datalist_logic($_POST['data_type'], $_POST['dtl_lang']);

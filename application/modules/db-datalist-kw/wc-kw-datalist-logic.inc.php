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
require_once('../helpers/wc-db-class-connect.inc.php');
require_once('models/wc-db-kw-datalist-fetch.inc.php');
require_once('view/wc-db-kw-datalist-view.inc.php');


 
 
function WC_datalist_logic($data_type) {
	
	// db connection
	$db = new WC_DB_connect("localhost", "wordcrunch", "<88>>cru99**ncher", "wordcrunch", "mysqli");
	// call model and pass db connection
	$model = new WC_DATALIST_model($db->conn);
	// call controller, pass model and userinput
	$controller = new WC_DATALIST_controller($data_type);
	// call view, pass model, controller
	$view = new WC_DATALIST_view($model, $controller);
	// close connection
	$db->conn->close();
	// return JSON
	echo $view->get_result();
	
}
// if $_POST is set run login logic
if(true) {
	WC_datalist_logic($data_type);
}


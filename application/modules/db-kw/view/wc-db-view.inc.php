<?php
/*
 * DB VIEW
 *
 */

/**---------------------------
		View
 ---------------------------**/
/*
 * DB view
 * prepares input from model
 * and return JSON back to AJAX model
 *
 */

function WC_db_writer($arr_db_data) {	
	$n;
	// returns empty array if not results found
	$res_all = array();
	// loop results array and retrieve subresults from subarrays
	foreach ( $arr_db_data as $n ) {
		$res = array();
		$res['id'] 		  	= $n['id'];
		$res['german']   	= $n['german'];
		$res['english']  	= $n['english'];
		$res['french']   	= $n['french'];
		$res['dutch']    	= $n['dutch'];
		$res['japanese'] 	= $n['japanese'];
		$res['italian']  	= $n['italian'];
		$res['spanish']  	= $n['spanish'];
		$res['comments'] 	= $n['comments'];
		$res['updated']  	= $n['updated'];
		// for normal data retrieval no status is provided == null;
		$res['status']  	= ($n['status']) ? $n['status'] : "null"; // null for use in JavaScript status handling
		// assign subresults to all results array
		$res_all[] = $res;
	}
	// encode as JSON and send data back to Ajax
	echo json_encode($res_all);
}
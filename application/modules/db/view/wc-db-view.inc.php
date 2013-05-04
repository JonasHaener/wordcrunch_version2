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
		// sends status back to AJAX
		$res['status']  	= $n['status'];			
		// assign subresults to all results array
		$res_all[] = $res;
	}
	// encode as JSON and send data back to Ajax
	echo json_encode($res_all);
}
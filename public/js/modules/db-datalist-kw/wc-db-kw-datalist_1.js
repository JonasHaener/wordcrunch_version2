"use strict";

/**---------------------------
		NS Namespace
 ---------------------------**/
if (WC_KW instanceof Object === false) {
	var WC_KW = {};
}
if (WC_A instanceof Object === false) {
	var WC_A = {};
}
// add database object to NS
WC_KW.datalist = {};
// add forms object to NS

/**---------------------------
		Datalist model
 ---------------------------**/
WC_KW.datalist.model = {};
// write datalist
WC_KW.datalist.model.write_datalist = function(res_arr) {
	// res_arr is Array
	var a, dtl = "";
	for (a = 0; a < res_arr.length; a += 1) {
		dtl += "<option value=" + res_arr[a]['german'] + "></option>";
	}
	return dtl;		
};

// JSON data from database
WC_KW.datalist.model.prep_result = function(json_data) {
	// receives format: [{...}][{...}][{...}]
	// check for string type
	if (typeof json_data !== 'string') {
		throw "WC: String input expected";
	}
	var a, b, res_string = "", res_arr = [], js_res_array = [];
	//remove brackets, format: [{...},{...},{...}]
	res_string = json_data.replace(/\]\[/g, ',');
	// extract content, //remove brackets, format: {...},{...},{...}
	res_string = res_string.replace(/\[(.*)\]/g, '$1');
	// split into array
	res_arr = res_string.split(',');
	// convert JSON to JS object
	// push into an Array
	for (a = 0; a < res_arr.length; a += 1) {
		b = WC_A.helper.parse_json(res_arr[a]);
		js_res_array.push(b);
	}
	return js_res_array;
};

// call_type is needed
WC_KW.datalist.model.control = function(call_type, json_data) {
	// pass formatted data to view and call view
	var sub_res = WC_KW.datalist.model.prep_result(json_data), res = "";
	// test for array lenght
	if (sub_res.length > 0 && sub_res instanceof Array) {
		res = WC_KW.datalist.model.write_datalist(sub_res);
		// update view
		WC_KW.datalist.view(res);
	}
};

/**---------------------------
		Datalist view
 ---------------------------**/
WC_KW.datalist.view = function(result) {
	$('#search_list').html(result);
};

/**---------------------------
		Datalist control
 ---------------------------**/
WC_KW.datalist.control = function() {
	// create new ajax object
	var ajax = new WC_A.helper.Ajax( 
	{ 
				'call_type' 	: "", 
				'data'				: "data_type=json",
				'url'					:	'../application/modules/db-datalist-kw/wc-kw-datalist-logic.inc.php',
				'type'				:	'POST',
				'attempts'		:	3,
				'delay'				:	1000,
				'spinnerAdd'	: function(){}, // function
				'spinnerHide'	:	function(){}, // function
				'beforeSend'	: function(){}, // function
				'success'			: WC_KW.datalist.model.control, // function
				'complete'		:	function(){}, // function
				'error'				:	function(){} // function
	});
	// make Ajax call
	ajax.ajx_call();	
	
	setTimeout(function() {
		console.log('start');
		WC_KW.datalist.control();
		// update every 5 minutes
	}, 5000*60*5)
};
WC_KW.datalist.control();
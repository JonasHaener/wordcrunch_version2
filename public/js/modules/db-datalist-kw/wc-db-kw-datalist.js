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
WC_KW.datalist.Model = function() {
	// write datalist
	this.url = '../application/modules/db-datalist-kw/wc-kw-datalist-logic.inc.php';
	this.write_datalist = function(res_arr) {
			var a, dtl = "";
			// res_arr is Array
			for (a = 0; a < res_arr.length; a += 1) {
				dtl += "<option value=" + (res_arr[a]['german'] || res_arr[a]['english'])+ "></option>";
			}
			return dtl;		
	};
	// JSON data from database
	this.prep_result = function(json_data) {
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
	this.control = function(json_data) {
			// pass formatted data to view and call view
			var sub_res = this.prep_result(json_data);
			// test for array lenght
			if (sub_res.length > 0 && sub_res instanceof Array) {
				return this.write_datalist(sub_res);
			}
	};
};

// JSON
WC_KW.datalist.Controller = function() {
  //collect radio button state for dtl language and specify data type
	// to be returned
	// serialized form data
	this.form_data = function() {
		// grab checked radio button
		return "dtl_lang=" + $('input[name=dtl_lang]').filter(':checked').val() + "&" + "data_type=json";
	};
};



/**---------------------------
		Datalist view
 ---------------------------**/
WC_KW.datalist.View = function() {
	this.update = function(result) { 
		$('#search_list').html(result);
	}
};

/**---------------------------
		Datalist control
 ---------------------------**/
WC_KW.datalist.control = function() {
	// create new ajax object
	var ajax = new WC_A.helper.Ajax_dtl(
		{'model': new WC_KW.datalist.Model()},
		{'view': new WC_KW.datalist.View()},
		{'controller': new WC_KW.datalist.Controller()}
	);
	// make Ajax call
	ajax.ajx_call();	
	// set update timer
	setTimeout(function() {
		WC_KW.datalist.control();
	// 5 minutes
	}, 1000*60*5)
};
WC_KW.datalist.control();


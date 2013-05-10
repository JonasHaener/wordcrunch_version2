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
					dtl += "<option value=" + res_arr[a] + "></option>";
			}
			return dtl;		
	};
	// JSON data from database
	this.prep_result = function(tubed_data) {
			// receives format: xxx|xxx|xxx|xxx
			if (typeof tubed_data !== 'string') {
				throw "WC: String input expected";
			}
			// return format [xxx,xxx,xxx,...]
			return tubed_data.split('|');
	};
	// call_type is needed
	this.control = function(tubed_data) {
			var res_arr = this.prep_result(tubed_data);
			// test for array length and type
			if (res_arr instanceof Array && res_arr.length > 0) {
				return this.write_datalist(res_arr);
			} else {
				// return blank string 
				return "";
			}
	};
};

// JSON
WC_KW.datalist.Controller = function() {
  // collect radio button state for dtl language and specify data type
	// to be returned
	// serialized form data
	this.form_data = function() {
		// grab checked radio button
		return "dtl_lang=" + $('input[name=dtl_lang]').filter(':checked').val() + "&" + "data_type=tubed";
	};
};



/**---------------------------
		Datalist view
 ---------------------------**/
WC_KW.datalist.View = function() {
	this.update = function(result) {
		if (result !== "") { 
			$('#search_list').html(result);
		}
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


/*========================================================
			HELPERS
==========================================================*/

if (WC_KW instanceof Object === false) {
	var WC_KW = {};
}
if (WC_A instanceof Object === false) {
	var WC_A = {};
}

// add helpers object to NS
WC_A.helper = {};

// parse into JSON string
WC_A.helper.parse_json = function (d) {
	return $.parseJSON(d);
};

// trim input string
WC_A.helper.trim_string = function (str, bool) {
	// bool false = trim left right only
	if (bool === false) {
		return str.trim();
	}
	// bool true = clean within string too, 
	if (bool === true) {
		var str_s1 = str.trim(),
				str_s2 = str_s1.replace(/\s*/g, "");
		return str_s2;		
	}
};

// trim input comas
WC_A.helper.trim_comas = function (str) {
		return str.replace(/\,+/g, ",");
};

// prepare table for display
WC_A.helper.prep_table = function (data) {	
		var a, b,
			 	// results db array
			 	db_res_arr = data.result,
			 	status = data.status,
			 	rows = "";
		// if an error message is present return the error here
		if (status) {
			return rows += "<tr>"+"<td>"+status+"</td></tr>";
		}
		// id no error loop through results rows		
		for (a = 0; a < db_res_arr.length; a += 1) {
			// get current position
			b = db_res_arr[a];
			// js_array from model containes DB returned rows
			rows += "<tr>"+"<td>"+
				b['id']+"</td><td>"+
				b['german']+"</td><td>"+
				b['english']+"</td><td>"+
				b['french']+"</td><td>"+
				b['dutch']+"</td><td>"+
				b['japanese']+"</td><td>"+
				b['italian']+"</td><td>"+
				b['spanish']+"</td><td>"+
				b['comments']+"</td><td>"+
				b['updated']+"</td></tr>";
		}
		// clean up
		db_res_arr = null;
		// return results rows
		return rows;
	};
// ajax helper object
WC_A.helper.ajax = {};
// prepare table for results

// make Ajax DB call
WC_A.helper.Ajax = function (config) {
		this.config = config;
		this.ajx_data	= config.data;
		this.call_type = config.call_type;
		this.ajx_result = "";
		this.attempts = config.attempts;
		this.delay = config.delay;
		this.reset = function () { 
				this.delay = config.delay; 
				this.attempts = config.attempts; 
		};
		this.ajx_call = function() {
				var _this = this,
						_config = this.config;
				// AJAX call
				$.ajax({
					type: _config.type,
					url: _config.url,
					data: _this.ajx_data,
					beforeSend: function() {
						// show spinner
						_config.beforeSend(); 
					},
					// success function
					success: function (data) {
						// send call type and data to callback
						_config.success(_this.call_type, data); 
					},
					// error handling function
					error: function(xhr, status) {
						if(_this.attempts-- === 0) {
							// After 4 trials call end to server
							_config.error();
							_this.reset();
							return;
						}
						setTimeout(function() {
							_this.ajx_call();
							//console.log('called again');
						}, _this.delay *= 2);
					},
					// ajax complete event
					complete: function() { 
						// remove spinner
						_config.complete();
					}
				});
			};
	};
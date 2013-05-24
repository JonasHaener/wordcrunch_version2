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
				str_s2 = str_s1.replace(/,(\s+)/g, ",");
				str_s2 = str_s2.replace(/\s+/g, " ");
		return str_s2;		
	}
};

// trim input comas
WC_A.helper.trim_comas = function (str) {
		return str.replace(/\,+/g, ",");
};

// prepare table for display
WC_A.helper.prep_table = function (data) {
	var start = Date.now();
		// receives JS object notation
			 	var arrRes = data.result,
			 			status = data.status,
						arrSubRows = [],// [row,row,row,...]
			 			arrRows = [], // [[rowx10],[rowx10],[rowx10],...]
						a, b, c, d = 0,
						arr10 = [];
						 
		// empty 'status' === "null"
		// "null" for no status update: normal data retrieval 
		if (status !== "null" && status !== "") {
			return ["<tr>"+"<td>"+status+"</td></tr>"];
		}
			
		for (a = 0; a < arrRes.length; a += 1) {
			// get current position
				b = arrRes[a];
				arrSubRows.push("<tr class='res_row'>"+ "<td class='row_id'>" + 
					"<a id='" + b['id'] + "' href='' class='res_id'>" + b['id'] + "</a>" + "</td>" +
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['german'] + "</td>" + 
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['english'] + "</td>" + 
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['french'] + "</td>" + 
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['dutch'] + "</td>" + 
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['japanese'] + "</td>" + 
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['italian'] + "</td>" + 
					"<td>" + "<span>["+ b['id']+ "]</span>" + b['spanish'] + "</td>" + 
					"<td>" + b['comments'] + "</td>" + "<td>" + b['updated'] + "</td>" +
					"</tr>" );
		}
		// split into arrays of 10 items per array
		for (c = 0; c < arrSubRows.length; c+=1) {		
			 arr10.push(arrSubRows[c]);
			 if (arr10.length === 10) {
				 arrRows.push(arr10);
				 arr10 = [];
			 } else if (c+1 === arrSubRows.length) {
				 arrRows.push(arr10);
			}
		}
		// clean up
		data = null;
		// return results rows
		var stop = Date.now();
		console.log('WC_A.helper.prep_table: ', (stop - start) + " ms");
		return arrRows;
};
// ajax helper object
WC_A.helper.ajax = {};
// prepare table for results

// make Ajax DB call
WC_A.helper.Ajax = function (config) {
		this.config 		= config;
		this.ajx_data		= config.data;
		this.call_type 	= config.call_type;
		this.ajx_result = "";
		this.attempts 	= config.attempts;
		this.delay 			= config.delay;
		this.reset = function () { 
				this.delay = config.delay; 
				this.attempts = config.attempts; 
		};
		this.ajx_call = function() {
			try {
					var _this = this,
							_config = this.config;
					
					// speed eval only	
					var start;
					var stop;
								
					// AJAX call
					$.ajax({
						type: _config.type,
						url: _config.url,
						data: _this.ajx_data,
						beforeSend: function() {
							
							start  = Date.now();
							
							// execute before send
							_config.beforeSend();
							// add spinner		
							_config.spinnerAdd(); 	
						},
						// success function
						success: function (data) {
							console.log(data);
							stop  = Date.now();
							console.log('AJAX till complete is called: ', (stop-start) + " ms");
							// send call type and data to callback
							_config.success(_this.call_type, data);
						},
						// error handling function
						error: function(xhr, status) {
							if(_this.attempts-- === 0) {
								// After 4 trials call end to server
								_config.error();
								_config.spinnerHide();
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
							_config.spinnerHide();
							_config.complete();
						}
					});
			} catch(e) {
				// log error
			}
	};
};

WC_A.helper.Ajax_dtl = function (m,v,c) {
		this.model = m.model;
		this.view = v.view;
		this.controller = c.controller;
		this.form_data = this.controller.form_data();
		this.url = this.model.url;
		this.delay = 1000;
		this.attempts = 3;
		this.reset = function () { 
				this.delay = 1000;
				this.attempts = 3; 
		};
		this.ajx_call = function() {
			try {
					var _this = this;
					// AJAX call
					$.ajax({
						type: "POST",
						url: _this.url,
						data: _this.form_data,
						beforeSend: function() {
							// execute before send
							// add spinner		
						},
						// success function
						success: function (data) {
							// send call type and data to callback
							console.log('dtl-data: ', data);
							_this.view.update( _this.model.control(data) );
						},
						// error handling function
						error: function(xhr, status) {
							if(_this.attempts-- === 0) {
								// After 4 trials call end to server
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
						}
					});
			} catch(e) {
				// log error
			}
	};
};
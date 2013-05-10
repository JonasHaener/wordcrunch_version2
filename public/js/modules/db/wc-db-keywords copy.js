"use strict";

/*========================================================
			NS Namespace
==========================================================*/
if (WC_KW instanceof Object === false) {
	var WC_KW = {};
}
if (WC_A instanceof Object === false) {
	var WC_A = {};
}
// add database object to NS
WC_KW.db = {};
// add forms object to NS

/*========================================================
			DATABASE
==========================================================*/

/**---------------------------
		View – Database
 ---------------------------**/
WC_KW.db.view = {
	// results containers
	container: $('#tBody'),
	ids_container: $('.ids_used'),
	user_message: $('<div id="user_feedback" class=""></div>'),
	message_pos: $('body'),
	// display confirmation message
	warn_confirm: function() {
		return confirm('Do you know what you are doing?');
	},
	show_spinner: function() { 
		$('#spinner').show();	
	},
	hide_spinner: function() { 
		$('#spinner').hide();	
	},
	// write results to results field
	update_content: function (data) {
		var start = Date.now(); 
		
		this.container.html(data);
		
		var stop = Date.now(); 
		console.log('DB update_content: ', (stop - start) + " ms");
	},
	// update status and error messaged
	update_status: function (data) {
		this.user_message
			.stop(true, true)
			.text(data)
			// show user feedback and fade out
			.hide()
			.addClass("gradient-yellow-rgb")
			.appendTo(this.message_pos)
			.fadeIn(300)
			.delay(1300)
			.fadeOut(300);
	},
	// update ids field
	update_id: function (data) {
		this.ids_container.val(data);
	},
	// update input fields
	update_for_edit: function (data) {
		$('#id_to_edit').val(data.id);
		$('#edit_german').val(data.german);
		$('#edit_english').val(data.english);
		$('#edit_french').val(data.french);
		$('#edit_dutch').val(data.dutch);
		$('#edit_spanish').val(data.spanish);
		$('#edit_italian').val(data.italian);
		$('#edit_japanese').val(data.japanese);
		$('#edit_comments').val(data.comments);
	}
};
/**---------------------------
		Model – Database
 ---------------------------**/
WC_KW.db.model = {
		// transform JSON into JavaScript object
		NO_RESULT: "Sorry, no result found",
		ready_json: function (json_data) {
			var start = Date.now(); 
			
			// check for string type
			if (typeof json_data !== 'string') {
				throw "WC: String input expected";
			}
			var a, b,
					res_string = "",
					res_arr = [],
					ids = "",
					js_res_array = [],
					no_entries = "";
			//remove brackets		
			res_string = json_data.replace(/\[(.*)\]/g, '$1');
			// separate object entities
			res_string = res_string.replace(/\}(,)\{/g, '}|{');
			// split into array
			res_arr = res_string.split('|');
			// prepare javascript results object
			for (a = 0; a < res_arr.length; a += 1) {
				// if results array is empty assign error message stop loop
				// for display in resuls rows
				if (res_arr[a] === "" && typeof res_arr[a] !== 'object') {
					js_res_array[0] = { status: this.NO_RESULT };
					ids = "0";
					break;
				}
				// convert JSON to javascript and push into results array
				b = WC_A.helper.parse_json(res_arr[a]);
				js_res_array.push(b);
				//collect used ids
				ids = (a < 1) ? ids + b['id'] : ids + ", " + b['id'];
			}
			
			var stop = Date.now(); 
			console.log('DB ready JSON: ', (stop - start) + " ms");
			
			// return results object
			// returns [ results object with array and used ids string ]
			return { 'result': js_res_array, 'ids_used': ids, 'status': js_res_array[0].status };
	},
	// function called by ajax success event
	prep_results_view: function(call_type, json) {
			var start = Date.now();
			
			var _this = WC_KW.db.model,
					view = WC_KW.db.view,
					// JSON data from DB in JS object
					js_obj = _this.ready_json(json),
					result = js_obj.result[0],
					status = js_obj.status,
					rows = "",
					ids = "";
			// prepare for view
			if (typeof call_type !== 'string') {
				throw "WC: String input expected for call_type";
			}
			// call view based on type 'search', 'retrieve', 'edit', 'delete'
			switch (call_type) {
				// DB search
				// results
				case 'search':
					rows = WC_A.helper.prep_table( js_obj ),
					ids = js_obj['ids_used'];
					view.update_content( rows );
					view.update_id( ids );
					// display if no entries found
					if (status !== "null") {
						view.update_status( status );	
					}
					break;
				// retrieve values for editing form	
				case 'retrieve':
					if (typeof result.id === 'string' && result.id !== "") {
						view.update_for_edit( result );
					}
					break;
				// editing and saving from form
				case 'edit':
					view.update_for_edit( result );
					break;			
					// deleting and saving from form	
				case 'delete':
					view.update_for_edit( result );
					break;
			}
			// update status
			if (status !== "null") {
				view.update_status( status );	
			}
			var stop = Date.now(); 
			console.log('DB prep_results_view: ', (stop - start) + " ms");
	},
	// controlls DB model
	controller: function(call_type, form_data) { 
			if (call_type && call_type === "edit" && WC_KW.db.view.warn_confirm() === false) {
				return;
			}
			// create ajax object
			var ajax = new WC_A.helper.Ajax( 
			{ 
						'call_type' 	: call_type, 
						'data'				: form_data,
						'url'					:	'../application/modules/db-kw/controllers/wc-db-control.inc.php',
						'type'				:	'POST',
						'attempts'		:	3,
						'delay'				:	3000,
						'spinnerAdd'	: WC_KW.db.view.show_spinner, // function
						'spinnerHide'	:	WC_KW.db.view.hide_spinner, // function
						'beforeSend'	: function() {  },
						'success'			: WC_KW.db.model.prep_results_view, // function
						'complete'		:	function() {  },
						'error'				:	function() { WC_KW.db.view.update_status("Server not responding"); }
			});
			// make ajax call
			ajax.ajx_call();
		}
};

/**---------------------------
		Controller – Database
 ---------------------------**/
// JSON
WC_KW.db.controller = {
  // refresher trigger
	do_search: (function () {
    $('#entry_refresh').on('click', function () {
			var form_data = $('#form_search').serialize();
			WC_KW.db.model.controller('search', form_data);
		});
	}()),
	// submit entries from edit entry form
	do_edit: (function () {
		$('#go_edit').on('click', function () {
			var form_data = $('#form_edit_entry').serialize();
			WC_KW.db.model.controller('edit', form_data);	
		});
	}()),
	// retrieve data from DB for editing
	retrieve_for_edit: (function () {
		$('#id_to_edit').on('blur', function () {
			// do not submit the radio buttons to 
			// avoid conflict when submitting entire form
			// when updating Database
			var form_data = $('#form_edit_entry > input')
											.not('input[type=radio]')
											.serialize();
			WC_KW.db.model.controller('retrieve', form_data);
		});
	}())
};
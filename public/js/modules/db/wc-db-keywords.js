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
			Custom events for WC keywords
==========================================================*/
$('body').bind('start-update', function(e, bool){
 	WC_KW.db.view.ctrl_update(bool);
});
$('body').bind('view-complete', function(e, bool){
 	WC_KW.db.controller.report_update(bool);
});

/*========================================================
			DATABASE
==========================================================*/

/**---------------------------
		View – Database
 ---------------------------**/
WC_KW.db.view = {
	write_timer: false,
	ctrl_update: function(bool) {
		if (bool === true) {
			this.write_timer = true;
			$('.js-table-body').empty();
		} else if (bool === false) {
			this.write_timer = false;
		}
	},
	container: $('.js-table-body'),
	ids_container: $('.ids_used'),
	user_message: $('<div id="user_feedback" class=""></div>'),
	message_pos: $('body'),
	// display confirmation message
	warn_confirm: function() {
		return confirm('Do you know what you are doing?');
	},
	show_spinner: function() { 
		$('.js-spinner').show();	
	},
	hide_spinner: function() { 
		$('.js-spinner').hide();	
	},
	// write results to results field
	update_content: function (arrData) {
		var arrRows = arrData,
				_this = this;
		// set boolean flag listened by custom event
		function update() {
			if (arrRows.length > 0 && _this.write_timer === true) {
				$('.js-table-body').trigger('view-complete',[ false ]);
				$('.js-table-body').append(arrRows.shift());
				console.log('arrRows.length timer update: ', arrRows.length);
				console.log('rows are timeout updated');
				setTimeout(function() { update(); }, 150);
			} else {
				 $('.js-table-body').trigger('view-complete',[ true ]);	
			}
		}
		update();
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
		$('.js-f-edit-id').val(data.id);
		$('.js-f-edit-german').val(data.german);
		$('.js-f-edit-english').val(data.english);
		$('.js-f-edit-french').val(data.french);
		$('.js-f-edit-dutch').val(data.dutch);
		$('.js-f-edit-spanish').val(data.spanish);
		$('.js-f-edit-italian').val(data.italian);
		$('.js-f-edit-japanese').val(data.japanese);
		$('.js-f-edit-comments').val(data.comments);
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
					arrRows = [],
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
					arrRows = WC_A.helper.prep_table( js_obj ),
					ids = js_obj['ids_used'];
					
					var startD = Date.now();
					view.update_content( arrRows );
					var stopD = Date.now();
					console.log('startD',stopD-startD);
					
					view.update_id(ids);
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
			if (call_type === "edit" && WC_KW.db.view.warn_confirm() === false) {
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
	view_updated: true,
	report_update: function(bool) {
			this.view_updated = (bool === true) ? true : false;
	},
	do_search: function () {
		var _this = this;
		//var clicked = 0
    $('.js-b-refresh').on('click', function () {
			if (_this.view_updated === true) {
				$('.js-b-refresh').trigger('start-update',[ true ]);
				var form_data = $('.js-search-form').serialize();
				// send input to model
				WC_KW.db.model.controller('search', form_data);
			} else if (_this.view_updated === false) {
				$('.js-b-refresh').trigger('start-update',[ false ]);
			}
		});
	},
	row_edit: function() {
		$('.js-table-body').on('click', 'a', function (e) {
			var id = e.currentTarget.id;
			// scroll window to top to reveal editor form
			$('body, html').animate({ scrollTop:0 }, 100);
			// check editor radio button
			$('.js-f-editor input[value=edit_entry]').prop('checked', "checked");
			// control form fields for editor mode
			WC_KW.forms.control_fields("edit_entry");
			// pass value to id form field // / trigger search
			$('.js-f-edit-id').val(id).blur();
			// open form fields
			$('.js-f-editor').slideDown(100);
			// prevent link follow and event bubble
			return false;
		});
	},
	// submit entries from edit entry form
	do_edit: function () {
		$('.js-b-go-edit').on('click', function () {
			var form_data = $('.js-f-editor').serialize();
			WC_KW.db.model.controller('edit', form_data);	
		});
	},
	// retrieve data from DB for editing
	retrieve_for_edit: function () {
		$('.js-f-edit-id').on('blur', function () {
			// do not submit the radio buttons to 
			// avoid conflict when submitting entire form
			// when updating Database
			var form_data = $('.js-f-editor > input')
											.not('input[type=radio]')
											.serialize();
			WC_KW.db.model.controller('retrieve', form_data);
		});
	},
	init: function() {
		this.do_search();
		this.row_edit();
		this.do_edit();	
		this.retrieve_for_edit();
		
	}
};
WC_KW.db.controller.init();
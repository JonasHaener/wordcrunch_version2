/*========================================================
			FORMS
==========================================================*/
if (WC_KW instanceof Object === false) {
	var WC_KW = {};
}
if (WC_A instanceof Object === false) {
	var WC_A = {};
}

WC_KW.forms = {};

/**---------------------------
		View – Forms
 ---------------------------**/
WC_KW.forms = {
		
		// show hide form
		show_hide: function () {
			$('.js-b-entry-edit').on('click', function() {
				$('.js-f-editor').slideToggle(350);
			});
	},
	
	// disable, activate form fields
	control_fields: function (field_value) {
			var inp_fields = $('.js-f-editor input[type=text]');
			//clear all fields
			inp_fields.val("");
			// control entry fields
			switch (field_value) {
				case "new_entry":			
					inp_fields
					 .removeProp('disabled')
					 .removeClass('hide_field')
					 .filter('.js-f-edit-id')
					 // hide id field
					 .addClass('hide_field');
				break;
				
				case "edit_entry":		
					inp_fields
					 .removeProp('disabled')
					 .removeClass('hide_field');
				break;
				
				case "delete_entry":		
					inp_fields
					 .removeClass('hide_field')
					 .not('.js-f-edit-id')
					 .prop('disabled', 'disabled');
				break;							
			}
	},	
	
	// edit field control radio buttons edit, delete, new
	edit_entry: function () {
			var _this = this;
			$('.js-f-editor').on('change', 'input[type=radio]', function () {
				var field_value = $(this).prop('value');
				_this.control_fields(field_value);
			});
	},
	
	// input field cleaner
	clean_input_fields: function () {
			// cleam search field
			$('.js-f-search-field').on('change', function() {
				var txt = $(this).val();
				// true cleans within the string too
				txt = WC_A.helper.trim_string(txt, true);
				// reduce commas to maximum one
				txt = WC_A.helper.trim_comas(txt);
				// reassign text to input field
				$(this).val(txt);
			});
			$('.js-f-editor > input').on('change', function() {
				var txt = $(this).val();
				// false cleans left, right
				// true cleans within the string too
				txt = WC_A.helper.trim_string(txt, true);
				// reduce commas to maximum one
				txt = WC_A.helper.trim_comas(txt);
				// reassign text to input field
				$(this).val(txt);
			});
	},
	
	// input field cleaner
	data_list: function() {
		$('input[name=dtl_lang]').on( 'change', WC_KW.datalist.control );
		
	},
	// init function
	init: function() {
		this.show_hide();
		this.edit_entry();
		this.clean_input_fields();
		this.data_list();
	}
};
WC_KW.forms.init();


/*========================================================
		Dates and Times
==========================================================*/
/**---------------------------
		Page date
 ---------------------------**/
WC_A.dates = {
		// self-updating
		write_date: function() {
			//console.log('time updated');
			var d = new Date();
			$('.js-date').html(d.toDateString());
			// update date every hour
			setTimeout(WC_A.dates.write_date, 60000);
		}
};
WC_A.dates.write_date();
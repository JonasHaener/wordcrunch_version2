"use strict";
/*========================================================
			Custom events for WC keywords
==========================================================*/
$('body').bind('stop_update', function(e){
 	WC_KW.db.view.stop_update();
});

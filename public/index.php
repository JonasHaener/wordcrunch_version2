<?php
// absolute path
require_once("../config_global/wc-abs-path.inc.php");
// check session
require_once($ABS_PATH."application/modules/login/wc-check-session.inc.php");
?> 
<!DOCTYPE HTML>
<html class="cssgradients">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>search|wordcrunch</title>
<link type="text/css" rel="stylesheet" href="css/wc-main.css">
<script>
</script>
</head>
<body>
<!--index page container-->
	<div class="index_module">
		<!--header bar-->
			<header class="header"></header>
		<!--user bar-->
			<nav id="menu_navi" class="margin-bott-5em border-bott-thin-grey">
			
						<a href="" class="backgr-grey-l border-bott-thin-grey border-right-grey height-2em padd-left-1em padd-all-0_3em padd-right-1em">Hello,&nbsp;<strong><?php echo $SESS_USER;?></strong></a>
			
						<a href="logout.php" id="logout_button" class="animate-backgr-navi backgr-grey-l center-text height-2em txt-white-h border-bott-thin-grey border-right-grey backgr-win-purple-h padd-all-0_3em">Logout</a>
						<a href="" id="keyword_button" class="animate-backgr-navi backgr-win-white backgr-win-purple-h border-right-grey center-text height-2em txt-white-h border-bott-thin-grey padd-all-0_3em">Keywords</a>
					<?php if($SESS_RIGHTS > 1) { ?>
						<a href="" id="keytext_button" class="animate-backgr-navi backgr-win-white center-text height-2em txt-white-h border-bott-thin-grey border-right-grey backgr-win-purple-h padd-all-0_3em">Keytext</a>
					<?php } ?>
			</nav>
			<div id="spinner" class="js-spinner ajax-load"></div>
		<!--main container-->
			<div id="main_container" class="">
					<!--working container-->		
					<div id="work_container" class="backgr-win-white border-thin-grey float-left">
							<h2 id="menu_entry_displ" class="col-light-grey float-left margin-right-1-5em">Keyword search</h2>
							<nav id="function_navi" class="float-left">
									<form id="form_search" name="form_search" class="js-search-form float-left inl-block">
                  		<?php if($SESS_RIGHTS > 0) { ?>
											<button id="entry_edit" class="js-b-entry-edit button backgr-win-purple backgr-win-blue-h float-left margin-right-025em" type="button"></button>
											<?php } ?>
											<button id="entry_refresh" class="js-b-refresh button backgr-win-purple backgr-win-blue-h float-left margin-right-025em" name="submit" type="submit"></button>
									<!-- form and search navigation-->
											<input type="text" id="inp_search" list="search_list" class="js-f-search-field inp-field margin-right-1em inl-block" name="search" placeholder="Enter keyword / comma seperated IDs here">	
                      <label for="dtl_de" class="dtl_label">DE:&nbsp;</label>
                      <input type="radio" id="dtl_de" name="dtl_lang" checked value="german">
                      <label for="dtl_en" class="dtl_label">&nbsp;EN:&nbsp;</label>
                      <input type="radio" id="dtl_en" name="dtl_lang" value="english">
											<label class="ids_label">&nbsp;&nbsp;IDS:&nbsp;</label>
											<input type class="ids_used inp-field" placeholder="&nbsp;&nbsp;Used IDs appear here">
											<datalist id="search_list" class="js-dl-searchlist">
												<!--<option value="filled from DB"></option>-->
											</datalist>
									</form>
							</nav>
							<!-- Hide inputs when editor rights are not met -->
							<?php if($SESS_RIGHTS !== 0) { ?>
							<form action="" id="form_edit_entry" name="form_edit_entry" class="js-f-editor float-left inl-block margin-bottom-2em padd-top-2em padd-bott-1em border-top-thin-grey border-bott-thin-grey">
									<!--Radio button selection -->
									
									<input type="radio" id="radio_edit_entry" checked name="change_db" value="edit_entry">&nbsp;&nbsp;<span class="margin-right-025em">Edit</span>&nbsp;&nbsp;
									<input type="radio" name="change_db"  value="new_entry" a>&nbsp;&nbsp;<span class="margin-right-025em">New</span>
									<input type="radio" name="change_db"  value="delete_entry">&nbsp;&nbsp;<span class="margin-right-025em">Delete</span>&nbsp;&nbsp;
									<!--END Radio button-->
									
									<input type="button" id="go_edit" name="go_edit" class="js-b-go-edit inl-block margin-right-1em margin-bottom-1em" value="Update"><br><br>
									
									<!--input fields for editing-->
									<span class="language_label">ID:&nbsp;</span>
									<input type="text" id="id_to_edit" class="js-f-edit-id inp-field inl-block margin-right-1em margin-bottom-1em" name="id_to_edit" placeholder="Enter ID here">
									<span class="language_label">DE:&nbsp;</span>
									<input type="text" id="edit_german" class="js-f-edit-german inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_german" placeholder="New German here">
									<span class="language_label">EN:&nbsp;</span>
									<input type="text" id="edit_english" class="js-f-edit-english inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_english" placeholder="New English here">
									<br>
									<span class="language_label">FR:&nbsp;</span>
									<input type="text" id="edit_french" class="js-f-edit-french inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_french" placeholder="New French here">
									
									<span class="language_label">NL:&nbsp;</span>
									<input type="text" id="edit_dutch" class="js-f-edit-dutch inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_dutch" placeholder="New Dutch here">
									<span class="language_label">JP:&nbsp;</span>
									<input type="text" id="edit_japanese" class="js-f-edit-japanese inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_japanese" placeholder="New Japanese here">
									<br>
									<span class="language_label">IT:&nbsp;</span>
									<input type="text" id="edit_italian" class="js-f-edit-italian inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_italian" placeholder="New Italian here">
									<span class="language_label">ES:&nbsp;</span>
									<input type="text" id="edit_spanish" class="js-f-edit-spanish inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_spanish" placeholder="New Spanish here">
									<span class="language_label">CM:&nbsp;</span>
									<input type="text" id="edit_comments" class="js-f-edit-comments inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_comments" placeholder="Comments here">
									
							</form>
							<?php }; ?>
							<table class="" id="result">
									<thead >
											<tr class="">
													<th class="backgr-win-orange">ID</th>
													<th class="backgr-win-green">German</th>
													<th class="backgr-win-blue-shade-m">English</th>
													<th class="backgr-win-blue-shade-m">French</th>
													<th class="backgr-win-blue-shade-m">Dutch</th>
													<th class="backgr-win-blue-shade-m">Japanese</th>
													<th class="backgr-win-blue-shade-m">Italian</th>
													<th class="backgr-win-blue-shade-m">Spanish</th>
													<th class="backgr-win-blue-shade-m">Comments</th>
													<th class="backgr-win-blue-shade-m">Updated</th>
											</tr>
									</thead>
									<tbody id="tBody" class="js-table-body">
											<tr>
													<td>Result will be displayed here</td>
											</tr>
									</tbody>
							</table>
              <br>
							<div>
								<label class="ids_label">IDS:&nbsp;</label>
								<input type="text" class="ids_used inp-field" placeholder="&nbsp;&nbsp;Used IDs appear here">
							</div>	
							<br>
							<footer class="">
								<p>Today: <span id="date" class="js-date"></span></p>	
							</footer>
							<!--<div id="user_feedback" class="gradient-yellow-rgb">Hell user feedack</div>-->	
					</div>
					<!--end work_container-->
			</div>
	</div>
<!--<script src="../js/libs/jQuery-v1.8.2.js"></script>-->
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src="js/modules/helpers/wc-helpers.js"></script>
<script src="js/modules/db/wc-db-keywords.js"></script>
<script src="js/modules/db-datalist-kw/wc-db-kw-datalist.js"></script>
<script src="js/modules/interface/wc-navi.js"></script>
</body>
</html>

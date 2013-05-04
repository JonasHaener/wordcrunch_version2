<?php
require_once("../application/modules/login/wc-check-session.inc.php");
?> 
<!DOCTYPE HTML>
<html class="cssgradients">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>search|wordcrunch</title>
<link type="text/css" rel="stylesheet" href="css/wc-main.css">
<script></script>
</head>
<body>
<!--index page container-->
	<div id="index_module" class="">
		<!--header bar-->
			<header class="header"></header>
		<!--user bar-->
			<nav id="menu_navi" class="margin-bott-3_5em border-bott-thin-grey">
				<ul>
					<li class="border-right-grey backgr-grey-l">
						<a href="" class="">Hello,&nbsp;<strong><?php echo $sess_user;?></strong></a>
					</li>
					<li class="border-right-grey backgr-grey-l backgr-win-purple-h">
						<a href="logout.php" id="logout_button" class="center-text txt-white-h">Logout</a>
					</li>
					<li class="border-right-grey backgr-win-purple-h txt-white-h">
						<a href="" id="keyword_button" class="center-text txt-white-h">Keywords</a>
					</li>
					<?php if($sess_rights > 1) { ?>
					<li class="border-right-grey backgr-win-purple-h txt-white-h">
						<a href="" id="keytext_button" class="center-text txt-white-h">Keytext</a>
					</li>
					<?php } ?>
				</ul>
			</nav>
		<!--main container-->
			<div id="main_container" class="">
					<div id="spinner" class="ajax-load"></div>
					<!--working container-->		
					<div id="work_container" class="backgr-win-white border-thin-grey float-left">
							<h2 id="menu_entry_displ" class="col-light-grey float-left margin-right-1-5em">Keyword search</h2>
							<nav id="function_navi" class="float-left">
									<ul class="float-left margin-bottom-1em">
											<?php if($sess_rights !== 0) { ?>
											<li id="entry_edit" class="backgr-win-purple backgr-win-blue-h float-left div margin-right-025em"></li>
											<?php } ?>
											<li id="entry_refresh" class="backgr-win-purple backgr-win-blue-h float-left  margin-right-2em"></li>
									</ul>
									<!-- form and search navigation-->
									<form id="form_search" name="form_search" class="float-left inl-block" action="">
											<input type="text" id="inp_search" list="search_list" class="inp-field margin-right-1em inl-block" name="search" placeholder="Enter keyword / comma seperated IDs here">
											<label class="ids_label">IDS:&nbsp;</label>
											<input type="text" class="ids_used" placeholder="&nbsp;&nbsp;Used IDs appear here">
											<datalist id="search_list">
													<option value="Stromaufnahme"></option>
													<option value="Spannungsversogung"></option>
													<option value="Current consumption"></option>
													<option value="Stromversorgung"></option>
													<option></option>
													<option></option>
													<option></option>
											</datalist>
									</form>
							</nav>
							<!-- Hide inputs when editor rights are not met -->
							<?php if($sess_rights !== 0) { ?>
							<form action="" id="form_edit_entry" name="form_edit_entry" class="float-left inl-block margin-bottom-2em padd-top-2em padd-bott-1em border-top-thin-grey border-bott-thin-grey">
									<!--Radio button selection -->
									
									<input type="radio" checked name="change_db" value="edit_entry">&nbsp;&nbsp;<span class="margin-right-025em">Edit</span>&nbsp;&nbsp;
									<input type="radio" name="change_db"  value="new_entry" a>&nbsp;&nbsp;<span class="margin-right-025em">New</span>
									<input type="radio" name="change_db"  value="delete_entry">&nbsp;&nbsp;<span class="margin-right-025em">Delete</span>&nbsp;&nbsp;
									<!--END Radio button-->
									
									<input type="button" id="go_edit" name="go_edit" class="inl-block margin-right-1em margin-bottom-1em" value="Update"><br><br>
									
									<!--input fields for editing-->
									<span class="language_label">ID:&nbsp;</span>
									<input type="text" id="id_to_edit" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="id_to_edit" placeholder="Enter ID here">
									<span class="language_label">DE:&nbsp;</span>
									<input type="text" id="edit_german" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_german" placeholder="New German here">
									<span class="language_label">EN:&nbsp;</span>
									<input type="text" id="edit_english" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_english" placeholder="New English here">
									<br>
									<span class="language_label">FR:&nbsp;</span>
									<input type="text" id="edit_french" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_french" placeholder="New French here">
									
									<span class="language_label">NL:&nbsp;</span>
									<input type="text" id="edit_dutch" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_dutch" placeholder="New Dutch here">
									<span class="language_label">JP:&nbsp;</span>
									<input type="text" id="edit_japanese" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_japanese" placeholder="New Japanese here">
									<br>
									<span class="language_label">IT:&nbsp;</span>
									<input type="text" id="edit_italian" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_italian" placeholder="New Italian here">
									<span class="language_label">ES:&nbsp;</span>
									<input type="text" id="edit_spanish" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_spanish" placeholder="New Spanish here">
									<span class="language_label">CM:&nbsp;</span>
									<input type="text" id="edit_comments" class="inp-field inl-block margin-right-1em margin-bottom-1em" name="edit_comments" placeholder="Comments here">
									
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
									<tbody>
											<tr>
													<td>Result will be displayed here</td>
											</tr>
									</tbody>
							</table>
							<footer class="">
									<br>
									<div>
											<label class="ids_label">IDS:&nbsp;</label>
											<input type="text" class="ids_used" placeholder="&nbsp;&nbsp;Used IDs appear here">
									</div>	
									<br>
									<p>Today: <span id="date"></span></p>	
							</footer>
							<!--<div id="user_feedback" class="gradient-yellow-rgb">Hell user feedack</div>-->	
					</div>
					<!--end work_container-->
			</div>
	</div>
<!--<script src="../js/libs/jQuery-v1.8.2.js"></script>-->
<script src="js/libs/jQuery-v1.9.1.js"></script>
<script src="js/modules/helpers/wc-helpers.js"></script>
<script src="js/modules/db/control/wc-db-keywords.js"></script>
<script src="js/modules/interface/wc-db-navi.js"></script>
</body>
</html>

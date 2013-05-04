<?php

/* config data for DB access
	 3 user levels
	 
	 0 = read only
	 1 = read, write, delete
	 2 = administrator (level =1 + can add users and view statistics)
	 
	 db user names
	 
	 0 = 'reader'
	 1 = 'editor'
	 2 = 'admin'
	 
	 for future use
	 
	 for development = username = 'wordcrunch'
	 
*/

$db_accessor = 'wordcrunch';
$db_accessor_pw = '<88>>cru99**ncher';
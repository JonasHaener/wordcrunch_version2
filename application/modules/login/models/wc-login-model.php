<?php

//$db = new SayName('Jonny Cash');
//$name = $db->returnName();
$newDB = new DBconnect("localhost", "jonasCanAll", "fridolin88", "home");

$rows = $newDB->getRows("SELECT*FROM food");
$cols =  array('fruit','veggie','drink','snack','season');
$result = $newDB-> getResultsTable($cols);

$newDB-> releaseDB();
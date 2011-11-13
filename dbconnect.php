<?php
	$db_user = 'root';	// Connect to DB
	$db_pass = '';
	$db_host = 'localhost';
	$db_name = 'tagchat_db';
	$db_connection = mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());
	mysql_select_db("$db_name") or die(mysql_error());
?>
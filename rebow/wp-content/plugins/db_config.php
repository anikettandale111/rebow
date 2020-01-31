<?php
$con = mysql_connect("localhost","root","");
	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}
	//mysql_query('SET names utf8');
	mysql_set_charset('utf8');
	$db = mysql_select_db("rebow");
?>
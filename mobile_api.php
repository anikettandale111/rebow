<?php 
	include 'db_config.php';
    $query = "SELECT * FROM wp_users where user_email='anikettandale111@gmail.com'";
    $res = mysql_query($query);
    $row = mysql_fetch_row($res);
    print_r($row);
    
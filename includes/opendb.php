<?php	
	include_once "$root/includes/dbsettings.php";
	include_once "$root/includes/dbclass.php";
	$dsn = "mysql:dbname=$nameDB;host=$hostNameDB;charset=utf8";
	$db = new DB_Class($dsn,$userNameDB,$userPasswordDB);
	$db->connect();
?>
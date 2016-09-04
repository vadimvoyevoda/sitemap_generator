<?php
	if(!empty($_POST['id']))
	{
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		include_once "$root/includes/opendb.php";
		include_once "$root/controllers/mapController.php";
		
		MapController::$db = $db;
		$sitemap_id = $_POST['id'];
		$res = MapController::delete_sitemap($sitemap_id);
		echo $res;
	}
?>
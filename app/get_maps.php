<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once "$root/includes/opendb.php";
	include_once "$root/controllers/mapController.php";
	MapController::$db = $db;
	$sitemaps = MapController::get_sitemaps();
	
	if(count($sitemaps))
	{
		$sitemap_keys = array_keys($sitemaps[0]);
		
		//get keys without sitemap_id
		unset($sitemap_keys[0]);
		include("$root/views/sitemaps.php");
	} else {
		echo "<h3>There are no sitemaps</h3>";
	}
?>
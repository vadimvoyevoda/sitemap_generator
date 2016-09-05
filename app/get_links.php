<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once "$root/includes/opendb.php";
	include_once "$root/controllers/mapController.php";	
	include_once "$root/controllers/linkController.php";	
	MapController::$db = $db;
	LinkController::$db = $db;
	
	if(!empty($_GET['id']))
	{		
		$page_id = null;
		$sitemap_id = $_GET['id'];
		
		$sitemap_url = MapController::get_sitemap_url($sitemap_id);
		$main_link = LinkController::get_links($page_id, $sitemap_id)[0];
		$links = LinkController::get_links($main_link['LINK_ID']);		
	} else if(!empty($_POST['page_id']))
	{
		$page_id = $_POST['page_id'];
		$links = LinkController::get_links($page_id);
	}
	
	$max = (count($links) <= 8) ? count($links) : 8;
	$all_links_count = count($links);
	
	include("$root/views/links.php");
?>
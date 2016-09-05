<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once "$root/includes/opendb.php";
	include_once "$root/controllers/mapController.php";
	include_once "$root/controllers/linkController.php";	
	LinkController::$db = $db;
	MapController::$db = $db;
	
	if(!empty($_FILES['website2']))
	{
		$file_content = file_get_contents($_FILES['website2']['tmp_name']);
		$links = str_replace("\n",",",$file_content);
		echo $links;
		
	} else if(!empty($_POST['website']))
	{		
		//get url from POST variable
		$url = $_POST['website'];	

		//get different variants of domain		
		$domain_var = LinkController::get_domain($url);
		
		//create sitemap
		$sitemap = MapController::createMap($url);	
		
		if(!empty($sitemap))
		{
			$parent = LinkController::storeMainLink($url, $sitemap, $domain_var);
				
			//get child links from main page ans store it to db
			$links = LinkController::parse($url);
			LinkController::saveLinks($sitemap, $links, $parent, $domain_var);
			echo $sitemap;
		}		
	} 
	else if(!empty($_POST['sitemap']) && !empty($_POST['depth']) && !empty($_POST['depth_max'])){
		
		//get current sitemap
		$sitemap = $_POST['sitemap'];
			
		//get sitemap url
		$sitemap_url = MapController::get_sitemap_url($sitemap);
			
		//get current sitemap depth
		$depth = $_POST['depth'];
		
		//get domain variants for sitemap
		$domain_var = LinkController::get_domain($sitemap_url);
		
		//checking sitemap depth
		$depth_max = $_POST['depth_max'];
		if($depth<$depth_max)
		{
			//get first page without child links
			$res = LinkController::get_next_empty_link($sitemap);
			if(!empty($res) && $res['DEPTH']<$depth_max)
			{
				//append domain to url befor searching
				$url = MapController::get_sitemap_url($sitemap).$res['LINK'];
				
				//get child links from a page
				$new_links = array();
				$new_links = LinkController::parse($url);
				
				LinkController::saveLinks($sitemap, $new_links, $res['LINK_ID'], $domain_var);
				echo $res['DEPTH'];
			}
		}
	}
?>
<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once "$root/libraries/simplehtmldom/simple_html_dom.php";
	include_once "$root/models/mapModel.php";
	
	class MapController{
		static $db;
		
		static function createMap($url)
		{
			$url = rtrim($url,"/");
			$model = new MapModel(self::$db, $url);
			$sitemap = $model->save();
			
			return $sitemap;
		}
		
		static function get_sitemap_url($sitemap)
		{
			MapModel::$db = self::$db;
			return MapModel::get_sitemap_url($sitemap)['DOMAIN'];
		}
		
		static function get_sitemaps()
		{
			MapModel::$db = self::$db;		
			return MapModel::get_sitemaps();
		}
		
		static function delete_sitemap($sitemap_id)
		{
			MapModel::$db = self::$db;		
			return MapModel::delete_sitemap($sitemap_id);
		}
	}
?>
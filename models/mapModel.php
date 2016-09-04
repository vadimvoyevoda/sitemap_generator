<?php	
	class MapModel{
		private $domain = "";
		static $db;
		
		function __construct($db,$domain)
		{
			$this->domain = $domain;
			self::$db = $db;
		}
		
		function save()
		{
			return self::$db->insert("SITEMAPS",array("DOMAIN"),array($this->domain));
		}
		
		static function get_sitemap_url($sitemap_id)
		{
			return self::$db->selectOne("SITEMAPS","DOMAIN","SITEMAP_ID = ".$sitemap_id);
		}
		
		static function get_sitemaps()
		{
			return $sitemaps = self::$db->selectAll("SITEMAPS","SITEMAP_ID, DOMAIN, GENERATION_DATE",null,"SITEMAP_ID DESC");			
		}
		
		static function delete_sitemap($sitemap_id)
		{
			return self::$db->delete("SITEMAPS","SITEMAP_ID = ".$sitemap_id);
		}
	}
?>
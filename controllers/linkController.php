<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once "$root/libraries/simplehtmldom/simple_html_dom.php";
	include_once "$root/models/linkModel.php";
	
	class LinkController{
		static $db;
		
		static function parse($url){
			//get html page content
			$site_content = @file_get_html($url);
			
			$links = array();

			//$url is not correct (files or other...)
			if($site_content === false)
			{
				return $links;
			}

			//get current page links
			foreach($site_content->find(self::getLinksSelector($url)) as $a) 
			{
				if(!in_array($a->href, $links))
				{
					array_push($links,$a->href);
				}
			}
			
			return $links;		
						
		}
		
		static function getLinksSelector($url)
		{
			//get domain
			$domain_var = self::get_domain($url);
			
			//create complex selector for searching
			$selector = "a[href^='/']";
			foreach($domain_var as $dvar)
			{
				$selector .= ", a[href^='".$dvar."']";
			}			
			return $selector;
		}
		
		static function get_domain($url)
		{
			//get url parts
			$url_parts = parse_url($url);
			
			$domain_var = array();
			$domain = $full_domain  = $url_parts['host'];
			if(strpos($url_parts['host'],"www.") !== 0) { 
				$full_domain = "www.".$url_parts['host']; 					     	
			} else { 
				$domain = ltrim($url_parts['host'],"www."); 						
			}
						
			array_push($domain_var,$domain);    									//domain
			array_push($domain_var,$full_domain);    								//www.domain
			array_push($domain_var,$url_parts['scheme'] . "://" . $domain);			//http://domain
			array_push($domain_var,$url_parts['scheme'] . "://" . $full_domain);	//http://www.domain
			
			return array_reverse($domain_var);
		}
		
		static function storeMainLink($url, $sitemap, $domain_var = array())
		{
			$linkModel = new LinkModel(self::$db, $sitemap, array($url));
			$main_link = $linkModel->save($domain_var)[0];
			
			return $main_link;
		}
		
		static function saveLinks($sitemap, $related_links, $parent, $domain_var = array())
		{
			$linkModel = new LinkModel(self::$db, $sitemap, $related_links, $parent);
			$linkModel->save($domain_var);
		}
		
		static function get_next_empty_link($sitemap)
		{
			LinkModel::$db = self::$db;
			return LinkModel::get_next_link($sitemap);
		}
		
		static function get_links($page, $sitemap = null)
		{
			LinkModel::$db = self::$db;
			return LinkModel::get_links($page, $sitemap);
		}
	}
?>
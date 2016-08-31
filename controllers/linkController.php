<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	include_once "$root/libraries/simplehtmldom/simple_html_dom.php";
	
	class LinkController{
		static function parse($url){
			//get html page content
			$site_content = file_get_html($url);
			
			//get links
			foreach($site_content->find(self::getLinksSelector($url)) as $a) 
			{
				echo $a->href . '<br>';
			}
		}
		
		static function getLinksSelector($url)
		{
			//get url parts
			$url_parts = parse_url($url);
					
			//get domain
			$domain = $full_domain  = $url_parts['host'];
			if(strpos($url_parts['host'],"www.") !== 0) { 
				$full_domain = "www.".$url_parts['host']; 							//www.domain
			} else { 
				$domain = ltrim($url_parts['host'],"www."); 						//domain
			}
			$domain_with_scheme=$url_parts['scheme'] . "://" . $domain; 			//http://domain
			$domain_with_scheme_full=$url_parts['scheme'] . "://" . $full_domain; 	//http://www.domain
			
			//create complex selector for searching
			$selector = 'a[href^="'.$domain.'"]'.
					  ', a[href^="'.$full_domain.'"]'.
					  ', a[href^="'.$domain_with_scheme.'"]'.
					  ', a[href^="'.$domain_with_scheme_full.'"]'.
					  ', a[href^="/"]';
			
			return $selector;
		}
	}
?>
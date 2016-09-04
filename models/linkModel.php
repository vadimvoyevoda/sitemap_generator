<?php
	class LinkModel{
		private $parent_id = null;
		private $sitemap = "";
		private $related_links = array();
		static $db;
		
		function __construct($db, $sitemap, $related_links = array(), $parent_id = null)
		{
			$this->sitemap = $sitemap;
			$this->related_links = $related_links;
			$this->parent_id = $parent_id;
			self::$db = $db;
		}
		
		static function get_next_link($sitemap){
			return self::$db->selectOne("LINKS","*","GOT_RELATIVE_LINKS = 0 AND SITEMAP = ".$sitemap);
		}
		
		function prepare_link($link)
		{
			$link = rtrim($link,"/");
			foreach($domain as $d)
			{
				$link = str_replace($d,"/",$link);					
			}
			$link = str_replace("//","/",$link);	
			return $link;
		}
		
		function save($domain = array())
		{	
			$inserted_links = array();
			foreach($this->related_links as $link)
			{	
				$fields = array("LINK", "SITEMAP");
				$link = $this->prepare_link($link);
				
				$vals = array($link, $this->sitemap);
				$where = "";
				for($i=0; $i<count($fields); $i++)
				{
					if(!empty($where))
					{
						$where .= " AND ";
					}
					$where .= $fields[$i] . " = '" . $vals[$i] . "'";
				}
				
				$res = self::$db->selectAll("LINKS","*",$where);
				if(empty($res))
				{
					if(!empty($this->parent_id))
					{
						$parent_depth = self::$db->selectOne("LINKS","DEPTH","LINK_ID = ".$this->parent_id)['DEPTH'];
						array_push($fields,"DEPTH");
						array_push($vals,$parent_depth+1);
					}
					$link_id = self::$db->insert("LINKS",$fields,$vals);
				} else {
					$link_id = $res[0]['LINK_ID'];
				}
								
				$lp_fields = array("LINK_ID");
				$lp_vals = array($link_id);	
				if(!empty($this->parent_id))
				{
					array_push($lp_fields,"PAGE_ID");
					array_push($lp_vals,$this->parent_id);
				}
				self::$db->insert("LINKS_PAGES",$lp_fields,$lp_vals);
				array_push($inserted_links, $link_id);
			}
			self::$db->update("LINKS",array("GOT_RELATIVE_LINKS"),array(1),"LINK_ID = ".$this->parent_id);
			return $inserted_links;
		}
		
		static function get_links($sitemap, $page)
		{
			
			$join = "lp LEFT JOIN LINKS l ON lp.LINK_ID = l.LINK_ID";
			$where = "l.SITEMAP = ".$sitemap." AND lp.PAGE_ID ".(!empty($page)?(" = ".$page):"IS NULL");
			return self::$db->selectAll("LINKS_PAGES","*",$where,null,null,$join);
		}
	}
?>
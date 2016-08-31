<?php
	class LinkModel{
		$link = "";
		$related_links = array();
		
		function __construct($link, $related_links = array())
		{
			$this->link = $link;
			$this->related_links = $related_links;
		}
		
		function save()
		{
			
		}
	}
?>
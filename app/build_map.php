<?php
	if(!empty($_POST['website']))
	{
		$root = realpath($_SERVER["DOCUMENT_ROOT"]);
		include_once "$root/controllers/linkController.php";
		LinkController::parse($_POST['website']);		
	}
?>
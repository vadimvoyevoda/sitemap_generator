<?php 
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include("$root/views/header.html");
include("$root/app/get_links.php");
include("$root/views/footer.html"); 
?>
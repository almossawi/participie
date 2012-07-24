<?php
session_start();
require_once("config.php");

if(isset($_GET['loadmore'])) {
	//get all pies, limit to $_GET['loadmore'];
	echo "loading more...";
}

?>
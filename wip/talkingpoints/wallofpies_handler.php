<?php
session_start();
require("/var/www/vhosts/participie.com/httpdocs/config.php");
require("/var/www/vhosts/participie.com/httpdocs/wip/dataaccess/global.php");

if(isset($_GET['loadmore'])) {
	//get all pies, limit to $_GET['loadmore'];
	echo "loading more...";
}

if(isset($_POST['filter'])) {
	doFilter($_POST['filter'], "talkingpoints");
}
elseif(isset($_GET['action'])) {
	if($_GET['action'] == "getAverageTalkingPointsPie") {
		$where_clause = urldecode($_GET['where']);
		
		$for_label = $_GET['for_label']; //e.g. RS, RL, etc.
		
		$avg_pie_data = getAverageTalkingPointsPie($where_clause);
		$avg_pie_count = $avg_pie_data[0];
		$avg_pie = $avg_pie_data[1];
		
		echo $for_label . "|" . $avg_pie_count . "|" . $avg_pie;
	}
}

?>
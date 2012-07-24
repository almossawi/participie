<?php
session_start();
require("/var/www/vhosts/participie.com/httpdocs/config.php");
require("/var/www/vhosts/participie.com/httpdocs/uat/dataaccess/global.php");

if(isset($_GET['loadmore'])) {
	//get all pies, limit to $_GET['loadmore'];
	echo "loading more...";
}


if(isset($_POST['filter'])) {
	if($_POST['filter'] == "all") {
		$where = "1=1";
	}
	else if($_POST['filter'] == 1 || $_POST['filter'] == 2 || $_POST['filter'] == 3 || $_POST['filter'] == 4 || $_POST['filter'] == 5 || $_POST['filter'] == 6) {
		$where = "age=" . htmlentities(strip_tags(trim($_POST['filter'])), ENT_QUOTES, 'UTF-8');
	}
	else if($_POST['filter'] == 'M' || $_POST['filter'] == 'F') {
		$where = "gender='" . htmlentities(strip_tags(trim($_POST['filter'])), ENT_QUOTES, 'UTF-8') . "'";
	}
	else if($_POST['filter'] == 'NN' || $_POST['filter'] == 'DS' || $_POST['filter'] == 'DL' || $_POST['filter'] == 'RS' || $_POST['filter'] == 'RL') {
		$where = "politics='" . htmlentities(strip_tags(trim($_POST['filter'])), ENT_QUOTES, 'UTF-8') . "'";
	}

	//construct sql statement with the filter value as the where clause
	$query = "SELECT `id`, `politics`,`state`,`gender`,`zip`, `age`, `pie`, `comment` FROM `cooked_pies_topics_to_discuss` " .
			"WHERE " . $where . " " . 
			"ORDER BY `id` DESC LIMIT 100";

	#connect to mysql
	$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

	#select db
	$db_selected = mysql_select_db($config['db_name'],$connection);

	$result_locale = mysql_query("SET NAMES 'utf8'");
		
	$result = mysql_query($query);
		
	if(!$result) {
		$content .= "Oops, something messed up";
		$content .= 'Oops, mysql messed up: ' . mysql_error() . "\n";
		$content .= 'Whole query: ' . $query;
		echo $content;
	}
	else {
				echo "<h2 style='display:block;text-align:left;font-size:12pt;padding-left:8px'>Show</h2> ";
				//echo "<h2 style='font-size:12pt;display:inline;text-align:center;margin-left:auto;margin-right:auto'>Showing " . mysql_num_rows ($result) . " pies</h2>";
				
				while ($row = mysql_fetch_assoc($result)) {
					$permalink = "http://www.participie.com/wip/talkingpoints/?p=" . $row['id'];
					
					$icon;
					//if($row['politics'] == 'RL' || $row['politics'] == 'RS') $icon = "republican_icon.png";  
					//elseif($row['politics'] == 'DL' || $row['politics'] == 'DS')   $icon = "democrat_icon.png";
					if($row['politics'] == 'RL') $icon = "republican_icon.png"; 
					elseif($row['politics'] == 'RS') $icon = "republican_strong_icon.png";
					elseif($row['politics'] == 'DL')   $icon = "democrat_icon.png";
					elseif($row['politics'] == 'DS') $icon = "democrat_strong_icon.png";
					elseif($row['politics'] == 'NN')   $icon = "neutral_icon.png";
					
					echo "<div class='minipie_container' id='container_" . $row['id'] . "'";
					if($icon != "") echo " style='background-image:url(../images/$icon)'";
					echo ">";
					
					echo "<a href='" . $permalink . "'><img src='../images/link_16.png' style='position:absolute;top:5px;left:216px;z-index:999' title='Permalink' alt='Permalink' /></a>";
					
					echo "<svg class='minipie' id='minipie_" . $row['id'] . "' width='180px' height='180px'></svg>";
					echo "<input type='hidden' id='piedata_" . $row['id'] . "' value='" . $row['pie'] . "' />";
				    echo "<br /><strong>" . decodePolitics($row['politics']) . " voter from " . $row['state'] . "</strong><br />";

				    echo "<i><a href='#' style='text-decoration:none' onclick='return false' onmouseover='showFullComment(\"" . $row['comment'] . "\", \"" . "#container_" . $row['id'] . "\")' onmouseout='hideFullComment()'>" . formatComment($row['comment'])  . "</a></i>";

				    echo "</div>";
				}
	}
}

?>
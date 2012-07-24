<?php
session_start();

require_once("config.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta http-equiv="Pragma" content="no-cache">
		<title>Participie - Wall of pies</title>
		<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/styles_wop.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="js/d3.js"></script>
		<script type="text/javascript" src="js/d3.layout.js"></script>
		<script src="js/jquery.corner.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/styledButton.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/uniform.default.css" type="text/css" media="screen" charset="utf-8" />
		<script src="js/jquery.uniform.js" type="text/javascript"></script>
		<script src="js/jquery.styledButton.js" type="text/javascript"></script>
		<link href='http://fonts.googleapis.com/css?family=Mystery+Quest' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Junge' rel='stylesheet' type='text/css'>
		
		<script src='js/jquery.corner.js' type='text/javascript'></script>
		<script src="js/global.js" type="text/javascript"></script>
	</head>
	<body>
		<h1>Participie</h1>
		
		<div id="top_nav_bar">
			 <a href="index.html">Shape your Pie</a> &middot; <a href="wallofpies.php">Wall of Pies</a> &middot; <a href="http://www.skyrill.com/participie/blog">Blog</a> &middot; <a href="http://www.skyrill.com/participie/blog/?page_id=13">About</a>
		</div>
		<div id="hovered_over_node" style="display:none"></div>
		</div>
		
		<div id="wall_of_pies_content" style="">
			<!--<div id="loading">Loading...</div>-->
			<div style="width:250px;position:absolute;left:1045px;margin-left:auto;text-align:center">
				<select id='show_filter'>
					<option value='all'>Show all</option>
					<option value='males'>Show only males</option>
					<option value='females'>Show only females</option>
					<option value='rp'>Show Republicans</option>
					<option value='dm'>Show Democrats</option>
					<option value='nn'>Show Neutrals</option>
				</select>
			</div>
				
			<?php
			function decodePolitics($politics) {
				switch($politics) {
					case "DS":
						return "Strong Democrat";
					case "DL":
						return "Lean Democrat";
					case "RS":
						return "Strong Republican";
					case "RL":
						return "Lean Republican";
					case "NN":
						return "Neutral";
				}
			}
			
			function formatComment($str) {
				if(strlen($str) > 40)
					return substr($str, 0, 40) . "...";
				else
					return $str;
			}
			
			#connect to mysql
			$connection = mysql_connect($config['sql_host'],$config['sql_user'],$config['sql_pass']);

			#select db
			$db_selected = mysql_select_db($config['db_name'],$connection);

			$result_locale = mysql_query("SET NAMES 'utf8'");

			$query = "SELECT `id`, `politics`,`state`,`gender`,`zip`, `age`, `pie`, `comment` FROM `cooked_pies` " .
					"ORDER BY `id` DESC LIMIT 100";
		
			$result = mysql_query($query);
		
			if(!$result) {
				$content .= "Oops, something messed up";
				$content .= 'Oops, mysql messed up: ' . mysql_error() . "\n";
				$content .= 'Whole query: ' . $query;
				echo $content;
			}
			else {
				echo "<h2 style='text-align:center;margin-left:auto;margin-right:auto'>" . mysql_num_rows ($result) . " delicious pies baked so far!</h2>";
				
				while ($row = mysql_fetch_assoc($result)) {
					$icon;
					if($row['politics'] == 'RL' || $row['politics'] == 'RS') $icon = "republican_icon.png";  
					elseif($row['politics'] == 'DL' || $row['politics'] == 'DS')   $icon = "democrat_icon.png";
					elseif($row['politics'] == 'NN')   $icon = "neutral_icon.png";
					
					echo "<div class='minipie_container' id='container_" . $row['id'] . "'";
					if($icon != "") echo " style='background-image:url(images/$icon)'";
					echo ">";
					
					echo "<svg class='minipie' id='minipie_" . $row['id'] . "' width='180px' height='180px'></svg>";
					echo "<input type='hidden' id='piedata_" . $row['id'] . "' value='" . $row['pie'] . "' />";
				    echo "<br /><strong>" . decodePolitics($row['politics']) . " voter from " . $row['state'] . "</strong><br />";

				    echo "<i><a href='#' style='text-decoration:none' onclick='return false' onmouseover='showFullComment(\"" . $row['comment'] . "\", \"" . "#container_" . $row['id'] . "\")' onmouseout='hideFullComment()'>" . formatComment($row['comment'])  . "</a></i>";

				    echo "</div>";
				}
			}
			?>
				
			<script type="text/javascript">
			drawMiniPies();
			
			$(window).scroll(function () { 
				if ($(window).scrollTop() >= $(document).height() - $(window).height() - 100) {
					//Add something at the end of the page
					var dataString = 'loadmore=' + 200;
				    $.ajax({  
		    		  type: "GET",  
				      url: "wallofpies_handler.php",  
			    	  data: dataString,  
				      success: function(data) {
						console.log("got more pies (todo)");
				      }  
			    	});
				}
			});

			</script>

		</div>
	</body>
</html>
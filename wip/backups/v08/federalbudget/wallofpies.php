<?php
session_start();

require_once("config.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta http-equiv="Pragma" content="no-cache" />
		<title>Participie, Federal Budget - Wall of pies</title>
		<script type="text/javascript">
			var data_file_to_load = "data_files/data-2012.json";
		</script>
		<link href="../css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="../js/jquery.min.js" type="text/javascript"></script>
		<script src="../js/jquery-ui.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../css/styles_wop.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="../js/d3.js"></script>
		<script type="text/javascript" src="../js/d3.layout.js"></script>
		<script src="../js/jquery.corner.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../css/styledButton.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="../css/uniform.default.css" type="text/css" media="screen" charset="utf-8" />
		<script src="../js/jquery.uniform.js" type="text/javascript"></script>
		<script src="../js/jquery.styledButton.js" type="text/javascript"></script>
		<link href='http://fonts.googleapis.com/css?family=Mystery+Quest' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css' />
		<link href='http://fonts.googleapis.com/css?family=Junge' rel='stylesheet' type='text/css' />
		
		<script src='js/jquery.corner.js' type='text/javascript'></script>
		<script src="../js/global.js" type="text/javascript"></script>
	</head>
	<body style="background-image:url(../images/blackstrip.jpg);background-color:#e6e6dc;background-position:50% 0px">

	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30696925-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

		<div style="width:1260px;position:fixed:top:0;left:0;background-color:#222222;height:80px;padding:0;margin:0">
			<!--<span style="color:white;position:absolute;right:140px;top:50px"><a href="bakery.php" style="color:white">The bakery</a></span>-->
			<a href="/"><img src="../images/logo.png" style="position:absolute;left:2px;top:2px;border:0" /></a>
		</div>
		
		<div id="top_nav_bar">
			 <a href="/">Home</a> &middot; <a href="/bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="/about.html">About us</a>
		</div>
		<div id="hovered_over_node" style="display:none"></div>
		</div>
		
		<div id="wall_of_pies_content" style="">
			<!--<div id="loading">Loading...</div>-->
<!--			<div style="width:250px;position:absolute;left:1045px;margin-left:auto;text-align:center">
				<select id='show_filter'>
					<option value='all'>Show all</option>
					<option value='males'>Show only males</option>
					<option value='females'>Show only females</option>
					<option value='rp'>Show Republicans</option>
					<option value='dm'>Show Democrats</option>
					<option value='nn'>Show Neutrals</option>
				</select>
			</div>-->
				
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
				if(strlen($str) > 35)
					return substr($str, 0, 35) . "...";
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

<div style="clear:both;margin-top:200px;display:block;position:relative;width:100%;margin-top:100px;height:30px;font-size:12px;padding:8px;text-align:center">
						<a href="/">Home</a> &middot; <a href="/bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="/about.html">About us</a> &middot; <a href="/privacy.html">Privacy</a>
						<br /><span style="font-size:90%">Copyright 2012 A couple of folks at MIT</span>
					</div>
					
		</div>
	</body>
</html>
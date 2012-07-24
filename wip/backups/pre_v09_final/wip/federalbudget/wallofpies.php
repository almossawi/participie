<?php
session_start();

require("/var/www/vhosts/participie.com/httpdocs/config.php");
require("/var/www/vhosts/participie.com/httpdocs/wip/dataaccess/global.php");
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
			<a href="../index.html"><img src="../images/logo.png" style="position:absolute;left:2px;top:2px;border:0" /></a>
		</div>
	
		<div id="top_nav_bar">
				<!--<a href="http://www.mit.edu"><img src="/images/mit_logo.png" style="position:absolute;right:90px;top:-20px;border:0;z-index:999;height:30px" alt="MIT" title="MIT" /></a>
				<a href="http://macroconnections.media.mit.edu"><img src="/images/macroconnections_logo.png" style="position:absolute;right:190px;top:-30px;border:0;z-index:999;height:45px" alt="Macro Connections" title="Macro Connections" /></a>-->
				 <a href="../index.html">Home</a> &middot; <a href="../bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="../about.html">About us</a>
		</div>
		
		<div id="hovered_over_node" style="display:none"></div>
		</div>
		
		<label style="font-family: Georgia, Times, Arial;font-size:34px;color:white;position:absolute;left:360px;top:20px;width:500px;text-align:center">Federal Budget Pies</label>
		
		<div id="wall_of_pies_content">
			<div style="width:250px;position:absolute;left:1036px;top:410px;margin-left:auto;text-align:center">
				<select id='show_filter'>
					<option value='all'>Show all</option>
					<optgroup label="Gender">
						<option value='males'>Female</option>
						<option value='females'>Male</option>
					</optgroup>
					<optgroup label="Politics">
						<option value='rs'>Strong Republicans</option>
						<option value='rl'>Lean Republicans</option>
						<option value='nn'>Center</option>
						<option value='dl'>Lean Democrats</option>
						<option value='ds'>Strong Democrats</option>
					</optgroup>
					<optgroup label="Age">
						<option value="1">18 to 24</option>
						<option value="2">25 to 34</option>
						<option value="3">35 to 44</option>
						<option value="4">45 to 54</option>
						<option value="5">55 to 64</option>
						<option value="6">65 or older</option>
					</optgroup>
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

			
			//average pies
			echo "<h2 style='text-align:center;margin-left:auto;margin-right:auto'>Average Pies</h2>";
			$arr = array(
				"ds"=>"Strong Democrat", 
				"dl"=>"Lean Democrat", 
				"nn"=>"Neutral", 
				"rl"=>"Lean Republican", 
				"rs"=>"Strong Republican");
				
			//create panes
			foreach($arr as $p => $label) {	
					$icon;
					if($p == "ds") $icon = "democrat_strong_icon.png"; 
					elseif($p == "dl") $icon = "democrat_icon.png";
					elseif($p == "nn")   $icon = "neutral_icon.png";
					elseif($p == "rl") $icon = "republican_icon.png";
					elseif($p == "rs")   $icon = "republican_strong_icon.png";
					
					echo "<div class='minipie_container' id='container_" . $p . "'";
					if($icon != "") echo " style='background-image:url(../images/$icon);margin-bottom:20px'";
					echo ">";
					
					echo "<svg class='minipie' id='".$p."' width='180px' height='180px'></svg>";
				    echo "<br /><strong>".$label." (<span id='".$p."_count'></span>)</strong><br />";

				    echo "</div>";
			}
			
			//get average pies for each one
			$rs_avg_pie_data = getAverageFederalBudgetPie("politics='RS'");
			$rs_avg_pie_count = $rs_avg_pie_data[0]; $rs_avg_pie = $rs_avg_pie_data[1];
			$rl_avg_pie_data = getAverageFederalBudgetPie("politics='RL'");
			$rl_avg_pie_count = $rl_avg_pie_data[0]; $rl_avg_pie = $rl_avg_pie_data[1];
			$nn_avg_pie_data = getAverageFederalBudgetPie("politics='NN'");
			$nn_avg_pie_count = $nn_avg_pie_data[0]; $nn_avg_pie = $nn_avg_pie_data[1];
			$dl_avg_pie_data = getAverageFederalBudgetPie("politics='DL'");
			$dl_avg_pie_count = $dl_avg_pie_data[0]; $dl_avg_pie = $dl_avg_pie_data[1];
			$ds_avg_pie_data = getAverageFederalBudgetPie("politics='DS'");
			$ds_avg_pie_count = $ds_avg_pie_data[0]; $ds_avg_pie = $ds_avg_pie_data[1];
			
			//draw them
			?>
			<script type="text/javascript">
				if("<?php echo $rs_avg_pie_count; ?>" != 0) {
					var rs_avg_pie = <?php echo $rs_avg_pie; ?>;
					drawArbitraryPie(rs_avg_pie, "rs", 180, 180, 9);
				}
				$("#rs_count").html(<?php echo $rs_avg_pie_count; ?>)
				
				if("<?php echo $rl_avg_pie_count; ?>" != 0) {
					var rl_avg_pie = <?php echo $rl_avg_pie; ?>;
					drawArbitraryPie(rl_avg_pie, "rl", 180, 180, 9);
				}
				$("#rl_count").html(<?php echo $rl_avg_pie_count; ?>)
				
				if("<?php echo $nn_avg_pie_count; ?>" != 0) {		
					var nn_avg_pie = <?php echo $nn_avg_pie; ?>;
					drawArbitraryPie(nn_avg_pie, "nn", 180, 180, 9);
				}
				$("#nn_count").html(<?php echo $nn_avg_pie_count; ?>)
						
				if("<?php echo $dl_avg_pie_count; ?>" != 0) {
					var dl_avg_pie = <?php echo $dl_avg_pie; ?>;
					drawArbitraryPie(dl_avg_pie, "dl", 180, 180, 9);
				}
				$("#dl_count").html(<?php echo $dl_avg_pie_count; ?>)
				
				if("<?php echo $ds_avg_pie_count; ?>" != 0) {
					var ds_avg_pie = <?php echo $ds_avg_pie; ?>;
					drawArbitraryPie(ds_avg_pie, "ds", 180, 180, 9);
				}
				$("#ds_count").html(<?php echo $ds_avg_pie_count; ?>)
			</script>
			
			<?php
			//all pies
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
				echo "<h2 style='display:block;text-align:center;margin-left:auto;margin-right:auto'>" . mysql_num_rows ($result) . " delicious pies baked so far!</h2>";
				
				while ($row = mysql_fetch_assoc($result)) {
					$permalink = "http://www.participie.com/wip/federalbudget/?p=" . $row['id'];
					
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
						<a href="../index.html">Home</a> &middot; <a href="/bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="/about.html">About us</a> &middot; <a href="/privacy.html">Privacy</a>
						<br /><span style="font-size:90%">Copyright 2012 Macro Connections group, MIT</span>
					</div>
					
		</div>
	</body>
</html>
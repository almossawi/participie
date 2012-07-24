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
		<link href='http://fonts.googleapis.com/css?family=Revalia' rel='stylesheet' type='text/css'>
		
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
			<a href="../index.php"><img src="../images/logo.png" style="position:absolute;left:2px;top:2px;border:0" /></a>
		</div>
	
		<div id="top_nav_bar">
				<a href="../index.php">home</a> &middot; <a href="../bakery.php" id="bakery_menu_a">the bakery</a> &middot; <a href="/blog">blog</a> &middot; <a href="../about.php">about us</a>
		</div>
		<div class="corner menu_extensions" id="bakery_menu_extension">
			<div style="border-top:1px solid #3b3b3b;width:94%;height:1px;position:relative;top:-5px"></div>
			&raquo; or &nbsp;&nbsp;<a href="index.php">bake a new pie</a>
		</div>
		
		<div id="stats_box" class="corner">
			<?php
			$stats = getStats("federalbudget");
			$comments = getLatestComments("federalbudget", 4);

			echo "<div style='width:50%;float:left'>";
			echo "<span style='font-family:Georgia,Italic,Palatino;font-style:italic'>Quick statistics</span><br />";
			echo "<div style='width:99%;border-top:1px dotted #cccccc;height:1px;margin-top:4px;margin-bottom:6px'></div>";
			echo $stats['n'] . " delicious pies baked so far!<br />";
			echo $stats['comments_n'] . " comments posted so far<br />";
			echo "Most contributors are "; echo ($stats['most_gender'] == "M") ? "male" : "female"; echo "<br />";
			echo "Most contributors are from " . getFullStateName($stats['most_state']) . "<br />";
			echo "</div>";
			
			echo "<div style='width:48%;height:100%;padding-left:10px;margin-left:3px;float:right'>";
			echo "<span style='font-family:Georgia,Italic,Palatino;font-style:italic'>Latest comments</span><br />";
			echo "<div style='width:99%;border-top:1px dotted #cccccc;height:1px;margin-top:4px;margin-bottom:6px'></div>";
			foreach($comments as $key => $value) {
				echo "<span style='font-style:italic;font-size:90%'><a href='http://www.participie.com/wip/federalbudget/?p=$key'><span style='font-family:Revalia'>&ldquo;</span>" . $value . "<span style='font-family:Revalia'>&rdquo;</span></a></span><br />";
			}
			echo "</div>";
			?>
		</div>
		
		<div id="hovered_over_node" style="display:none"></div>
		</div>
		
		<label style="font-family: Georgia, Times, Arial;font-size:34px;color:white;position:absolute;left:360px;top:20px;width:500px;text-align:center">Federal Budget Pies</label>
		
		<div id="wall_of_pies_content">
			<div style="width:230px;position:absolute;left:70px;top:541px">
				<select id='show_filter'>
					<option value='all'>Latest</option>
					<optgroup label="Gender">
						<option value='F'>Females</option>
						<option value='M'>Males</option>
					</optgroup>
					<optgroup label="Politics">
						<option value='RS'>Strong Republicans</option>
						<option value='RL'>Lean Republicans</option>
						<option value='NN'>Center</option>
						<option value='DL'>Lean Democrats</option>
						<option value='DS'>Strong Democrats</option>
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
				<img src='../images/loader.gif' id="loader" />
			</div>
							
			<?php
			//average pies
			echo "<h2 style='text-align:left;font-size:12pt;padding-left:8px'>Average Pies</h2>";
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
			?>
			
			<script type="text/javascript">
			updateAveragePies("FederalBudget", "", ""); //draw the average pies (using JS, was PHP+JS before)
			</script>
			
			<div id="allpies">
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
				echo "<h2 style='display:block;text-align:left;font-size:12pt;padding-left:8px'>Show</h2> ";
				
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
			</div> <!-- end allpies div -->

<div style="clear:both;margin-top:200px;display:block;position:relative;width:100%;margin-top:100px;height:30px;font-size:12px;padding:8px;text-align:center">
						<a href="../index.php">Home</a> &middot; <a href="../bakery.php">The bakery</a> &middot; <a href="../blog">Blog</a> &middot; <a href="../about.php">About us</a> &middot; <a href="../privacy.php">Privacy</a><br />
						<span style="font-size:90%">Copyright 2012 Macro Connections group, MIT</span>
					</div>
					
		</div>
	</body>
</html>
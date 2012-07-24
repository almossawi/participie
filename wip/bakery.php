<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta http-equiv="Pragma" content="no-cache" />
		<title>Participie - The bakery</title>
		<link href="css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="js/d3.js"></script>
		<script type="text/javascript" src="js/d3.layout.js"></script>
		<script src="js/jquery.corner.js" type="text/javascript"></script>
		<link rel="stylesheet" href="css/styledButton.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="css/uniform.default.css" type="text/css" media="screen" charset="utf-8" />
		<script src="js/jquery.uniform.js" type="text/javascript"></script>
		<script src="js/jquery.styledButton.js" type="text/javascript"></script>
		<link href="http://fonts.googleapis.com/css?family=Mystery+Quest" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Junge" rel="stylesheet" type="text/css" />
		
		<script src="js/jquery.corner.js" type="text/javascript"></script>
		<script src="js/global.js" type="text/javascript"></script>
		
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
</head>
	<body style="background-image:none;background-color:#e6e6dc;background-position:50% 4px">
	
	<?php
	require_once("dataaccess/global.php");
	$federalbudget_count = getPieCounts("");
	$talkingpoints_count = getPieCounts("_talkingpoints");
	?>
	
		<div style="width:100%;position:absolute:top:0;left:0;background-color:#222222;height:80px;padding:0;margin:0">
			<a href="index.php"><img src="images/logo.png" style="position:absolute;left:2px;top:2px;border:0" /></a>
			<!--<a href="http://www.mit.edu"><img src="images/mit_logo.png" style="position:absolute;right:80px;top:30px;border:0;z-index:999;height:30px" alt="MIT" title="MIT" /></a>
			<a href="http://macroconnections.media.mit.edu"><img src="images/macroconnections_logo.png" style="position:absolute;right:180px;top:20px;border:0;z-index:999;height:45px" alt="Macro Connections" title="Macro Connections" /></a>-->
			<a href="/bakery.php"><img src="images/pies.png" style="position:absolute;right:30px;top:80px;border:0;z-index:999" alt="The bakery" title="The bakery" /></a>
		</div>
		
		<div id="top_nav_bar_not_fixed">
			<!--<a href="http://www.mit.edu"><img src="/images/mit_logo.png" style="position:absolute;right:90px;top:-20px;border:0;z-index:999;height:30px" alt="MIT" title="MIT" /></a>
			<a href="http://macroconnections.media.mit.edu"><img src="/images/macroconnections_logo.png" style="position:absolute;right:190px;top:-30px;border:0;z-index:999;height:45px" alt="Macro Connections" title="Macro Connections" /></a>-->
			<a href="index.php">home</a> &middot; <a href="bakery.php">the bakery</a> &middot; <a href="/blog">blog</a> &middot; <a href="about.php">about us</a>
		</div>
		
		<img src="images/waitress.png" style="position:absolute;left:-70px;top:90px" alt="Mmmm...Pie" />
		
		<div style="width:800px;height:400px;margin-left:-400px;margin-top:-175px;left:50%;top:30%;position:absolute;text-align:center;border:0px solid black">
			<div style="position:absolute;left:0;top:100px">
				<div class="corner" style="position:relative;top:80px;width:800px;height:470px;background-color:white;border:0px solid #cccccc;text-align:left;padding:10px">
					<p class="page_title">The bakery</p>
					<p style="font-size:15px;color:#2e2e2e;margin-bottom:20px;padding-bottom:20px">The bakery is where you can see the pies that can be worked on, see what others have baked and bake your own pie.  We currently have two to choose from.  The pies shown below are the <i>average</i> pies for each one.</p>
					
					<div style="float: left; width: 49%;text-align:center">
<span style="margin-bottom: 3px; padding-bottom: 3px;">How do you think the federal budget should be distributed?</span><br />
<!--<a href="/federalbudget/"><img src="images/pie_medium.png" alt="Federal budget pie" style="border:0" /></a><br />-->
<svg id="federalbudget_avg_pie" class="average_pie" style="border:0px solid black;width:250px;height:250px;position:relative;display:block;left:70px;padding-bottom:1px" width="250" height="250"></svg>
<span style="font-size:110%;font-weight:bold;color:#d81717">&raquo; </span><a href="federalbudget/">Bake a pie</a> &nbsp;<span style="font-size:110%;font-weight:bold;color:#d81717">&raquo; </span><a href="federalbudget/wallofpies.php">See pies (<?php echo $federalbudget_count; ?>)</a>

</div>
<div style="float: right; width: 49%; margin-left: 10px;text-align:center">
<span style="margin-bottom: 3px; padding-bottom: 3px;">What topics do the presidential candidates need clarify their positions on?</span>
<!--<a href="/talkingpoints/"><img src="images/pie_medium.png" alt="Federal budget pie" style="border:0" /></a><br />-->
<svg id="talkingpoints_avg_pie" class="average_pie" style="border:0px solid black;width:250px;height:250px;position:relative;display:block;left:70px;padding-bottom:1px" width="250" height="250"></svg>
<span style="font-size:110%;font-weight:bold;color:#d81717">&raquo; </span><a href="talkingpoints/">Bake a pie</a> &nbsp;<span style="font-size:110%;font-weight:bold;color:#d81717">&raquo; </span><a href="talkingpoints/wallofpies.php">See pies (<?php echo $talkingpoints_count; ?>)</a>

</div>

					
</div>

					
				</div>
				<div style="position:relative;width:100%;margin-top:700px;height:30px;font-size:12px;padding:8px;text-align:center">
						<a href="index.php">Home</a> &middot; <a href="bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="about.php">About us</a> &middot; <a href="privacy.php">Privacy</a>
						<br /><span style="font-size:90%">Copyright 2012 Macro Connections Group, MIT</span>
					</div>
			</div>
			
			<div id="hovered_over_node" style="display:none"></div>
			<div class="dim"></div>
			
			<?php
				$avg_talking_points_pie_data = getAverageTalkingPointsPie();
				$avg_talking_points_pie_count = $avg_talking_points_pie_data[0]; $avg_talking_points_pie = $avg_talking_points_pie_data[1];
				$avg_federal_budget_pie_data = getAverageFederalBudgetPie();
				$avg_federal_budget_pie_count = $avg_federal_budget_pie_data[0]; $avg_federal_budget_pie = $avg_federal_budget_pie_data[1];
			?>
			<script type="text/javascript">
				//var avg_talking_points_pie = jQuery.parseJSON(<?php echo $avg_talking_points_pie; ?>);
				var avg_talking_points_pie = <?php echo $avg_talking_points_pie; ?>;
				drawArbitraryPie(avg_talking_points_pie, "talkingpoints_avg_pie", 250, 250, 10.5);
				
				var avg_federal_budget_pie = <?php echo $avg_federal_budget_pie; ?>;
				drawArbitraryPie(avg_federal_budget_pie, "federalbudget_avg_pie", 250, 250, 10.5);
			</script>
	</body>
</html>
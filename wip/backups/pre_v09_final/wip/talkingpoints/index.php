<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta http-equiv="Pragma" content="no-cache" />
		<title>Participie - Help decide what the candidates should be clarifying their positions about</title>
		<script type="text/javascript">
			//var repeat_visitor = 0;
			var data_file_to_load = "data_files/data-talkingpoints.json";
		</script>
		<script src="../js/cookie.js" type="text/javascript"></script>
		<script src="../js/json2.js" type="text/javascript"></script>
		<link href="../css/jquery-ui.css" rel="stylesheet" type="text/css" />
		<script src="../js/jquery.min.js" type="text/javascript"></script>
		<script src="../js/jquery-ui.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../css/styles.css" type="text/css" media="screen" charset="utf-8" />
		<script type="text/javascript" src="../js/d3.js"></script>
		<script type="text/javascript" src="../js/d3.layout.js"></script>
		<script src="../js/jquery.corner.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../css/styledButton.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="../css/uniform.default.css" type="text/css" media="screen" charset="utf-8" />
		<script src="../js/jquery.uniform.js" type="text/javascript"></script>
		<script src="../js/jquery.styledButton.js" type="text/javascript"></script>
		<link href="http://fonts.googleapis.com/css?family=Mystery+Quest" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Junge" rel="stylesheet" type="text/css" />
		
		<meta property="og:title" content="Participie.com - What issues should the candidates be clarifying their position about?" /> 
		<meta property="og:description" content="What issues should the candidates be clarifying their position about? Participate by resizing the pie using the sliders. Since time is constrained, you will need to reduce a slice before you can increase another one.  When you're done, submit your pie, so we can consolidate them into something meaningful for other citizens and for the 2012 presidential candidates!" /> 
		<meta property="og:image" content="http://www.participie.com/thumb.jpg" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="http://www.participie.com/" />
		<meta property="og:site_name" content="Participie.com" />
		<meta property="fb:admins" content="542418566" />
		
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
	<body style="background-image:url(../images/blackstrip.jpg);background-color:#e6e6dc;background-position:50% 0px">
		<script type="text/javascript">
			if ($.browser.msie && parseInt($.browser.version) < 9){
				document.write("<div style='text-align:center;position:absolute;left:250px;top:100px;color:#3b3b3b'><span style='font-size:125%'>You're using a version of Internet Explorer older than 9.0.</span><br />Please <a href='http://windows.microsoft.com/en-US/internet-explorer/downloads/ie' style='color:black;text-decoration:underline'>upgrade</a> to the latest version of IE or access this page using Firefox, Chrome or Safari!</div>");
			}
		</script>
		<div style="width:1310px;position:fixed:top:0;left:0;background-color:#222222;height:80px;padding:0;margin:0">
			<!--<span style="color:white;position:absolute;right:140px;top:50px"><a href="bakery.php" style="color:white">The bakery</a></span>-->
			<a href="../index.html"><img src="../images/logo.png" style="position:absolute;left:2px;top:2px;border:0" /></a>
			<div style="position:absolute;top:-8px;left:995px;width:300px"><a href="#" class="button orange" style="font-weight:bold;color:white;font-size:10pt;padding:10px;padding-top:20px" id="playvideo">Trouble working the pie? Watch this video!</a></div>
			<div id="top_nav_bar">
				<a href="../index.html">Home</a> &middot; <a href="../bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="../about.html">About us</a>
			</div>
		</div>
		
		<div id="submission_box">
			<span style="position:absolute;top:-55px;color:white;text-align:center">Mmmm...that looks delicious!<br />We'll just need some info, if that's ok</span>
			<img src="../images/political_scale.png" style="position:relative;left:5px" alt="" />
			<label><input type="radio" name="politics" value="DL" /><br />Strong<br />Democrat</label>
			<label><input type="radio" name="politics" value="DS" /><br />Lean<br />Democrat</label>
			<label><input type="radio" name="politics" value="NN" /><br />Center</label>
			<label><input type="radio" name="politics" value="RL" /><br />Lean<br />Republican</label>
			<label class="label_last"><input type="radio" name="politics" value="RS" /><br />Strong<br />Republican</label>
			<div style="display:block;clear:both;height:12px"></div>
			<div style="float:left;height:30px">
				<label><span style="font-size:9pt;position:relative;top:4px">State</span></label>
			</div>
			<div style="float:right;height:30px">
				<label />
					<select name="state" id="state">
						<option value="">Choose your state</option>
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
			</div>
			<div style="float:left;height:30px">
			<label><span style="font-size:9pt;position:relative;top:4px">Gender</span></label>
			</div>
			<div style="float:right;height:30px">
				<label>
					<select name="gender" id="gender">
						<option value="">Choose your gender</option>
						<option value="M">Male</option>
						<option value="F">Female</option>
					</select>
				</label>
			</div>
			<div style="float:left;height:30px">
				<label><span style="font-size:9pt;position:relative;top:4px">Age</span></label>
			</div>
			<div style="float:right;height:30px">
				<label>
					<select name="age" id="age">
						<option value="">Choose your age</option>
						<option value="1">18 to 24</option>
						<option value="2">25 to 34</option>
						<option value="3">35 to 44</option>
						<option value="4">45 to 54</option>
						<option value="5">55 to 64</option>
						<option value="6">65 or older</option>
					</select>
				</label>
			</div>
			<div style="float:left;height:30px;width:130px;padding-top:2px">
				<label><span style="font-size:9pt;position:relative;top:2px">Zip code (optional)</span></label>
			</div>
			<div style="float:right;height:30px;width:80px;padding-top:2px">
				<label><input id="zip" name="zip" type="text" maxlength="5" style="border:1px solid #cccccc;height:13px;font-family:'Myriad Pro', Arial;padding:3px;width:50px;font-size:10pt" /></label>
			</div>
			<label><span style="font-size:9pt;position:relative;top:0">Comment (optional)</span></label>
			<textarea id="comment" name="comment" style="width:273px;height:50px;margin-top:3px;background-color:#fff" maxlength="140"></textarea>
			<button id="submit_button" class="button red" style="font-size:80%;margin-top:21px;left:50px">I'm all done, bake my pie!</button>
			<input type="hidden" id="pie" name="pie" value="" />
			<input type="hidden" id="slice_war" name="slice_war" value="" />
			<input type="hidden" id="slice_gay" name="slice_gay" value="" />
			<input type="hidden" id="slice_mar" name="slice_mar" value="" />
			<input type="hidden" id="slice_edu" name="slice_edu" value="" />
			<input type="hidden" id="slice_hel" name="slice_hel" value="" />
			<input type="hidden" id="slice_eco" name="slice_eco" value="" />
			<input type="hidden" id="slice_gun" name="slice_gun" value="" />
			<input type="hidden" id="slice_pri" name="slice_pri" value="" />
			<input type="hidden" id="slice_glo" name="slice_glo" value="" />
			
			<!--</form>-->
			<div id="message" style="position:relative;top:0px;left:6px;height:80px"></div>
			<div style="position:absolute;color:white;font-size:8px;text-align:center;left:205px;top:5px;width:200px;margin-left:auto;margin-right:auto"><a id="close_overlayed" href="#" style="color:white;text-decoration:none" onclick="return false"><img src="../images/x_black_small.png" style="border:0;cursor:pointer;width:14px;height:14px" /></a></div>
			
			<div id='sharebox_post_submit'>
			<span style="color:#000000;padding-top:0;margin-top:0;font-size:14px">Share your pie</span>
				<div class='twitter' style='width:110px;padding-top:8px'>
					<!-- content set once pie is submitted -->
				</div>
				<div class='facebook' style='position:relative;width:50px;padding-top:4px;overflow:hidden'>
					<!-- content set once pie is submitted -->
				</div>
				<div class='pinterest' style='width:110px;overflow:hidden;padding-top:4px'>
					<!-- content set once pie is submitted -->
				</div>
				<div class='linkedin' style='width:110px;padding-top:4px;padding-left:2px'>
					<!-- content set once pie is submitted -->
				</div>
				<!--<div class='googleplus' style='width:32px;overflow:hidden'>
				</div>-->
				
				<div style="margin-top:14px;padding-top:10px;border-top:1px dotted black;font-size:12px">
					&raquo; <a id="permalink" href="http://permalink" onclick="return flase">Direct link</a><br />
					&raquo; <a href="/wip/talkingpoints/wallofpies.php">See all pies</a>
				</div>
			</div>
			
		</div>
		<div id="intro_box">
			<img id="close" src="../images/x_white.png" alt="close" style="position:absolute;left:720px;top:10px;" />
			<div id="intro_box_content">
				<h1 style="margin-top:0;color:#fff">Good to see you!</h1>
				<p>We're sure you have an opinion about the presidential candidates' talking points. So how about sharing it with the candidates and the world?</p>
				<p>Help us gather these opinions by "baking a participie" that the world, and the candidates, will see.</p>
				<img src="../images/intro_steps.png" style="border:0;position:relative;left:-20px;top:-10px" alt="" />
			</div>
		</div>
		<div class="dim"></div>
		<label style="font-family: Georgia, Times, Arial;font-size:24px;color:white;position:absolute;left:360px;top:14px;width:500px;text-align:center">The candidates should clarify their position with respect to…</label>

		<div style="float:left;width:450px">
			<h2 style="position:relative;top:25px;left:80px;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0">Slice ranking</h2>

			<div id="budget_overview">
				<div id="fWAR_budget_function_container" class="container">
					<input type="hidden" name="fWAR_d" id="fWAR_d" class="d" value="1" />
					<label id="fWAR" class="names_label">War in Afghanistan</label>
					<label id="fWAR_data" class="values_label"></label>
					<div id="fWAR_color" class="color_bar"></div>
					<div id="fWAR_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fGAY_budget_function_container" class="container">
					<input type="hidden" name="fGAY_d" id="fGAY_d" class="d" value="1" />
					<label id="fGAY" class="names_label">Gay marriage</label>
					<label id="fGAY_data" class="values_label"></label>
					<div id="fGAY_color" class="color_bar"></div>
					<div id="fGAY_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fMAR_budget_function_container" class="container">
					<input type="hidden" name="fMAR_d" id="fMAR_d" class="d" value="1" />
					<label id="fMAR" class="names_label">Legalization of marijuana</label>
					<label id="fMAR_data" class="values_label"></label>
					<div id="fMAR_color" class="color_bar"></div>
					<div id="fMAR_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fECO_budget_function_container" class="container">
					<input type="hidden" name="fECO_d" id="fECO_d" class="d" value="1" />
					<label id="fECO" class="names_label">Economy</label>
					<label id="fECO_data" class="values_label"></label>
					<div id="fECO_color" class="color_bar"></div>
					<div id="fECO_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fGUN_budget_function_container" class="container">
					<input type="hidden" name="fGUN_d" id="fGUN_d" class="d" value="1" />
					<label id="fGUN" class="names_label">Gun laws</label>
					<label id="fGUN_data" class="values_label"></label>
					<div id="fGUN_color" class="color_bar"></div>
					<div id="fGUN_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fHEL_budget_function_container" class="container">
					<input type="hidden" name="fHEL_d" id="fHEL_d" class="d" value="1" />
					<label id="fHEL" class="names_label">Healthcare</label>
					<label id="fHEL_data" class="values_label"></label>
					<div id="fHEL_color" class="color_bar"></div>
					<div id="fHEL_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fEDU_budget_function_container" class="container">
					<input type="hidden" name="fEDU_d" id="fEDU_d" class="d" value="1" />
					<label id="fEDU" class="names_label">Education</label>
					<label id="fEDU_data" class="values_label"></label>
					<div id="fEDU_color" class="color_bar"></div>
					<div id="fEDU_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fPRI_budget_function_container" class="container">
					<input type="hidden" name="fPRI_d" id="fPRI_d" class="d" value="1" />
					<label id="fPRI" class="names_label">Online privacy</label>
					<label id="fPRI_data" class="values_label"></label>
					<div id="fPRI_color" class="color_bar"></div>
					<div id="fPRI_color_proportional" class="color_bar_proportional"></div>
				</div>
				<div id="fGLO_budget_function_container" class="container">
					<input type="hidden" name="fGLO_d" id="fGLO_d" class="d" value="1" />
					<label id="fGLO" class="names_label">Global warming</label>
					<label id="fGLO_data" class="values_label"></label>
					<div id="fGLO_color" class="color_bar"></div>
					<div id="fGLO_color_proportional" class="color_bar_proportional"></div>
				</div>
			</div>
			<!--<div id="moreinfo">
				<div id="moreinfo_container">Mouse over a budget category to see more info about it here, including the budget functions that it consolidates, if applicable.  Details of the spending for each budget function are from <a href="http://budget.house.gov/BudgetProcess/BudgetFunctions.htm" target="_blank">here</a>.</div>
			</div>-->
			<div id="overview_box" style="top:470px">
				<h2 style="position:relative;top:-2px;margin-top:0;padding-top:0">Details...</h2>
				<p>What issues should the candidates be clarifying their position about? Participate by resizing the pie using the sliders. Since time is constrained, you will need to reduce a slice before you can increase another one.</p>
				<p>When you're done, submit your pie, so we can consolidate them into something meaningful for other citizens and for the 2012 presidential candidates!</p>
			</div>
			<div class="content">
				<div id="loading">Loading...</div>
				<div id="hovered_over_node" style="display:none"></div>
			</div>
			<div id="the_slice_im_on">
			</div>
			<div id="sunburst_container">
			</div>
			<div id="submission_pre_box">
				<a href="#" id="submit_load_button" class="button red" style="padding:20px" onclick="return false">I'm all done, bake my pie!</a>
				<!--<div style="border-top:1px dashed #cccccc;width:270px;margin-top:15px;padding-top:15px;font-size:13px;text-align:center">
					Remember to tell your friends
				</div>-->
			</div>
			<!--<div style="position:absolute;top:750px;left:530px">
				<label><input id="show_labels_on_hover" type="checkbox" /><span style="position:relative;top:6px">Show tooltips on hover</span></label>
				</div>-->
		</div>
		<div id="rhs_container">
			<div id="receipt">
				<div style="font-weight:bold;display:block;position:relative;top:150px;left:-5px;width:100%;text-align:center">
					<!--(Mouse over a budget function to see its info here)-->
				</div>
			</div>
			
				<div style="position:absolute;width:260px;margin-top:10px;height:30px;font-size:12px;padding:8px;text-align:center">
						<a href="../index.html">Home</a> &middot; <a href="../bakery.php">The bakery</a> &middot; <a href="/blog">Blog</a> &middot; <a href="../about.html">About us</a> &middot; <a href="../privacy.html">Privacy</a>
						<br /><span style="font-size:90%">Copyright 2012 Macro Connections Group, MIT</span>
				</div>
			<!--<div style="margin-top:20px">
				<a href="/" id="federalbudget_button" class="button orange" style="font-size:16px;padding:10px">How should the federal budget be distributed? Try that pie</a>
			</div>-->
		</div>
		<div id="video_box">
			<a id="close_video_box" href="#" onclick="return false"><img src="../images/x_black_small.png" alt="close" style="border:0;cursor:pointer;width:14px;height:14px;position:absolute;right:-16px" /></a>
			<iframe src="http://player.vimeo.com/video/39872334?api=1&amp;title=0&amp;byline=0&amp;portrait=0" width="500" height="375" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
		<script src="../js/jquery.corner.js" type="text/javascript"></script>
		<script src="../js/global.js" type="text/javascript"></script>
	</body>
</html>
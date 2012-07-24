<?php 
/**
 * HEADER
 *
 * This file controls the HTML <head> and top graphical markup (including
 * Navigation) for each page in your theme. You can control what shows up where
 * using WordPress and PageLines PHP conditionals.
 *
 * @package     PageLines Framework
 * @since       1.0
 *
 * @link        http://www.pagelines.com/
 * @link        http://www.pagelines.com/tour
 *
 * @author      PageLines   http://www.pagelines.com/
 * @copyright   Copyright (c) 2008-2012, PageLines  hello@pagelines.com
 *
 * @internal    last revised January 23, 2012
 * @version     ...
 *
 * @todo Define version
 */

pagelines_register_hook('pagelines_before_html'); // Hook
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
		<link href='http://fonts.googleapis.com/css?family=Mystery+Quest' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>

<?php 		
		pagelines_register_hook('pagelines_head'); // Hook 
		
		wp_head(); // Hook (WordPress) 
			
		pagelines_register_hook('pagelines_head_last'); // Hook
?>

		<link rel="stylesheet" href="../wip/css/styles.css" type="text/css" media="screen" charset="utf-8" />

</head>
<body <?php body_class( pagelines_body_classes() ); ?>>

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

		<div style="width:100%;position:absolute:top:0;left:0;background-color:#222222;height:80px;padding:0;margin:0">
			<a href="../wip/index.html"><img src="../wip/images/logo.png" style="position:absolute;left:2px;top:2px;border:0" /></a>
			<a href="../wip/bakery.php"><img src="../wip/images/pies.png" style="z-index:999;position:absolute;right:30px;top:80px;border:0" alt="The bakery" title="The bakery" /></a>
		</div>

		<div id="top_nav_bar_not_fixed">
				 <a href="../wip/index.html" style="color:#db1818">Home</a> &middot; <a href="../wip/bakery.php" style="color:#db1818">The bakery</a> &middot; <a href="../wip/blog" style="color:#db1818">Blog</a> &middot; <a href="../wip/about.html" style="color:#db1818">About us</a>
		</div>
</div>

<?php 
pagelines_register_hook('pagelines_before_site'); // Hook
	
if(has_action('override_pagelines_body_output')):
	do_action('override_pagelines_body_output');

else:  ?>
<div id="site" style="margin-left:0;position:absolute;left:0" class="<?php echo pagelines_layout_mode();?>">
<?php pagelines_register_hook('pagelines_before_page'); // Hook ?>
	<div id="page" class="thepage">
		<div class="page-canvas">
			<?php pagelines_register_hook('pagelines_before_header');?>

			<header id="header" class="container-group">
				<div class="outline">
					<?php pagelines_template_area('pagelines_header', 'header'); // Hook ?>
				</div>
			</header>

			<?php pagelines_register_hook('pagelines_before_main'); // Hook ?>
			<div id="page-main" class="container-group">
				<div id="dynamic-content" class="outline">		
<?php endif;?>
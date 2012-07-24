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

		<link rel="stylesheet" href="/participie/css/styles.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body <?php body_class( pagelines_body_classes() ); ?>>
<h1 style="padding-top:10px;padding-left:15px">Participie</h1>
		
		<div id="top_nav_bar" style="top:52px;left:775px">
			 <a href="/participie/index.html">Shape your Pie</a> &middot; <a href="/participie/wallofpies.php">Wall of Pies</a> &middot; <a href="http://www.skyrill.com/participie/blog">Blog</a> &middot; <a href="http://www.skyrill.com/participie/blog/?page_id=13">About</a>
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
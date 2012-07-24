<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>" />
        <title>
            <?php
            /*
             * Print the <title> tag based on what is being viewed.
             */
            global $page, $paged;

            wp_title('|', true, 'right');

            // Add the blog name.
            bloginfo('name');

            // Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            if ($site_description && ( is_home() || is_front_page() ))
                echo " | $site_description";

            // Add a page number if necessary:
            if ($paged >= 2 || $page >= 2)
                echo ' | ' . sprintf(__('Page %s', 'cloriato'), max($paged, $page));
            ?>
        </title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <?php
        /* We add some JavaScript to pages with the comment form
         * to support sites with threaded comments (when in use).
         */
        if (is_singular() && get_option('thread_comments'))
            wp_enqueue_script('comment-reply');
        /* Always have wp_head() just before the closing </head>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to add elements to <head> such
         * as styles, scripts, and meta tags.
         */
        wp_head();
        ?>
        <!--[if gte IE 9]>
                <script type="text/javascript">
                        Cufon.set('engine', 'canvas');
                </script>
        <![endif]-->
    </head>
    <body  <?php body_class(); ?> background="<?php if (inkthemes_get_option('inkthemes_bodybg') != '') {
            echo inkthemes_get_option('inkthemes_bodybg');
        } else { ?><?php echo get_template_directory_uri(); ?>/images/bodybg.png<?php } ?>" >
        <div class="top_cornor"></div>
        <div class="body-content">
            <!--Start Container-->
            <div class="container_24">
                <!--Start Header Wrapper-->
                <div class="grid_24 header_wrapper">
                    <!--Start Header-->
                    <div class="header">
                        <div class="grid_14 alpha">
                            <div class="logo"> <a href="<?php echo home_url(); ?>"><img src="<?php if (inkthemes_get_option('inkthemes_logo') != '') { ?><?php echo inkthemes_get_option('inkthemes_logo'); ?><?php } else { ?><?php echo get_template_directory_uri(); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" /></a></div>
                        </div>
                        <div class="grid_10 omega">
                            <div class="top_right_bar">
                                <ul class="social_logos">
                                    <?php if (inkthemes_get_option('inkthemes_facebook') != '') { ?>
                                        <li class="facebook"><a href="<?php echo inkthemes_get_option('inkthemes_facebook'); ?>"><span></span></a></li>
                                    <?php } else {
                                        
                                    } ?>
                                    <?php if (inkthemes_get_option('inkthemes_upon') != '') { ?>
                                        <li class="upon"><a href="<?php echo inkthemes_get_option('inkthemes_upon'); ?>"><span></span></a></li>
                                    <?php } else {
                                        
                                    } ?>
                                    <?php if (inkthemes_get_option('inkthemes_rss') != '') { ?>
                                        <li class="rss"><a href="<?php echo inkthemes_get_option('inkthemes_rss'); ?>"><span></span></a></li>
                                <?php } else {
                                    
                                } ?>
                                <?php if (inkthemes_get_option('inkthemes_twitter') != '') { ?>
                                        <li class="twitter"><a href="<?php echo inkthemes_get_option('inkthemes_twitter'); ?>"><span></span></a></li>
                                <?php } else {
    
                                } ?>
                                </ul>
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <!--Start Menu wrapper-->
                        <div class="menu_wrapper">
                            <!--Start menu-div-->
                            <?php inkthemes_nav(); ?>
                            <!--End menu-div-->
                        </div>
                        <!--End Menu wrapper-->
                    </div>
                    <!--End Header-->
                </div>
                <!--End Header Wrapper-->
                <div class="clear"></div>

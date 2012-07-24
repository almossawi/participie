<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */
?>
<?php get_header(); ?>
<!--Start Content Wrapper-->
<div class="grid_24 content_wrapper">
  <div class="grid_16 alpha">
    <!--Start Content-->
    <div class="content">
      <?php if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs(); ?>
      <?php get_template_part( 'loop', 'index' ); ?>
        <div class="clear"></div>
    <nav id="nav-single"> <span class="nav-previous">
        <?php next_posts_link( __( '&larr; Older posts', 'cloriato' ) ); ?>
        </span> <span class="nav-next">
        <?php previous_posts_link( __( 'Newer posts &rarr;', 'cloriato' ) ); ?>
        </span> </nav>
    </div>
    <!--End Content-->
  </div>
  <!--Start Sidebar-->
  <?php get_sidebar(); ?>
  <!--End Sidebar-->
</div>
<!--End Content Wrapper-->
<div class="clear"></div>
</div>
<!--End Container-->
<?php get_footer(); ?>

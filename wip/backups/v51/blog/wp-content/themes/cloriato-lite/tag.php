<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 */
get_header(); ?>
<!--Start Content Wrapper-->
<div class="grid_24 content_wrapper">
  <div class="grid_16 alpha">
    <?php if ( have_posts() ) : ?>
    <!--Start Content-->
    <div class="content">
      <?php if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs(); ?>
      <h1><?php printf( __( 'Tag Archives: %s', 'cloriato' ), '' . single_cat_title( '', false ) . '' );?></h1>
      <?php get_template_part( 'loop', 'index' ); ?>
      <?php /* Display navigation to next/previous pages when applicable */ ?>
      <?php if (  $wp_query->max_num_pages > 1 ) : ?>
      <?php next_posts_link( __( '&larr; Older posts', 'cloriato' ) ); ?>
      <?php previous_posts_link( __( 'Newer posts &rarr;', 'cloriato' ) ); ?>
      <?php endif; ?>
    </div>
    <!--End Content-->
    <?php endif; ?>
  </div>
  <!--Start Sidebar-->
  <?php get_sidebar(); ?>
  <!--End Sidebar-->
</div>
<!--End Content Wrapper-->
<div class="clear"></div>
</div>
<!--End Container-->
</div>
<!--End Content Bg-->
<?php get_footer(); ?>

<?php
/*
Template Name: Fullwidth Page
*/
?>
<?php get_header(); ?>
<!--Start Content Wrapper-->
<div class="grid_24 content_wrapper">
  <div class="fullwidth-page">
    <?php //if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs(); ?>
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <h1>
      <?php the_title(); ?>
    </h1>
    <?php the_content(); ?>
    <?php endwhile;?>
  </div>
</div>
<!--End Content Wrapper-->
<div class="clear"></div>
</div>
<!--End Container-->
<?php get_footer(); ?>

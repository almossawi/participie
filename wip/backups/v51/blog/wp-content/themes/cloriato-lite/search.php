<?php
/**
 * The Search Page.
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
      <?php if ( have_posts() ) : ?>
      <?php the_content(); ?>
      <h1><?php printf( __( 'Search Results for: %s', 'cloriato' ), '' . get_search_query() . '' ); ?></h1>
      <!--Start Post-->
      <?php get_template_part( 'loop', 'search' ); ?>
      <!--End Post-->
      <?php else : ?>
      <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
          <h1 class="entry-title">
            <?php _e( 'Nothing Found', 'cloriato' ); ?>
          </h1>
        </header>
        <!-- .entry-header -->
        <div class="entry-content">
          <p>
            <?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'cloriato' ); ?>
          </p>
          <?php get_search_form(); ?>
        </div>
        <!-- .entry-content -->
      </article>
      <!-- #post-0 -->
      <?php endif; ?>
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

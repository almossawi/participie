<?php
/**
 * The single template file.
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
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <!--Start Content-->
    <div class="content">
      <?php// if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs(); ?>
      <!--Start Post-->
      <div class="post single">
        <h1 class="post_title">
          <?php the_title(); ?>
        </h1>
        <ul class="post_meta">
          <li class="posted_by"><span><?php _e( 'Posted by', 'cloriato'); ?></span>&nbsp;
            <?php the_author_posts_link(); ?>
          </li>
          <li class="post_date">
            <?php the_time('M-j-Y') ?>
          </li>
          <li class="post_category">
            <?php the_category(', '); ?>
          </li>
          <li class="postc_comment">&nbsp;
            <?php comments_popup_link('0 Comments.', ' 1 Comment.', ' % Comments.'); ?>
          </li>
        </ul>
        <hr/>
        <div class="post_content">
          <?php the_content(); ?>
		  <div class="clear"></div>
		  <?php wp_link_pages(array('before' => '' . __('Pages:', 'cloriato'), 'after' => '')); ?>
          <p>
            <?php the_tags(); ?>
          </p>
        </div>
      </div>
      <!--End Post-->
      <div class="clear"></div>
        <nav id="nav-single"> <span class="nav-previous">
        <?php previous_post_link( '%link','<span class="meta-nav">&larr;</span> Previous Post '); ?>
        </span> <span class="nav-next">
        <?php next_post_link( '%link','Next Post <span class="meta-nav">&rarr;</span>'); ?>
        </span> </nav>
      <!--Start Comment box-->
      <?php comments_template(); ?>
      <!--End comment Section-->
    </div>
    <!--End Content-->
    <?php endwhile;?>
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

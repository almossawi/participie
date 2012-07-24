<?php get_header(); ?>
<div class="main">
	<?php if (have_posts()) while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?> <?php edit_post_link(__('Edit this entry', 'clean_and_clear'), '', ''); ?></h1>
		<?php the_content(); ?>
		<div id="comments">
			<?php comments_template(); ?>
		</div>
		<p class="pages"><?php wp_link_pages(); ?></p>
	<?php endwhile; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
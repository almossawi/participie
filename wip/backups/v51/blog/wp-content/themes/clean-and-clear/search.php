<?php get_header(); ?>
<div class="main">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<!-- Start: Post -->
			<div <?php post_class(); ?>>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php edit_post_link(__('Edit this entry', 'clean_and_clear'), '', ''); ?></h2>
				<p class="post-meta"><span class="date"><?php the_time( get_option( 'date_format' ) ) ?></span> <span class="author"><?php the_author() ?></span> <span class="cats"><?php the_category(", "); ?></span><?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span> <?php endif; ?></p>
				<?php the_post_thumbnail(); ?>
				<?php the_excerpt(); ?>
				<p class="more"><a href="<?php the_permalink() ?>"><?php _e( ' ', 'clean_and_clear' ); ?></a></p>
				<?php if(has_tag()): ?><p class="tags"><span><?php the_tags(""); ?></span></p><?php endif; ?>
			</div>
			<!-- End: Post -->
		<?php endwhile; ?>

		<p class="pagination">
			<span class="prev"><?php next_posts_link(__('Previous Posts', 'clean_and_clear')) ?></span>
			<span class="next"><?php previous_posts_link(__('Next posts', 'clean_and_clear')) ?></span>
		</p>
	<?php else : ?>
	<div class="post">
		<h1><?php _e( 'No posts found. Try a different search?', 'clean_and_clear' ); ?></h1>
		<?php get_search_form(); ?>
	</div>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
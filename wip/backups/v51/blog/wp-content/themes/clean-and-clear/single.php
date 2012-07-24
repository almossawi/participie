<?php get_header(); ?>
<div class="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?> <?php edit_post_link(__('Edit this entry', 'clean_and_clear'), '', ''); ?></h1>
		<p class="post-meta"><span class="date"><?php the_time( get_option( 'date_format' ) ) ?></span> <span class="author"><?php the_author() ?></span> <span class="cats"><?php the_category(", "); ?></span><?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span> <?php endif; ?></p>
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'clean_and_clear').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php if(has_tag()): ?><p class="tags"><span><?php the_tags(""); ?></span></p><?php endif; ?>
		<p><?php posts_nav_link(); ?></p>
		<p class="pagination">
			<span class="prev"><?php previous_post_link('%link'); ?></span>
			<span class="next"><?php next_post_link('%link'); ?></span>
		</p>
		<div id="comments">
			<?php comments_template(); ?>
		</div>
	<?php endwhile; endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

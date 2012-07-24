<?php get_header(); ?>
<div class="main post">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1 class="post-title"><?php the_title(); ?> <?php edit_post_link(__('Edit this entry', 'clean_and_clear'), '', ''); ?></h1>
		<p><?php printf( __( '<a href="%1$s">%2$s</a>', 'clean_and_clear' ), get_permalink( $post->post_parent ), get_the_title( $post->post_parent ));?></p>
		<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a></p>
		<?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?>
		<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages', 'clean_and_clear').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<p class="pagination">
			<span class="alignleft"><?php previous_image_link() ?></span>
			<span class="alignright"><?php next_image_link() ?></span>
		</p>
	<?php comments_template(); ?>

	<?php endwhile; endif; ?>
	</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>


<?php
	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->
<div class="comments">
	<?php if ( ! comments_open() & is_single() )  : ?><p><?php _e( 'Comments are currently closed.', 'clean_and_clear' ); ?></p><?php endif; ?>

	<?php if ($comments) : ?>
		<h3><?php comments_number(__('No Responses', 'clean_and_clear'), __('One Response', 'clean_and_clear'), '% '.__('Responses', 'clean_and_clear') );?> to &#8220;<?php the_title(); ?>&#8221;</h3>
		<ul class="commentlist">
		<?php wp_list_comments(); ?>
		</ul>
	<?php endif; ?>

	<p><?php paginate_comments_links(); ?></p>
	<?php if ( comments_open() ) : ?><?php comment_form(); ?><?php endif; // if you delete this the sky will fall on your head ?>
</div>
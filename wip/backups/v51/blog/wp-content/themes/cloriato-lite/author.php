<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="grid_24 content_wrapper">
    <div class="grid_16 alpha">
        <!--Start Content-->
        <div class="content">
            <?php // if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs();  ?>
            <h2><?php printf(__('Author Archives: %s', 'cloriato'), "<a class='url fn n' href='" . get_author_posts_url(get_the_author_meta('ID')) . "' title='" . esc_attr(get_the_author()) . "' rel='me'>" . get_the_author() . "</a>"); ?></h2>
            <?php if (have_posts()) : the_post(); ?>
                <?php
                // If a user has filled out their description, show a bio on their entries.
                if (get_the_author_meta('description')) :
                    ?>
                    <div id="author-info">
                        <div id="author-avatar"> <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('cloriato_author_bio_avatar_size', 60)); ?> </div>
                        <!-- #author-avatar -->
                        <div id="author-description">
                            <h2><?php printf(__('About %s', 'cloriato'), get_the_author()); ?></h2>
                        <?php the_author_meta('description'); ?>
                        </div>
                        <!-- #author-description	-->
                    </div>
                    <!-- #entry-author-info -->
                <?php endif; ?>
            <?php endif; ?>
            <?php
            /* Since we called the_post() above, we need to
             * rewind the loop back to the beginning that way
             * we can run the loop properly, in full.
             */
            rewind_posts();
            /* Run the loop for the author archive page to output the authors posts
             * If you want to overload this in a child theme then include a file
             * called loop-author.php and that will be used instead.
             */
            get_template_part('loop', 'author');
            ?>
            <div class="clear"></div>
            <nav id="nav-single"> <span class="nav-previous">
                    <?php next_posts_link(__('&larr; Older posts', 'cloriato')); ?>
                </span> <span class="nav-next">
        <?php previous_posts_link(__('Newer posts &rarr;', 'cloriato')); ?>
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

<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 */
get_header();
?>
<!--Start Content Wrapper-->
<div class="grid_24 content_wrapper">
    <div class="grid_16 alpha">
    <?php if (have_posts()) : ?>
            <h1><?php printf(__('Category Archives: %s', 'cloriato'), '' . single_cat_title('', false) . ''); ?></h1>
            <!--Start Content-->
            <div class="content">
                <?php //if (function_exists('inkthemes_breadcrumbs')) inkthemes_breadcrumbs(); ?>
                <?php
                $category_description = category_description();
                if (!empty($category_description))
                    echo '' . $category_description . '';
                /* Run the loop for the category page to output the posts.
                 * If you want to overload this in a child theme then include a file
                 * called loop-category.php and that will be used instead.
                 */
                ?>
                        <?php get_template_part('loop', 'index'); ?>
                <div class="clear"></div>
                <nav id="nav-single"> <span class="nav-previous">
                        <?php next_posts_link(__('&larr; Older posts', 'cloriato')); ?>
                    </span> <span class="nav-next">
                <?php previous_posts_link(__('Newer posts &rarr;', 'cloriato')); ?>
                    </span> </nav>
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
<?php get_footer(); ?>

<?php
/**
 * The template for displaying 404 pages (Not Found).
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
    <?php if (function_exists('inkthemes_breadcrumbs'))
    inkthemes_breadcrumbs(); ?>
            <header class="entry-header">
                <h1 class="entry-title">
        <?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'cloriato'); ?>
                </h1>
            </header>
            <p>
            <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'cloriato'); ?>
            </p>
            <?php get_search_form(); ?>
                    <?php the_widget('WP_Widget_Recent_Posts', array('number' => 10), array('widget_id' => '404')); ?>
            <div class="widget">
                <h2 class="widgettitle">
                    <?php _e('Most Used Categories', 'cloriato'); ?>
                </h2>
                <ul>
            <?php wp_list_categories(array('orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10)); ?>
                </ul>
            </div>
            <?php
            /* translators: %1$s: smilie */
            $archive_content = '<p>' . sprintf(__('Try looking in the monthly archives. %1$s', 'cloriato'), convert_smilies(':)')) . '</p>';
            the_widget('WP_Widget_Archives', array('count' => 0, 'dropdown' => 1), array('after_title' => '</h2>' . $archive_content));
            ?>
            <?php the_widget('WP_Widget_Tag_Cloud'); ?>
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

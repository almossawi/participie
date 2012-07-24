<!--Start Sidebar wrapper-->
<div class="grid_8 sidebar_wrapper omega">
  <!--Start Sidebar-->
  <div class="sidebar">
    <?php if (!dynamic_sidebar('primary-widget-area')) : ?>
    <h2><?php _e( 'Search Here...', 'cloriato'); ?></h2>
    <?php get_search_form(); ?>
    <br/>
    <h2>
      <?php _e('Archives', 'cloriato'); ?>
    </h2>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>
    <h2>
      <?php _e('Categories', 'cloriato'); ?>
    </h2>
    <ul>
      <?php wp_list_categories('title_li'); ?>
    </ul>
    <?php endif; // end primary widget area ?>
    <?php
        // A second sidebar for widgets, just because.
        if (is_active_sidebar('secondary-widget-area')) :
            ?>
    <?php dynamic_sidebar('secondary-widget-area'); ?>
    <?php endif; ?>
  </div>
  <!--End sidebar-->
</div>
<!--End Sidebar wrapper-->

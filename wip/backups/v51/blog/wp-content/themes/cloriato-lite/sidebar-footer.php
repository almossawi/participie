<?php
/**
 * The Footer widget areas.
 *
 * @package WordPress
 */
?>
<div class="footer_widget">
  <div class="grid_8 alpha">
    <div class="widget_inner">
      <?php if (is_active_sidebar('first-footer-widget-area')) : ?>
      <?php dynamic_sidebar('first-footer-widget-area'); ?>
      <?php else : ?>
      <h3><?php _e( 'Setup Footer Widget', 'cloriato'); ?></h3>
      <p><?php _e( 'Setup the Footer Columns from the Widgets Tab under Appearance. Drag and Drop your required widget in the Footer Blocks.', 'cloriato'); ?></p>      
      <?php endif; ?>
    </div>
  </div>
  <div class="grid_8">
    <div class="widget_inner lebo">
      <?php if (is_active_sidebar('second-footer-widget-area')) : ?>
      <?php dynamic_sidebar('second-footer-widget-area'); ?>
      <?php else: ?>
        <h3><?php _e( 'Organization Details', 'cloriato'); ?></h3>
      <p><?php _e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dictum, neq ue ut imperdiet pellentesque.', 'cloriato'); ?></p>
      <?php endif; ?>
    </div>
  </div>
  <div class="grid_8 omega">
    <div class="widget_inner lebo last">
      <?php if (is_active_sidebar('third-footer-widget-area')) : ?>
      <?php dynamic_sidebar('third-footer-widget-area'); ?>
      <?php else: ?>
      <h3><?php _e( 'Contact Information', 'cloriato'); ?></h3>
      <fieldset>
      <?php _e( 'Contact: +91-9926465653', 'cloriato'); ?> <br/>
      <?php _e( 'Email: admin@inkthemes.com', 'cloriato'); ?><br/>
      <a href="http://www.inkthemes.com">www.inkthemes.com</a>
      </fieldset>      
      <?php endif; ?>
    </div>
  </div>
</div>
<div class="clear"></div>

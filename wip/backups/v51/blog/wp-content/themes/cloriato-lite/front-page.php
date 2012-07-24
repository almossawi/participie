<?php
/*
/**
 * The main front page file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 */
?>
<?php get_header(); ?>
<!--Start Slider Wrapper-->
<div class="grid_24 slider_wrapper">
  <!--Start Slider-->
  <div id="slides">
    <div class="slide slides_container"  >
      <!--Start Slider-->
      <div>
        <?php if ( inkthemes_get_option('inkthemes_slideimage1') !='' ) {  ?>
        <img  src="<?php echo inkthemes_get_option('inkthemes_slideimage1'); ?>" alt=""/>
        <?php }  else {  ?>
        <img  src="<?php echo get_template_directory_uri(); ?>/images/img-1.jpg" alt=""/>
        <?php } ?>
        <div class="caption conference">
          <?php if ( inkthemes_get_option('inkthemes_slideheading1') !='' ) {  ?>
            <h2><a href="<?php if ( inkthemes_get_option('inkthemes_slidelink1') !='' ) { echo inkthemes_get_option('inkthemes_slidelink1'); } ?>"><?php echo stripslashes(inkthemes_get_option('inkthemes_slideheading1')); ?></a></h2>
          <?php }  else {  ?>
          <h2><a href="#"><?php _e( 'Single Click Install Wordpress Theme', 'cloriato'); ?></a></h2>
          <?php } ?>
          <?php if ( inkthemes_get_option('inkthemes_slidedescription1') !='' ) {  ?>
          <p><?php echo stripslashes(inkthemes_get_option('inkthemes_slidedescription1')); ?></p>
          <?php }  else {  ?>
          <p><?php _e( 'Get Your Whole Site ready in an Instant. Just Upload the Theme and Press the Activate Button, Your whole site would be loaded with all the Dummy Content and all.', 'cloriato'); ?></p>
          <?php } ?>
        </div>
      </div>
      <!--End Slider-->
     
    </div>
  </div>
  <!--End Slider-->
</div>
<!--End Slider Wrapper-->
<div class="clear"></div>
<!--Start Home content wrapper-->
<div class="grid_24 home_content_wrapper">
  <!--Start home content-->
  <div class="home_content">
    <div class="home_text">
      <?php if ( inkthemes_get_option('inkthemes_mainheading') !='' ) {  ?>
      <h1><?php echo stripslashes(inkthemes_get_option('inkthemes_mainheading')); ?></h1>
      <?php } else {  ?>
      <center><h1><?php _e( 'Welcome to Our Site. Set this Heading from Themes Option Panel.', 'cloriato'); ?></h1></center>
      <?php } ?>
      <?php if ( inkthemes_get_option('inkthemes_heading_desc') !='' ) {  ?>
      <center><p><?php echo stripslashes(inkthemes_get_option('inkthemes_heading_desc')); ?></p></center>
      <?php } else {  ?>
      <center><p>
              <?php _e( 'You can setup almost all the options using the Themes Options Panel. Just fill all the values and your text in the Themes Options Panel Form and just save the changes, the changes would start to reflect on the Home Page of your website. Its really simple and easy to use.', 'cloriato'); ?></p></center>
      <?php } ?>
    </div>
  </div>
  <!--End home content-->
  <hr/>
  <div class="clear"></div>
  <!--Start Feature content-->
  <div class="feature_content">
    <div class="two_third feature_box">
      <div class="feature_inner">
        <?php if ( inkthemes_get_option('inkthemes_col_left_heading') !='' ) {  ?>
        <h2><a href="<?php if ( inkthemes_get_option('inkthemes_col_left_readmore') !='' ) { echo inkthemes_get_option('inkthemes_col_left_readmore'); } ?>"><?php echo stripslashes(inkthemes_get_option('inkthemes_col_left_heading')); ?></a></h2>
        <?php } else {  ?>
        <h2><a href="#"><?php _e( 'What is this place ?', 'cloriato'); ?></a></h2>
        <?php } ?>   
        <?php if ( inkthemes_get_option('inkthemes_col_left_image') !='' ) {  ?>
        <img class="feature_image" src="<?php echo inkthemes_get_option('inkthemes_col_left_image'); ?>"/>
        <?php } else { ?>
        <img class="feature_image" src="<?php echo get_template_directory_uri(); ?>/images/featured-image1.jpg"/>
        <?php } ?>        
        <?php if ( inkthemes_get_option('inkthemes_col_left_desc') !='' ) {  ?>
        <p><?php echo stripslashes(inkthemes_get_option('inkthemes_col_left_desc')); ?></p>
        <?php } else {  ?>        
        <p><?php _e( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dictum, neq
          ue ut imperdiet pellentesque, nulla tellus tempus magna, sed consectetur o
          rci metus a justo. Integer dictum, neque ut imperdiet pellentesque, nullat
          ellus tempus magna, sed consectetur orci metus a justo. Aliq uam ac congu
          e nunc. Mauris a tortor ut massa egestas tempus. Pellentesque tincidunt fe
          rmentum diam sagittis ullamcorper.', 'cloriato'); ?></p>        
        <?php } ?>
        <a href="<?php if ( inkthemes_get_option('inkthemes_col_left_readmore') !='' ) { echo inkthemes_get_option('inkthemes_col_left_readmore'); } ?>" class="read_more"><?php _e( 'read more', 'cloriato'); ?></a>
        </div>
    </div>
    <div class="one_third last">
      <div class="feature_inner right">
        <?php if ( inkthemes_get_option('inkthemes_col_right_heading') !='' ) {  ?>
        <h2><a href="<?php if ( inkthemes_get_option('inkthemes_col_right_readmore') !='' ) { echo inkthemes_get_option('inkthemes_col_right_readmore'); } ?>"><?php echo stripslashes(inkthemes_get_option('inkthemes_col_right_heading')); ?></a></h2>
        <?php } else {  ?>
        <h2><a href="#"><?php _e( 'Out Latest Project', 'cloriato'); ?></a></h2>
        <?php } ?>   
         <?php if ( inkthemes_get_option('inkthemes_col_right_image') !='' ) {  ?>
        <img class="feature_image" src="<?php echo inkthemes_get_option('inkthemes_col_right_image'); ?>"/>
        <?php } else { ?>
        <img class="feature_image" src="<?php echo get_template_directory_uri(); ?>/images/featured-image.jpg"/>
        <?php } ?>
        <?php if ( inkthemes_get_option('inkthemes_col_right_desc') !='' ) {  ?>
        <p><?php echo stripslashes(inkthemes_get_option('inkthemes_col_right_desc')); ?></p>
        <?php } else {  ?>        
        <p><?php _e( 'Theme from InkThemes.com are based on One Click Installation, letting you to create your website at the Click of the button which provides great experience to a customer.', 'cloriato'); ?>
<br/><?php _e( 'Neeraj Agarwal', 'cloriato'); ?>
</p>
        <?php } ?>
<a href="<?php if ( inkthemes_get_option('inkthemes_col_right_readmore') !='' ) { echo inkthemes_get_option('inkthemes_col_right_readmore'); } ?>" class="read_more"><?php _e( 'read more', 'cloriato'); ?></a>
         </div>
    </div> 
  </div>
  <!--End Feature content-->
</div>
<!--End home content wrapper-->
<div class="clear"></div>
</div>
<!--End Container-->
<?php get_footer(); ?>

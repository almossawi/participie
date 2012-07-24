<?php

include_once get_template_directory() . '/functions/inkthemes-functions.php';
$functions_path = get_stylesheet_directory() . '/functions/';
/* These files build out the options interface.  Likely won't need to edit these. */
require_once ($functions_path . 'admin-functions.php');  // Custom functions and plugins
require_once ($functions_path . 'admin-interface.php');  // Admin Interfaces (options,framework, seo)
/* These files build out the theme specific options and associated functions. */
require_once ($functions_path . 'theme-options.php');   // Options panel settings and custom settings

function inkthemes_jquery_init() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('ddsmoothmenu', get_stylesheet_directory_uri() . "/js/ddsmoothmenu.js", array('jquery'));
        wp_enqueue_script('confu', get_stylesheet_directory_uri() . '/js/cufon-yui.js', array('jquery'));
        wp_enqueue_script('font', get_stylesheet_directory_uri() . '/js/Champagne.font.js', array('jquery'));
        wp_enqueue_script('validate', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('verif', get_stylesheet_directory_uri() . '/js/verif.js', array('jquery'));
        wp_enqueue_script('tabbedcontent', get_stylesheet_directory_uri() . '/js/slides.min.jquery.js', array('jquery'));
        wp_enqueue_script('zoombox', get_stylesheet_directory_uri() . '/js/zoombox.js', array('jquery'));
        wp_enqueue_script('custom', get_stylesheet_directory_uri() . "/js/custom.js", array('jquery'));
    } elseif (is_admin()) {
        
    }
}

add_action('init', 'inkthemes_jquery_init');

function inkthemes_get_option( $name ) {
	$options = get_option( 'inkthemes_options' );
	if ( isset( $options[ $name ] ) )
		return $options[ $name ];
}
function inkthemes_update_option( $name, $value ) {
	$options = get_option( 'inkthemes_options' );
	$options[ $name ] = $value;
	
	return update_option( 'inkthemes_options', $options );
}
function inkthemes_delete_option( $name ) {
	$options = get_option( 'inkthemes_options' );
	unset( $options[ $name ] );
	
	return update_option( 'inkthemes_options', $options );
}
?>

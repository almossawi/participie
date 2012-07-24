<?php
/**
 * Functions and actions related to PageLines Extension
 * 
 * @since 2.0.b9
 */

/**
 * Load 'child' styles, functions and templates.
 */	
add_action( 'wp_head', 'load_child_style', 20 );

/**
 *
 * @TODO document
 *
 */
function load_child_style() {

	if ( !defined( 'PL_CUSTOMIZE' ) )
		return;
	
	// check for MU styles
	if ( VDEV && is_multisite() ) {

		global $blog_id;
		$mu_style = sprintf( '%s/blogs/%s/style.css', EXTEND_CHILD_DIR, $blog_id );
		if ( file_exists( $mu_style ) ) {
			$mu_style_url = sprintf( '%s/blogs/%s/style.css', EXTEND_CHILD_URL, $blog_id );
			$cache_ver = '?ver=' . pl_cache_version( $mu_style );
			pagelines_draw_css( $mu_style_url . $cache_ver, 'pl-extend-style' );
		}
	} else {	
		if ( file_exists( PL_EXTEND_STYLE_PATH ) ){

			$cache_ver = '?ver=' . pl_cache_version( PL_EXTEND_STYLE_PATH ); 	
			pagelines_draw_css( PL_EXTEND_STYLE . $cache_ver, 'pl-extend-style' );
		}	
	}	
}

add_action( 'init', 'load_child_functions' );

/**
 *
 * @TODO document
 *
 */
function load_child_functions() {
	if ( !defined( 'PL_CUSTOMIZE' ) )
		return;

	// check for MU styles
	if ( VDEV && is_multisite() ) {
		
		global $blog_id;
		$mu_functions = sprintf( '%s/blogs/%s/functions.php', EXTEND_CHILD_DIR, $blog_id );
		if ( file_exists( $mu_functions ) )
			require_once( $mu_functions );
	} else {

		if ( file_exists( PL_EXTEND_FUNCTIONS ) )
			require_once( PL_EXTEND_FUNCTIONS );
	}
}

add_action( 'init', 'base_check_templates' );


/**
 *
 * @TODO document
 *
 */
function base_check_templates() {

	if ( is_child_theme() ) {
		foreach ( glob( get_stylesheet_directory() . '/*.php') as $file) {
			if ( preg_match( '/page\.([a-z-0-9]+)\.php/', $file, $match ) ) {
				$data = get_file_data( trailingslashit( get_stylesheet_directory() ) . basename( $file ), array( 'name' => 'Template Name' ) );
				if ( is_array( $data ) )
					pagelines_add_page( $match[1], $data['name'] );
			}	
		}
	}
	
	if ( !defined( 'PL_CUSTOMIZE' ) )
		return;

	foreach ( glob( EXTEND_CHILD_DIR . '/*.php') as $file) {

		if ( preg_match( '/page\.([a-z-0-9]+)\.php/', $file, $match ) ) {

			if ( !file_exists( trailingslashit( get_stylesheet_directory() ) . $file ) && is_writable( get_stylesheet_directory() ) ) 
				copy( $file, trailingslashit( get_stylesheet_directory() ) . basename( $file ) );

			if ( file_exists( trailingslashit( get_stylesheet_directory() ) . basename( $file ) ) ) {
				$data = get_file_data( trailingslashit( get_stylesheet_directory() ) . basename( $file ), array( 'name' => 'Template Name' ) );
				if ( is_array( $data ) )
					pagelines_add_page( $match[1], $data['name'] );
			}
		}
	}
}


/**
 *
 * @TODO document
 *
 */
function pagelines_try_api( $url, $options ) {
		
	$prot = array( 'https://', 'http://' );
		
	foreach( $prot as $type ) {	
		// sometimes wamp does not have curl!
		if ( $type === 'https://' && !function_exists( 'curl_init' ) )
			continue;	
		$r = wp_remote_post( $type . $url, $options );
			if ( !is_wp_error($r) && is_array( $r ) ) {
				return $r;				
			}
	}
	return false;
}


/**
 *
 * @TODO document
 *
 */
function pagelines_store_object_sort( $object ) {

    $array = json_decode( json_encode( $object ), true );

	$array = pagelines_array_sort( $array, 'created', false, true );

    $object = new stdClass();
    if (is_array($array) && count($array) > 0) {
      foreach ($array as $name=>$value) {
         $name = ( isset( $value['slug'] ) ) ? $value['slug'] : $name;
         if (!empty($name)) {
            $object->$name = (object) $value;
         }
      }
      return $object; 
    }
    else {
      return FALSE;
    }
}

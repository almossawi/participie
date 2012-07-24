<?php

global $pagelines_template;

// ===================================================================================================
// = Set up Section loading & create pagelines_template global in page (give access to conditionals) =
// ===================================================================================================

/**
 * Build PageLines Template Global (Singleton)
 * Must be built inside the page (wp_head) so conditionals can be used to identify the template
 * In the admin, the template doesn't need to be identified so its loaded in the init action
 * @global object $pagelines_template
 * @since 1.0.0
 */
add_action('pagelines_before_html', 'build_pagelines_template');

/**
 * Build the template in the admin... doesn't need to load in the page
 * @since 1.0.0
 */
add_action('admin_head', 'build_pagelines_template', 5);

add_action('pagelines_before_html', 'build_pagelines_layout', 5);
add_action('admin_head', 'build_pagelines_layout');

/**
 * Optionator
 * Does "just in time" loading of section option in meta; 
 * Will only load section options if the section is present, handles clones
 * @since 1.0.0
 */
add_action('admin_head', array(&$pagelines_template, 'load_section_optionator'));

add_filter( 'pagelines_options_array', 'pagelines_merge_addon_options' );

// Run Before Any HTML
add_action('pagelines_before_html', array(&$pagelines_template, 'run_before_page'));

// Run in <head>
add_action('wp_head', array(&$pagelines_template, 'print_template_section_headers'));

add_action('wp_print_styles', 'workaround_pagelines_template_styles'); // Used as workaround on WP login page (and other pages with wp_print_styles and no wp_head/pagelines_before_html)

add_action( 'wp_print_styles', 'pagelines_get_childcss' );

add_action('pagelines_head', array(&$pagelines_template, 'hook_and_print_sections'));

add_action('wp_footer', array(&$pagelines_template, 'print_template_section_scripts'));

/**
 * Creates a global page ID for reference in editing and meta options (no unset warnings)
 * 
 * @since 1.0.0
 */
add_action('pagelines_before_html', 'pagelines_id_setup', 5);


/**
 * Adds page templates from the child theme.
 * 
 * @since 1.0.0
 */
add_filter('the_sub_templates', 'pagelines_add_page_callback', 10, 2);

/**
 * Adds link to admin bar
 * 
 * @since 1.0.0
 */
add_action( 'admin_bar_menu', 'pagelines_settings_menu_link', 100 );

// ================
// = HEAD ACTIONS =
// ================

/**
 * Add Main PageLines Header Information
 * 
 * @since 1.3.3
 */
add_action('pagelines_head', 'pagelines_head_common');


/**
 * Do dynamic CSS last in the wp_head stack
 * 
 * @since 1.3.3
 */
add_action('wp_head', 'do_dynamic_css', 8);



/**
 *
 * @TODO document
 *
 */
function pagelines_add_google_profile( $contactmethods ) {
	// Add Google Profiles
	$contactmethods['google_profile'] = __( 'Google Profile URL', 'pageines' );
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'pagelines_add_google_profile', 10, 1);

/**
 * ng gallery fix.
 *
 * @return gallery template path
 * 
 */

add_filter( 'ngg_render_template', 'gallery_filter' , 10, 2);


/**
 *
 * @TODO document
 *
 */
function gallery_filter( $a, $template_name) {

	if ( $template_name == 'gallery-plcarousel')
		return sprintf( '%s/carousel/gallery-plcarousel.php', PL_SECTIONS);
	else
		return false;
}

add_action( 'init', 'pagelines_add_sidebars', 1 );


/**
 *
 * @TODO document
 *
 */
function pagelines_add_sidebars() {
	
	if ( ! ploption( 'enable_sidebar_reorder') )
		return;
	global $pagelines_sidebars;

	if ( !is_array( $pagelines_sidebars ) )
		return;

	ksort( $pagelines_sidebars );
	
	foreach ( $pagelines_sidebars as $key => $sidebar )
		register_sidebar( $sidebar );

}

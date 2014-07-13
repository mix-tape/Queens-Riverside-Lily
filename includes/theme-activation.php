<?php

// ==========================================================================
//
//  Theme Activation
//    Activation scripts and theme plugin dependancy checking
//
// ==========================================================================


function sandpit_first_run_options() {
		
	// --------------------------------------------------------------------------
	// Check if theme has been activated before 
	// --------------------------------------------------------------------------

	$check = get_option('sandpit_activation_check');

	if ( $check != "set" ) {
	    
		// --------------------------------------------------------------------------
		// Add Home Page
		// --------------------------------------------------------------------------
	    		
		$default_pages = array('Home', 'About', 'Contact');
		$existing_pages = get_pages();
		$temp = array();
		
		foreach ($existing_pages as $page) {
		  $temp[] = $page->post_title;
		}
		
		$pages_to_create = array_diff($default_pages, $temp);
		
		foreach ($pages_to_create as $new_page_title) {
		
			$add_default_pages = array(
				'post_title' => $new_page_title,
				'post_content' => '',
				'post_status' => 'publish',
				'post_type' => 'page'
			);
		
			$result = wp_insert_post($add_default_pages);
		}
		
		$home = get_page_by_title('Home');
		
		update_option('show_on_front', 'page');
		update_option('page_on_front', $home->ID);
		
		$home_menu_order = array(
			'ID' => $home->ID,
			'menu_order' => -1
		);
		
		wp_update_post($home_menu_order);
	    

		// --------------------------------------------------------------------------
		// Create Nav Menu 
		// --------------------------------------------------------------------------
		
		if (!has_nav_menu('main')) {
			$primary_nav_id = wp_create_nav_menu('Main', array('slug' => 'main'));
			$sandpit_nav_theme_mod['main'] = $primary_nav_id;
		}
		
		if ($sandpit_nav_theme_mod) {
			set_theme_mod('nav_menu_locations', $sandpit_nav_theme_mod);
		}
		
		$primary_nav = wp_get_nav_menu_object('Primary Navigation');
		$primary_nav_term_id = (int) $primary_nav->term_id;
		$menu_items= wp_get_nav_menu_items($primary_nav_term_id);
		
		if (!$menu_items || empty($menu_items)) {
		
			$pages = get_pages();
			
			foreach($pages as $page) {
				$item = array(
				'menu-item-object-id' => $page->ID,
				'menu-item-object' => 'page',
				'menu-item-type' => 'post_type',
				'menu-item-status' => 'publish'
				);
				wp_update_nav_menu_item($primary_nav_term_id, 0, $item);
			}
		}
		
		// --------------------------------------------------------------------------
		// Update options
		// --------------------------------------------------------------------------

		update_option( 'rss_use_excerpt', 1 );
		update_option( 'posts_per_page', 8 );
		update_option( 'timezone_string', 'Australia/Perth' );
		update_option( 'default_post_edit_rows' , 25 );
		update_option( 'upload_path', 'assets' );
		update_option( 'uploads_use_yearmonth_folders', 0);
		update_option( 'blogdescription', '' );
		update_option( 'comments_notify' , 0);
		update_option( 'default_comment_status' , 'closed');
		
    	    
    // --------------------------------------------------------------------------
    // Change Permalink Structure 
    // --------------------------------------------------------------------------
    
		if (get_option('permalink_structure') !== '/%year%/%monthnum%/%postname%/') {
			update_option('permalink_structure', '/%year%/%monthnum%/%postname%/');
		}
		
		global $wp_rewrite;
		$wp_rewrite->init();
		$wp_rewrite->flush_rules(); // Flush rules
		$wp_rewrite->flush_rules(); // Flush rules

		// --------------------------------------------------------------------------
		// Set Theme Activated 
		// --------------------------------------------------------------------------
		
		add_option('sandpit_activation_check', "set");
	}
}

add_action('wp_head', 'sandpit_first_run_options');



// --------------------------------------------------------------------------
// Plugin Activation 
// --------------------------------------------------------------------------

require_once dirname( __FILE__ ) . '/classes/class-plugin-activation.php';

add_action( 'tgmpa_register', 'sandpit_register_required_plugins' );

function sandpit_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		array(
			'name' 		=> 'Advanced Custom Fields',
			'slug' 		=> 'advanced-custom-fields',
			'required' 	=> true,
		),
		
		array(
			'name'     				=> 'Advanced Custom Fields - Flexible Content',
			'slug'     				=> 'acf-flexible-content',
			'source'   				=> get_template_directory() . '/includes/plugins/acf-flexible-content.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
		),
		
		array(
			'name'     				=> 'Advanced Custom Fields - Gallery',
			'slug'     				=> 'acf-gallery',
			'source'   				=> get_template_directory() . '/includes/plugins/acf-gallery.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
		),
		
		array(
			'name'     				=> 'Advanced Custom Fields - Repeater',
			'slug'     				=> 'acf-repeater',
			'source'   				=> get_template_directory() . '/includes/plugins/acf-repeater.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
		),
		
		array(
			'name'     				=> 'Advanced Custom Fields - Options Page',
			'slug'     				=> 'acf-options-page',
			'source'   				=> get_template_directory() . '/includes/plugins/acf-options-page.zip',
			'required' 				=> true,
			'version' 				=> '',
			'force_activation' 		=> false, 
			'force_deactivation' 	=> false,
		),
		
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'tgmpa';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}
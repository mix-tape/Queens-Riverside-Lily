<?php

// ==========================================================================
//
//  Theme Configuration
//    General theme hooks and filters
//
// ==========================================================================


// --------------------------------------------------------------------------
// Add theme support
// --------------------------------------------------------------------------

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'nav-menus' );
// add_theme_support( 'post-thumbnails', array( 'post', 'page', 'product' ) );
// add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat') );
// add_post_type_support( 'post', 'post-formats' );
add_theme_support( 'html5', array('search-form','comment-form','comment-list') );

add_theme_support( 'infinite-scroll', array( 'container' => 'content', 'footer' => 'footer-wrapper') );

set_post_thumbnail_size( 150, 150, true );
add_image_size( 'hero', 2560, 700, true );
add_image_size( 'banner', 650, 300, true );
add_image_size( 'large-banner', 960, 400, true );
add_image_size( 'single-post-thumbnail', 200, 200, true );


update_option('large_size_w', 650);
update_option('large_size_h', 650);
update_option('large_crop', 1);


update_option('medium_size_w', 350);
update_option('medium_size_h', 350);
update_option('medium_crop', 1);


// --------------------------------------------------------------------------
// Add theme navigation
// --------------------------------------------------------------------------

register_nav_menus( array(
	'primary' => __( 'Primary Navigation' ),
) );


// --------------------------------------------------------------------------
// Add theme sidebars
// --------------------------------------------------------------------------

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
			'name' => __( 'Primary Widget Area' ),
		'id' => 'primary-widget-area',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget' => '</section>',
		'before_title' => '<h3 class="widget_title">',
		'after_title' => '</h3>',
	));
}


// --------------------------------------------------------------------------
// Disable the first of the dropdown choices for some faux placeholders
// --------------------------------------------------------------------------

add_filter( 'gform_field_content', 'lily_form_choices', 1, 5 );

function lily_form_choices( $content, $field, $value, $lead_id, $form_id ) {


	/*
	 * Check to make sure we're on the right form
	 */

	if ( 1 !== (int) $form_id ) return $content;


	/*
	 * Check to make sure these are the fields we want to filter
	 */

	$fields = array(3, 4, 5, 6);

	if ( in_array($fields, (int) $field['id']) ) return $content;


	/*
	 * Loop through the first option in this field add a "readonly" and "disabled" attributes
	 */

	foreach ( $field['choices'] as $k => $f ) {

		if ( 0 !== (int) $k ) continue;

		$content = str_replace(
													 array( "value='{$f['value']}'", "for='choice_{$field['id']}_$k'" ),
													 array( "selected readonly disabled value='{$f['value']}'", "'choice_{$field['id']}_$k'" ),
													 $content );
	}


	/*
	 * Return the filtered content of the form field
	 */

	return $content;

}

add_filter("gform_submit_button", "form_submit_button", 10, 2);

function form_submit_button($button, $form)
{
	$mandatory = '<span class="mandatory">* mandatory fields</span>';
	return $mandatory . $button;
}



// --------------------------------------------------------------------------
// Customize Excerpt
// --------------------------------------------------------------------------

function new_excerpt_more($text) {
	return ' <a href="'. get_permalink( get_the_ID() ) . '" class="more">' . '...read more&nbsp;&raquo;' . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function new_excerpt_length($length) {
return 25;
}
add_filter('excerpt_length', 'new_excerpt_length');


// --------------------------------------------------------------------------
// Admin Menu
// --------------------------------------------------------------------------

add_action( 'admin_menu', 'sandpit_admin_menu' );

function sandpit_admin_menu() {
	 remove_menu_page('link-manager.php');
}

// --------------------------------------------------------------------------
// Admin Bar
// --------------------------------------------------------------------------

// Remove inline styles

add_theme_support( 'admin-bar', array( 'callback' => 'my_adminbar_cb') );
function my_adminbar_cb(){

}




// --------------------------------------------------------------------------
// Actions + Filters
// --------------------------------------------------------------------------

// Remove links to the extra feeds (e.g. category feeds)
remove_action( 'wp_head', 'feed_links_extra', 3 );
// Remove links to the general feeds (e.g. posts and comments)
remove_action( 'wp_head', 'feed_links', 2 );
// Remove link to the RSD service endpoint, EditURI link
remove_action( 'wp_head', 'rsd_link' );
// Remove link to the Windows Live Writer manifest file
remove_action( 'wp_head', 'wlwmanifest_link' );
// Remove index link
remove_action( 'wp_head', 'index_rel_link' );
// Remove prev link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// Remove start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// Remove relational links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

// Remove XHTML generator showing WP version
remove_action( 'wp_head', 'wp_generator' );

remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * If we go beyond the last page and request a page that doesn't exist,
 * force WordPress to return a 404.
 * See http://core.trac.wordpress.org/ticket/15770
 */

function paged_404_fix( ) {
	global $wp_query;

	if ( is_404() || !is_paged() || 0 != count( $wp_query->posts ) )
		return;

	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();

}

add_action( 'wp', 'paged_404_fix' );


// --------------------------------------------------------------------------
// Rewrites
// --------------------------------------------------------------------------

function fix_links($input) {
	return preg_replace('!http(s)?://' . $_SERVER['SERVER_NAME'] . '/!', '/', $input);
}

add_action('generate_rewrite_rules', 'sandpit_add_rewrites');

function sandpit_add_rewrites($content) {
	$stylesheetdirectory = explode('/themes/', get_stylesheet_directory());
	$theme_name = next($stylesheetdirectory);
	global $wp_rewrite;
	$sandpit_new_non_wp_rules = array(
		'css/(.*)'		=> 'wp-content/themes/'. $theme_name . '/css/$1',
		'js/(.*)'			=> 'wp-content/themes/'. $theme_name . '/js/$1',
		'images/(.*)'	=> 'wp-content/themes/'. $theme_name . '/images/$1',
		'fonts/(.*)'	=> 'wp-content/themes/'. $theme_name . '/fonts/$1',
		'style.css'		=> 'wp-content/themes/'. $theme_name . '/style.css',
		'logo.png'		=> 'wp-content/themes/'. $theme_name . '/logo.png',
		'apple-touch-icon.png'		=> 'wp-content/themes/'. $theme_name . '/apple-touch-icon.png',
		'favicon.ico'	=> 'wp-content/themes/'. $theme_name . '/favicon.ico',
		'humans.txt'	=> 'wp-content/themes/'. $theme_name . '/humans.txt',
		'plugins/(.*)'=> 'wp-content/plugins/$1',
	);
	$wp_rewrite->non_wp_rules += $sandpit_new_non_wp_rules;
}

function sandpit_clean_assets($content) {
	$theme_dir = explode('/themes/', $content);
	$theme_name = next($theme_dir);
	$current_path = '/wp-content/themes/' . $theme_name;
	$new_path = '';
	$content = str_replace($current_path, $new_path, $content);
	return $content;
}

add_filter('bloginfo', 'sandpit_clean_assets');
add_filter('stylesheet_directory_uri', 'sandpit_clean_assets');
add_filter('template_directory_uri', 'sandpit_clean_assets');


// --------------------------------------------------------------------------
// Remove Dashboard Widgets
// --------------------------------------------------------------------------

function sandpit_remove_dashboard_widgets() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	remove_meta_box('dashboard_primary', 'dashboard', 'side');
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');
	remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');
	remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');
}

add_action('wp_dashboard_setup', 'sandpit_remove_dashboard_widgets');

// --------------------------------------------------------------------------
// Remove Sidebar Widgets
// --------------------------------------------------------------------------

function unregister_default_wp_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);


// --------------------------------------------------------------------------
// We don't need to self-close these tags in html5: <img>, <input>
// --------------------------------------------------------------------------

function sandpit_remove_self_closing_tags($input) {
	return str_replace(' />', '>', $input);
}

add_filter('get_avatar', 'sandpit_remove_self_closing_tags');
add_filter('comment_id_fields', 'sandpit_remove_self_closing_tags');
add_filter('post_thumbnail_html', 'sandpit_remove_self_closing_tags');


// --------------------------------------------------------------------------
// Prompt to change tagline
// --------------------------------------------------------------------------

function sandpit_notice_tagline() {
	global $current_user;
	$user_id = $current_user->ID;

	if (!get_user_meta($user_id, 'ignore_tagline_notice')) {
		 echo '<div class="error">';
		 echo '<p>', sprintf(__('Please update your <a href="%s">site tagline</a> <a href="%s" style="float: right;">Hide Notice</a>', 'sandpit'), admin_url('options-general.php'), '?tagline_notice_ignore=0'), '</p>';
		 echo '</div>';
	}
}

if ((get_option('blogdescription') === 'Just another WordPress site') && isset($_GET['page']) != 'theme_activation_options') {
	add_action('admin_notices', 'sandpit_notice_tagline');
}

function sandpit_notice_tagline_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	if (isset($_GET['tagline_notice_ignore']) && '0' == $_GET['tagline_notice_ignore']) {
	add_user_meta($user_id, 'ignore_tagline_notice', 'true', true);
	}
}

add_action('admin_init', 'sandpit_notice_tagline_ignore');


// --------------------------------------------------------------------------
// Set post revisions to 5
// --------------------------------------------------------------------------

if (!defined('WP_POST_REVISIONS')) { define('WP_POST_REVISIONS', 5); }


// --------------------------------------------------------------------------
// Allow HTML in descriptions
// --------------------------------------------------------------------------

$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
	remove_filter($filter, 'wp_filter_kses');
}


// --------------------------------------------------------------------------
// Add a filter to append the default stylesheet to the tinymce editor.
// --------------------------------------------------------------------------

if ( ! function_exists('tiny_css') ) {
	function tiny_css($wp) {
		$wp .= ',' . get_template_directory_uri().'/style.css';
	return $wp;
	}
}
add_filter( 'mce_css', 'tiny_css' );


// --------------------------------------------------------------------------
// Remove user meta options
// --------------------------------------------------------------------------

function hide_profile_fields( $contactmethods ) {
unset($contactmethods['aim']);
unset($contactmethods['jabber']);
unset($contactmethods['yim']);
return $contactmethods;
}
add_filter('user_contactmethods','hide_profile_fields',10,1);


// --------------------------------------------------------------------------
// Change default mail address to admin@siteurl.com.au
// --------------------------------------------------------------------------

//add_filter('wp_mail_from', 'new_mail_from');
//add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {

	return 'admin@' . str_replace( 'http://', '', get_bloginfo('url'));
}
function new_mail_from_name($old) {
	return 'Admin';
}


// --------------------------------------------------------------------------
// Set lang="en" as default (rather than en-US)
// --------------------------------------------------------------------------

function sandpit_language_attributes() {
	$attributes = array();
	$output = '';
	if (function_exists('is_rtl')) {
	if (is_rtl() == 'rtl') {
		 $attributes[] = 'dir="rtl"';
	}
	}

	$lang = get_bloginfo('language');
	if ($lang && $lang !== 'en-US') {
	$attributes[] = "lang=\"$lang\"";
	} else {
	$attributes[] = 'lang="en"';
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('sandpit_language_attributes', $output);
	return $output;
}

add_filter('language_attributes', 'sandpit_language_attributes');


// --------------------------------------------------------------------------
// Redirect /?s to /search/
// --------------------------------------------------------------------------

function sandpit_nice_search_redirect() {
	if (is_search() && strpos($_SERVER['REQUEST_URI'], '/wp-admin/') === false && strpos($_SERVER['REQUEST_URI'], '/search/') === false) {
	wp_redirect(home_url('/search/' . str_replace(array(' ', '%20'), array('+', '+'), urlencode(get_query_var('s')))), 301);
		 exit();
	}
}

add_action('template_redirect', 'sandpit_nice_search_redirect');

function sandpit_search_query($escaped = true) {
	$query = apply_filters('sandpit_search_query', get_query_var('s'));
	if ($escaped) {
		 $query = esc_attr($query);
	}
	return urldecode($query);
}

add_filter('get_search_query', 'sandpit_search_query');


// --------------------------------------------------------------------------
// Fix for empty search query
// --------------------------------------------------------------------------

function sandpit_request_filter($query_vars) {
	if (isset($_GET['s']) && empty($_GET['s'])) {
	$query_vars['s'] = " ";
	}
	return $query_vars;
}

add_filter('request', 'sandpit_request_filter');


// --------------------------------------------------------------------------
// Redirect search results if a single result is returned
// --------------------------------------------------------------------------

add_action('template_redirect', 'single_result');
function single_result() {
	if (is_search()) {
		global $wp_query;
		if ($wp_query->post_count == 1) {
			wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
		}
	}
}


// --------------------------------------------------------------------------
// Enable more buttons in tinyMCE
// --------------------------------------------------------------------------

function enable_more_buttons_1($buttons) {
	$buttons[] = 'hr';
	$buttons[] = 'sup';
	$buttons[] = 'sub';
	$buttons[] = 'anchor';
	$buttons[] = 'separator';
	$buttons[] = 'cleanup';
	$buttons[] = 'code';

	return $buttons;
}

add_filter("mce_buttons", "enable_more_buttons_1");

function enable_more_buttons_2($buttons) {



	return $buttons;
}

add_filter("mce_buttons_2", "enable_more_buttons_2");

function enable_more_buttons_3($buttons) {
	$buttons[] = 'styleselect';
	$buttons[] = 'fontsizeselect';

	return $buttons;
}

add_filter("mce_buttons_3", "enable_more_buttons_3");

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings ) {

	$style_formats = array(
		array(
			'title'	=>	'Intro',
			'block' => 'p',
			'classes' => 'intro',
			'wrapper' => false
		),
		array(
			'title'	=>	'Drop cap',
			'block' => 'p',
			'classes' => 'drop-cap',
			'wrapper' => false
		),
		array(
			'title'	=>	'Small Padding',
			'block' => 'div',
			'classes' => 'small-padding',
			'wrapper' => true
		),
		array(
			'title'	=>	'Big Padding',
			'block' => 'div',
			'classes' => 'big-padding',
			'wrapper' => true
		),
		array(
			'title' => 'Button',
			'block' => 'a',
			'classes' => 'button'
		),
		array(
			'title' => 'Callout Box',
			'block' => 'div',
			'classes' => 'callout',
			'wrapper' => true
		),
		array(
			'title' => 'Bold Red Text',
			'inline' => 'span',
			'styles' => array(
				'color' => '#f00',
				'fontWeight' => 'bold'
			)
		)
	);

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;

}

// --------------------------------------------------------------------------
// Force the kitchen sink to always be on
// --------------------------------------------------------------------------

add_action('auth_redirect', 'tcb_force_kitch_sink_on');
function tcb_force_kitch_sink_on(){
	set_user_setting('hidetb', 1);
}


// --------------------------------------------------------------------------
// Remove private page title mod
// --------------------------------------------------------------------------

function sandpit_privates($text){
	$text='%s';
	return $text;
}
add_filter('private_title_format','sandpit_privates');

// --------------------------------------------------------------------------
// Remove automatic paragraph creation around images
// --------------------------------------------------------------------------

function img_unautop($pee) {
	$pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
	return $pee;
}
add_filter( 'the_content', 'img_unautop', 30 );


// --------------------------------------------------------------------------
// Customized the output of caption, you can remove the filter to restore back to the WP default output. Courtesy of DevPress. http://devpress.com/blog/captions-in-wordpress/
// --------------------------------------------------------------------------

add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

function cleaner_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	$attr['width'] = null;

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	$attributes = '';

	/* Set up the attributes for the caption <div>. */
	$attributes .= ' class="figure ' . esc_attr( $attr['align'] ) . '"';

	/* Open the caption <div>. */
	$output = '<figure' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<figcaption>' . $attr['caption'] . '</figcaption>';

	/* Close the caption </div>. */
	$output .= '</figure>';

	/* Return the formatted, clean caption. */
	return $output;
}


// --------------------------------------------------------------------------
// Increase JPEG Quality
// --------------------------------------------------------------------------

add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );


// --------------------------------------------------------------------------
// Clean the output of attributes of images in editor. Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
// --------------------------------------------------------------------------

function image_tag_class($class, $id, $align, $size) {
	$align = 'align' . esc_attr($align);
	return $align;
}
add_filter('get_image_tag_class', 'image_tag_class', 0, 4);
function image_tag($html, $id, $alt, $title) {
	return preg_replace(array(
			'/\s+width="\d+"/i',
			'/\s+height="\d+"/i',
			'/alt=""/i'
		),
		array(
			'',
			'',
			'',
			'alt="' . $title . '"'
		),
		$html);
}
add_filter('get_image_tag', 'image_tag', 0, 4);


// --------------------------------------------------------------------------
// Change Post to News Article (Revised)
// --------------------------------------------------------------------------

add_action( 'init', 'change_post_object_label', 0 );
add_action( 'admin_menu', 'change_post_menu_label', 0 );
add_filter( 'post_updated_messages', 'post_updated_messages' );

function change_post_menu_label() {
	global $menu;
	global $submenu;

	if( isset( $menu[5], $submenu['edit.php'] ) ) {
		$menu[5][0] = 'News';
		$submenu['edit.php'][5][0] = 'News';
		$submenu['edit.php'][10][0] = 'Add News';
		$submenu['edit.php'][16][0] = 'News tags';
	}
}
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add new';
	$labels->add_new_item = 'Add news article';
	$labels->edit_item = 'Edit news article';
	$labels->new_item = 'News';
	$labels->view_item = 'View news article';
	$labels->search_items = 'Search news articles';
	$labels->not_found = 'No news articles found';
	$labels->not_found_in_trash = 'No news articles found in Trash';
	$labels->all_items = 'All news articles';
	$labels->menu_name = 'News articles';
	$labels->name_admin_bar = 'News';
}

function post_updated_messages( $messages ) {
	global $post, $post_ID;

	$messages['post'] = array(
		0 => '',
		1 => sprintf( 'News article updated. <a href="%s">View article</a>', esc_url( get_permalink( $post_ID ) ) ),
		2 => 'Custom field updated.',
		3 => 'Custom field deleted.',
		4 => 'News Article updated.',
		5 => isset( $_GET['revision'] ) ? sprintf( 'News article restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( 'News article published. <a href="%s">View article</a>', esc_url( get_permalink( $post_ID ) ) ),
		7 => 'News article saved.',
		8 => sprintf( 'News article submitted. <a target="_blank" href="%s">Preview article</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		9 => sprintf( 'News article scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview article</a>',
		date_i18n( 'M j, Y @ G:i', strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
		10 => sprintf( 'News article draft updated. <a target="_blank" href="%s">Preview article</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
	);

	return $messages;
}


// --------------------------------------------------------------------------
// Gravity Forms address type
// --------------------------------------------------------------------------

add_filter("gform_address_types", "australian_address", 10, 2);

function australian_address($address_types, $form_id){
	$address_types["australian"] = array(
									"label" => "Australia",
									"country" => "Australia",
									"zip_label" => "Post Code",
									"state_label" => "State",
									"states" => array("", "Western Australia", "Northern Territory", "South Australia", "Victoria", "New South Wales", "Tasmania", "Australian Capital Territory")
	);
	return $address_types;
}

add_filter("gform_address_city", "change_address_city", 10, 2);
function change_address_city($label, $form_id){
	return "Suburb";
}


// --------------------------------------------------------------------------
// Stop Woocommerce being a dick // Currently not working :(
// --------------------------------------------------------------------------

remove_action('wp_print_scripts', 'check_jquery', 25);


// --------------------------------------------------------------------------
// Custom walker for cleaner nav menu
// --------------------------------------------------------------------------

// Removed walker pending better implementation

add_filter('nav_menu_item_id', '__return_null');

/**
 * Remove the id="" on nav menu items
 * Return 'menu-slug' for nav menu classes
 */

function sandpit_nav_menu_css_class($classes, $item) {
	$slug = sanitize_title($item->title);
	$classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes);
	$classes = preg_replace('/((menu|page)[-_\w+]+)+/', '', $classes);

	$classes[] = 'menu-' . $slug;

	$classes = array_unique($classes);

	return array_filter($classes, 'is_element_empty');
}

add_filter('nav_menu_css_class', 'sandpit_nav_menu_css_class', 10, 2);


// --------------------------------------------------------------------------
// Main nav instant click attribute
// --------------------------------------------------------------------------

function sandpit_menu_atts( $atts, $item, $args )
{

	$atts['data-instant'] = 'true';

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'sandpit_menu_atts', 10, 3 );


// --------------------------------------------------------------------------
// Facebook Open Graph
// --------------------------------------------------------------------------

function opengraph_for_posts() {
	if ( is_singular() ) {
		global $post;
		setup_postdata( $post );
		$og_type = '<meta property="og:type" content="article" />' . "\n";
		$og_title = '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
		$og_url = '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
		$og_description = '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
		if ( has_post_thumbnail() ) {
			$imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			$og_image = '<meta property="og:image" content="' . $imgsrc[0] . '" />' . "\n";
		}
		echo "\n" . '<!-- Facebook Open Graph -->' . "\n" . $og_type . $og_title . $og_url . $og_description . issetor($og_image);
	}
}
add_action( 'wp_head', 'opengraph_for_posts' );


// --------------------------------------------------------------------------
// Add attributes to enqueue
// --------------------------------------------------------------------------

function add_attr_to_js( $url )
	{
			if ( // comment the following line out add 'defer' to all scripts
			FALSE === strpos( $url, 'js/plugins' ) or
			FALSE === strpos( $url, '.js' )
			)
			{ // not our file
					return $url;
			}
			// Must be a ', not "!
			return "$url' data-no-instant='";
	}
add_filter( 'clean_url', 'add_attr_to_js', 11, 1 );

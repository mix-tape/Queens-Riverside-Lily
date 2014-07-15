<?php

// ==========================================================================
//
//  Theme Utilities
//    Universal functions and variables
//
// ==========================================================================


// ==========================================================================
//  Get block classes
// ==========================================================================

function get_blocks_classes()
{
	$classes[] = get_sub_field('height');
	$classes[] = get_sub_field('class');

	$output = implode(' ', $classes);

	return $output;
}

function get_block_classes()
{
	$classes[] = get_sub_field('size');
	$classes[] = get_sub_field('class');
	$classes[] = get_sub_field('background_color');

	if (get_sub_field('link'))
		$classes[] = 'link-block';

	if (get_sub_field('background_image'))
		$classes[] = 'bg-image';

	$output = implode(' ', $classes);

	return $output;
}


// ==========================================================================
//  Links to .buttons
// ==========================================================================

function replace_links($content)
{
	return preg_replace('/<a.*?>(.*?)<\/a>/i', '<span class="button">\1</span>', $content);
}


// --------------------------------------------------------------------------
//   Set up base theme name
// --------------------------------------------------------------------------

$theme_name = explode('/themes/', get_template_directory());

define('WP_BASE', wp_base_dir());
define('THEME_NAME', next($theme_name));
define('RELATIVE_PLUGIN_PATH', str_replace(site_url() . '/', '', plugins_url()));
define('FULL_RELATIVE_PLUGIN_PATH', WP_BASE . '/' . RELATIVE_PLUGIN_PATH);
define('RELATIVE_CONTENT_PATH', str_replace(site_url() . '/', '', content_url()));
define('THEME_PATH', RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);


// --------------------------------------------------------------------------
//   Mobile Detect
// --------------------------------------------------------------------------

if (!class_exists('Mobile_Detect')) {
	include('classes/class-mobile-detect.php');
}

$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
$mobile_detect = new Mobile_Detect();
$mobile_detect->setDetectionType('extended');
$deviceType = ($mobile_detect->isMobile() ? ($mobile_detect->isTablet() ? 'tablet' : 'phone') : 'computer');

/***************************************************************
* Function is_iphone
* Detect the iPhone
***************************************************************/

function is_iphone() {
	global $mobile_detect;
	return($mobile_detect->isIphone());
}

/***************************************************************
* Function is_ipad
* Detect the iPad
***************************************************************/

function is_ipad() {
	global $mobile_detect;
	return($mobile_detect->isIpad());
}

/***************************************************************
* Function is_ipod
* Detect the iPod, most likely the iPod touch
***************************************************************/

function is_ipod() {
	global $mobile_detect;
	return($mobile_detect->is('iPod'));
}

/***************************************************************
* Function is_android
* Detect an android device.
***************************************************************/

function is_android() {
	global $mobile_detect;
	return($mobile_detect->isAndroidOS());
}

/***************************************************************
* Function is_blackberry
* Detect a blackberry device
***************************************************************/

function is_blackberry() {
	global $mobile_detect;
	return($mobile_detect->isBlackBerry());
}

/***************************************************************
* Function is_opera_mobile
* Detect both Opera Mini and hopefully Opera Mobile as well
***************************************************************/

function is_opera_mobile() {
	global $mobile_detect;
	return($mobile_detect->isOpera());
}

/***************************************************************
* Function is_palm - to be phased out as not using new detect library?
* Detect a webOS device such as Pre and Pixi
***************************************************************/

function is_palm() {
	_deprecated_function('is_palm', '1.2', 'is_webos');
	global $mobile_detect;
	return($mobile_detect->is('webOS'));
}

/***************************************************************
* Function is_webos
* Detect a webOS device such as Pre and Pixi
***************************************************************/

function is_webos() {
	global $mobile_detect;
	return($mobile_detect->is('webOS'));
}

/***************************************************************
* Function is_symbian
* Detect a symbian device, most likely a nokia smartphone
***************************************************************/

function is_symbian() {
	global $mobile_detect;
	return($mobile_detect->is('Symbian'));
}

/***************************************************************
* Function is_windows_mobile
* Detect a windows smartphone
***************************************************************/

function is_windows_mobile() {
	global $mobile_detect;
	return($mobile_detect->is('WindowsMobileOS') || $mobile_detect->is('WindowsPhoneOS'));
}

/***************************************************************
* Function is_lg
* Detect an LG phone
***************************************************************/

function is_lg() {
	_deprecated_function('is_lg', '1.2');
	global $useragent;
	return(preg_match('/LG/i', $useragent));
}

/***************************************************************
* Function is_motorola
* Detect a Motorola phone
***************************************************************/

function is_motorola() {
	global $mobile_detect;
	return($mobile_detect->is('Motorola'));
}

/***************************************************************
* Function is_nokia
* Detect a Nokia phone
***************************************************************/

function is_nokia() {
	_deprecated_function('is_nokia', '1.2');
	global $useragent;
	return(preg_match('/Series60/i', $useragent) || preg_match('/Symbian/i', $useragent) || preg_match('/Nokia/i', $useragent));
}

/***************************************************************
* Function is_samsung
* Detect a Samsung phone
***************************************************************/

function is_samsung() {
	global $mobile_detect;
	return($mobile_detect->is('Samsung'));
}

/***************************************************************
* Function is_samsung_galaxy_tab
* Detect the Galaxy tab
***************************************************************/

function is_samsung_galaxy_tab() {
	_deprecated_function('is_samsung_galaxy_tab', '1.2', 'is_samsung_tablet');
	return is_samsung_tablet();
}

/***************************************************************
* Function is_samsung_tablet
* Detect the Galaxy tab
***************************************************************/

function is_samsung_tablet() {
	global $mobile_detect;
	return($mobile_detect->is('SamsungTablet'));
}

/***************************************************************
* Function is_kindle
* Detect an Amazon kindle
***************************************************************/

function is_kindle() {
	global $mobile_detect;
	return($mobile_detect->is('Kindle'));
}

/***************************************************************
* Function is_sony_ericsson
* Detect a Sony Ericsson
***************************************************************/

function is_sony_ericsson() {
	global $mobile_detect;
	return($mobile_detect->is('Sony'));
}

/***************************************************************
* Function is_nintendo
* Detect a Nintendo DS or DSi
***************************************************************/

function is_nintendo() {
	global $useragent;
	return(preg_match('/Nintendo DSi/i', $useragent) || preg_match('/Nintendo DS/i', $useragent));
}


/***************************************************************
* Function is_smartphone
* Grade of phone A = Smartphone - currently testing this
***************************************************************/

function is_smartphone() {
	global $mobile_detect;
	$grade = $mobile_detect->mobileGrade();
	if ($grade == 'A' || $grade == 'B') {
		return true;
	} else {
		return false;
	}
}

/***************************************************************
* Function is_handheld
* Wrapper function for detecting ANY handheld device
***************************************************************/

function is_handheld() {
	return(is_mobile() || is_iphone() || is_ipad() || is_ipod() || is_android() || is_blackberry() || is_opera_mobile() || is_webos() || is_symbian() || is_windows_mobile() || is_motorola() || is_samsung() || is_samsung_tablet() || is_sony_ericsson() || is_nintendo());
}

/***************************************************************
* Function is_mobile
* For detecting ANY mobile phone device
***************************************************************/

function is_mobile() {
	global $mobile_detect;
	if (is_tablet()) return false;
	return ($mobile_detect->isMobile());
}

/***************************************************************
* Function is_ios
* For detecting ANY iOS/Apple device
***************************************************************/

function is_ios() {
	global $mobile_detect;
	return($mobile_detect->isiOS());
}

/***************************************************************
* Function is_tablet
* For detecting tablet devices (needs work)
***************************************************************/

function is_tablet() {
	global $mobile_detect;
	return($mobile_detect->isTablet());
}


// --------------------------------------------------------------------------
//   Shadow Colour
// --------------------------------------------------------------------------

function get_shadow_colour($hex) {

	$hex = str_replace('#', '', $hex);

	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));


	if ($hex == "ffffff") {
		return "#000";
		exit;
	}
	if ($hex == "000000") {
		return "#fff";
		exit;
	}

	if($r + $g + $b > 382){
		return "#000";
	}else{
		return "#fff";
	}
}


// --------------------------------------------------------------------------
//   Check if variable is set and return it, else return false
// --------------------------------------------------------------------------

function issetor(&$var, $default = false) {
	return isset($var) ? $var : $default;
}


// --------------------------------------------------------------------------
//   Check if an element has content, else return false
// --------------------------------------------------------------------------

function is_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}


// --------------------------------------------------------------------------
//   List hooked functions
// --------------------------------------------------------------------------

function list_hooked_functions( $tag=false ) {
	global $wp_filter;
	if ( $tag ) {
		$hook[$tag]=$wp_filter[$tag];
		if ( !is_array( $hook[$tag] ) ) {
			trigger_error( "Nothing found for '$tag' hook", E_USER_WARNING );
			return;
		}
	}
	else {
		$hook=$wp_filter;
		ksort( $hook );
	}
	echo '<pre>';
	foreach ( $hook as $tag => $priority ) {
		echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
		ksort( $priority );
		foreach ( $priority as $priority => $function ) {
			echo $priority;
			foreach ( $function as $name => $properties ) echo "\t$name<br />";
		}
	}
	echo '</pre>';
	return;
}


// --------------------------------------------------------------------------
//   Get WordPress subdirectory if applicable
// --------------------------------------------------------------------------

function wp_base_dir() {
	preg_match( '!(https?://[^/|"]+)([^"]+)?!', site_url(), $matches );
	if ( count( $matches ) === 3 ) {
		return end( $matches );
	} else {
		return '';
	}
}


// --------------------------------------------------------------------------
//   Functions for leading slashes
// --------------------------------------------------------------------------

function leadingslashit( $string ) {
	return '/' . unleadingslashit( $string );
}

function unleadingslashit( $string ) {
	return ltrim( $string, '/' );
}

function add_filters( $tags, $function ) {
	foreach ( $tags as $tag ) {
		add_filter( $tag, $function );
	}
}


// --------------------------------------------------------------------------
//   Check if we need to show the pagination
// --------------------------------------------------------------------------

function show_posts_nav() {
	global $wp_query;
	return $wp_query->max_num_pages > 1;
}

?>

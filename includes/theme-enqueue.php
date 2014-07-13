<?php

// ==========================================================================
//
//  Theme Enqueue
//    Scripts and Styles enqueue
//
// ==========================================================================


// --------------------------------------------------------------------------
// Enqueue Scripts
// --------------------------------------------------------------------------

function sandpit_enqueue_scripts() {


	// Deregister local scripts

	wp_deregister_script( 'jquery' );
	wp_deregister_script( 'comment-reply' );
	
	
	// Register Scripts
	
	wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', '', '1.11.0');
	wp_register_script( 'comment-reply', get_bloginfo('url') . '/wp-includes/js/comment-reply.js?ver=20090102');
	
	
	// Queue Scripts
	
	wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', '', '1.11.0', false );	
	wp_enqueue_script( 'sandpit-plugin-set', get_bloginfo('template_url') . '/js/plugins.js', 'jquery', '', false );
	wp_enqueue_script( 'sandpit-scripts', get_bloginfo('template_url') . '/js/script.js', 'jquery', '', true );
	
	//if ( get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply',	get_bloginfo('url') . '/wp-includes/js/comment-reply.js?ver=20090102', 'jquery', '', true );

	
}	 

if ( !is_admin()) add_action('wp_enqueue_scripts', 'sandpit_enqueue_scripts', 0 );
<?php

// ==========================================================================
//
//  Theme Content
//    Content type definitions, custom fields and configuration
//
// ==========================================================================


// --------------------------------------------------------------------------
//  Get Latest Posts Shortcode
// --------------------------------------------------------------------------

function get_latest_post( $atts ) {

	$args = array( 'numberposts' => '1' );

	$recent_posts = wp_get_recent_posts( $args );

	foreach( $recent_posts as $post ){

		$output = '<article class="latest-news">

								<a href="' . get_permalink($post["ID"]) . '" title="' . $post["post_title"] .'" >

									<h3>' . $post["post_title"].'</h3>

								</a>' .

								wp_trim_words($post['post_content'], 18) .

								'<footer>

									<p><time datetime="' . get_the_time('Y-m-d', $post["ID"]) . '">' . get_the_time('j\<\s\u\b\>S\<\/\s\u\b\> F Y', $post["ID"]) . '</time></p>

									<p><a href="' . get_permalink($post["ID"]) . '" class="ghost-button">Read more</a></p>

								</footer>

							</article>';

	}

	return $output;
}

add_shortcode( 'latest-post', 'get_latest_post' );



// --------------------------------------------------------------------------
//  Instagram Hashtag
// --------------------------------------------------------------------------

function get_hashtag( $atts ) {

	return '<a href="https://twitter.com/hashtag/livelily?f=realtime&src=hash" target="_blank"><span class="large-hashtag"><span class="fat-hash">#</span>livelily</span></a>';

}

add_shortcode( 'hashtag', 'get_hashtag' );

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

									<h2>' . $post["post_title"].'</h2>

								</a>' .

								/* wp_trim_words($post['post_content'], 18) . */

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


// --------------------------------------------------------------------------
//
// --------------------------------------------------------------------------


function get_gallery_javascript()
{

ob_start()

?>

<a href="#" class="button" id="launch-gallery">Gallery</a>

<script type="text/javascript">

	$( '#launch-gallery' ).click( function( e ) {
		e.preventDefault();

			<?php if (get_field('gallery')) { ?>

				$.swipebox( [

				<?php $images = get_field('gallery'); foreach($images as $image) { ?>

					<?php $alt = $image['alt']; ?>

					{ href:'<?php echo $image["url"]; ?>', title:'<?php echo $alt; ?>' },

				<?php } ?>

				] );

			<?php } ?>

	} );

</script>

<?php

$output = ob_get_clean();

return $output;

}

add_shortcode( 'gallery', 'get_gallery_javascript' );

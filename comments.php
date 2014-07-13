<?php 

// --------------------------------------------------------------------------
// Comment formatting
// --------------------------------------------------------------------------

function theme_comments($comment, $args, $depth) {

	$GLOBALS['comment'] = $comment; ?>
	
		<article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		
		
			<div class="comment-image">
			
				<?php echo get_avatar($comment,$size='64'); ?>
				
			</div>
			
			
			<div class="comment-content">
				
				<h1><?php printf(__('%s'), get_comment_author()) ?> <?php edit_comment_link(__('(Edit)'),'	','') ?></h1>
				
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.') ?></em>
					<br />
				<?php endif; ?>
				
				<?php comment_text() ?>
			
				<footer class="comment-detail">
					
					<time><?php printf(__('%1$s at %2$s'), get_comment_date(),	 get_comment_time()) ?> <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?> </time>
				
				</footer>
			
				
				
			</div>
			
			
		</article>
	 
	<!-- </li> is added by wordpress automatically -->

<?php } ?>




<div id="comments">


	<?php if ( post_password_required() ) { ?>
	
			<p class="nopassword">
				<?php _e( 'This post is password protected. Enter the password to view any comments.' ); ?>
			</p>
			
	<?php return; } ?>


	<?php if ( have_comments() ) { ?>
	
		<h3 id="comments-title"><?php
			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number() ),
			number_format_i18n( get_comments_number() ), get_the_title() );
		?></h3>


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
		
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>' ) ); ?></div>
			</div>
			
		<?php } ?>


		<?php wp_list_comments( array( 'callback' => 'theme_comments' ) ); ?>


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>' ) ); ?></div>
			</div>
		<?php endif; ?>


		<?php } else {
			if ( ! comments_open() && have_comments() ) :
		?>
		<p class="nocomments"><?php _e( 'Comments are closed.' ); ?></p>
		<?php endif; ?>

	<?php } ?>

<?php comment_form(array('comment_notes_after' => '')); ?>

</div>

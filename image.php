<?php get_header(); ?>

	<div class="wrapper" id="main-wrapper">

		<div class="section" id="main">

			<div class="section-content" id="main-content">

				<section id="content" role="main">

					<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>
				
					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					
						<header>
						
							<h2><?php the_title(); ?></h2>
						
						</header>
						
						<?php 
							
						if ( has_excerpt() ) {
					
							$src = wp_get_attachment_image_src( get_the_ID(), 'full' );
					
							echo do_shortcode( '[caption class="aligncenter" width="' . esc_attr( $src[1] ) . '" caption="' . get_the_excerpt() . '"]' . wp_get_attachment_image( get_the_ID(), 'full', false ) . '[/caption]' );
					
						} else {
					
							echo wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) );
					
						} 
							
						?>
						
						<?php get_template_part('content', 'blocks'); ?>
						
						<footer>
							
							
						
						</footer>
					
					</article>
					
					<?php // comments_template(); ?>
					
				<?php } } ?>
				
				</section>
			
				<?php get_sidebar(); ?>

			</div><!-- End #main-content -->
				
		</div><!-- End #main -->
	
	</div><!-- End #main-wrapper -->
	
<?php get_footer(); ?>
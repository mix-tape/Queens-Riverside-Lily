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

						<?php get_template_part('content', 'blocks'); ?>

					</article>
					
					<?php } } ?>

				</section>

				<?php get_sidebar(); ?>

			</div><!-- End #main-content -->
				
		</div><!-- End #main -->
	
	</div><!-- End #main-wrapper -->
	
<?php get_footer(); ?>
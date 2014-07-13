<?php get_header(); ?>

	<div class="wrapper" id="main-wrapper">

		<div class="section" id="main">

			<div class="section-content" id="main-content">

				<section id="content" role="main">
									
					<?php woocommerce_content(); ?>
				
				</section>
				
				<?php get_sidebar(); ?>

			</div><!-- End #main-content -->
				
		</div><!-- End #main -->
	
	</div><!-- End #main-wrapper -->
	
<?php get_footer(); ?>
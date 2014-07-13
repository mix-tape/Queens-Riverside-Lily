
	<div class="wrapper" id="banner-wrapper">

		<div class="section" id="banner">

			<div class="section-content" id="banner-content">

				<?php if ( get_field('slideshow') ) { ?>


					<div id="hero">


						<?php while(has_sub_field('slideshow')) { ?>


							<div>

								<img src="<?php $imagedata = get_sub_field('image'); echo $imagedata['sizes']['hero']; ?>" alt="" />

							</div>


						<?php }	?>


					</div>

				<?php } ?>

				<div id="logo">

					<a href="<?php bloginfo('url'); ?>/">

						<img src="<?php bloginfo('template_url'); ?>/images/lily-logo.svg" alt="<?php wp_title(); ?> logo" title="<?php wp_title(); ?>"/>

						<h1><?php echo bloginfo('title'); ?></h1>

					</a>

				</div>

			</div>

		</div>

	</div>

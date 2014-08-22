
<?php if ( get_field('slideshow') ) { ?>

	<div class="wrapper" id="banner-wrapper">


		<div id="hero">


			<?php while(has_sub_field('slideshow')) { ?>


				<?php $imagedata = get_sub_field('image'); ?>

				<div class="banner-slide" style="background-image: url(<?php echo $imagedata['sizes']['hero']; ?>);">

					<img src="<?php echo $imagedata['sizes']['hero']; ?>" alt="" class="print-only" />

				</div>


			<?php }	?>


		</div>


		<div class="section" id="banner">

			<div class="section-content" id="banner-content">

				<p><span id="clock" data-datetime="<?php echo date('r'); ?>"></span></p>

				<h2>Live life. Live Lily.</h2>

				<h4>Brand new east perth apartments</h4>

				<div id="logo">

					<a href="<?php bloginfo('url'); ?>/">

						<img src="<?php bloginfo('template_url'); ?>/images/lily-logo.svg" alt="<?php wp_title(); ?> logo" title="<?php wp_title(); ?>"/>

						<h1><?php echo bloginfo('title'); ?></h1>

					</a>

				</div>

				<a class="ghost-button" href="<?php echo get_permalink( 29 ); ?>">View more</a>

			</div>

		</div>


	</div>

<?php } ?>

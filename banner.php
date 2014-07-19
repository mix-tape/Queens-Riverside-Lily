
<?php if ( get_field('slideshow') ) { ?>

	<div class="wrapper" id="banner-wrapper">


		<div id="hero">


			<?php while(has_sub_field('slideshow')) { ?>


				<?php $imagedata = get_sub_field('image'); ?>

				<div class="banner-slide" style="background-image: url(<?php echo $imagedata['sizes']['hero']; ?>);">

					<img src="<?php echo $imagedata['sizes']['hero']; ?>" alt="" class="print-only" />

					<?php if (get_sub_field('caption')) { ?>

					<div class="section">

						<div class="section-content">

							<div class="caption">

								<?php the_sub_field('caption'); ?>

							</div>

						</div>

					</div>

					<?php } ?>

				</div>


			<?php }	?>


		</div>


	</div>

<?php } ?>

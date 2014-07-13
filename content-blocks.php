<?php

// ==========================================================================
//
//  Content Blocks
//    Output from custom content fields
//
// ==========================================================================

?>

						<div class="content-blocks">


							<?php

							// --------------------------------------------------------------------------
							//   Standard content / excerpt
							// --------------------------------------------------------------------------

							if (get_the_content()): ?>

							<div class="standard">

								<?php if (is_singular() && !is_front_page()) { the_content(''); } else { the_excerpt();} ?>

							</div>

							<?php endif;


							while (have_rows('content')): the_row(); ?>



								<?php

								// --------------------------------------------------------------------------
								//   Text Block
								// --------------------------------------------------------------------------

								if (get_row_layout() == 'heading'): ?>

									<div class="wrapper heading-wrapper">

										<section class="section">

											<div class="section-content">

												<h<?php the_sub_field('heading_level'); ?> class="heading">

													<?php the_sub_field('content'); ?>

												</h<?php the_sub_field('heading_level'); ?>>

											</div>

										</section>

									</div>



								<?php /*// Text Block ///////*/ elseif (get_row_layout() == 'text_block'): ?>

									<div class="wrapper text-wrapper">

										<section class="section">

											<div class="section-content">

												<div class="standard <?php if (get_sub_field('split_columns')) echo 'split-columns'; ?>">

													<?php the_sub_field('content'); ?>

												</div>

											</div>

										</section>

									</div>



								<?php

								// --------------------------------------------------------------------------
								//   Odd blocks
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'blocks'): ?>

										<div class="fullscreen-wrapper blocks-wrapper">

											<section class="blocks <?php the_sub_field('height'); ?> <?php the_sub_field('class'); ?>">

												<?php while ( have_rows('blocks') ) : the_row(); ?>

													<?php $imagedata = get_sub_field('background_image'); ?>

													<div class="block <?php the_sub_field('size'); ?> <?php the_sub_field('class'); ?> <?php the_sub_field('background_color'); ?>" style="background-image: url(<?php echo $imagedata['sizes']['hero']; ?>);">

														<?php the_sub_field('content'); ?>

													</div>

												<?php endwhile; ?>

											</section>

										</div>



								<?php

								// --------------------------------------------------------------------------
								//   Slideshow
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'slideshow'):?>

									<div class="fullscreen-wrapper slideshow-wrapper">

										<section class="slideshow-section">

										<?php if(get_sub_field('slideshow')) { ?>

											<div class="slideshow">

												<?php $images = get_sub_field('slideshow'); foreach($images as $image) { ?>

												<div>

														<img src="<?php echo $image['sizes']['hero']; ?>" alt="" />

										 		</div>

												<?php } ?>

											</div>

										<?php } ?>

										</section>

									</div>



								<?php endif; ?>

							<?php endwhile; ?>

						</div>

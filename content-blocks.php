<?php

// ==========================================================================
//
//  Content Blocks
//    Output from custom content fields
//
// ==========================================================================


						// --------------------------------------------------------------------------
						//   Standard content / excerpt Block
						// --------------------------------------------------------------------------

						if (get_the_content()): ?>

						<section class="blocks text-block">

							<div class="section">

								<div class="standard">

									<?php if (is_singular() && !is_front_page()) { the_content(''); } else { the_excerpt();} ?>

								</div>

							</div>

						</section>

						<?php endif;


						while (have_rows('content')): the_row(); ?>


							<?php

							// --------------------------------------------------------------------------
							//   Text Block
							// --------------------------------------------------------------------------

							if (get_row_layout() == 'heading'): ?>


								<section class="blocks heading-block <?php echo get_blocks_classes(); ?>">

									<div class="section">

										<h<?php the_sub_field('heading_level'); ?> class="heading">

											<?php the_sub_field('content'); ?>

										</h<?php the_sub_field('heading_level'); ?>>

									</div>

								</section>




							<?php /*// Text Block ///////*/ elseif (get_row_layout() == 'text_block'): ?>


								<section class="blocks text-block <?php echo get_blocks_classes(); ?>">

									<div class="section">

										<?php if (get_sub_field('logo')) { ?>

											<div class="logo">

												<?php $image = get_sub_field('logo');
															$url = $image['url'];
															$alt = $image['alt'];
												?>

												<img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" />

											</div>

										<?php } ?>

										<div class="standard">

											<?php the_sub_field('content'); ?>

										</div>

									</div>

								</section>



							<?php /*// Text Block ///////*/ elseif (get_row_layout() == 'text_columns'): ?>


								<section class="blocks text-columns">

									<div class="section">

										<div class="standard <?php echo get_blocks_classes(); ?>">

											<div class="column-1">

												<?php the_sub_field('column_1'); ?>

											</div>

											<div class="column-2">

												<?php the_sub_field('column_2'); ?>

											</div>

										</div>

									</div>

								</section>



							<?php

							// --------------------------------------------------------------------------
							//   Blocks
							// --------------------------------------------------------------------------

							elseif (get_row_layout() == 'blocks'): ?>


									<section class="blocks <?php echo get_blocks_classes(); ?>">

										<?php while ( have_rows('blocks') ) : the_row(); ?>

											<?php $imagedata = get_sub_field('background_image'); ?>

											<div class="block <?php echo get_block_classes(); ?>" style="background-image: url(<?php echo $imagedata['url']; ?>);">

												<?php if (get_sub_field('link')) { ?><a href="<?php the_sub_field('link'); ?>"><?php } ?>

													<?php if (get_sub_field('content')) { ?>

														<div class="block-content">

															<?php if (get_sub_field('link')) { echo replace_links(get_sub_field('content')); } else { echo get_sub_field('content'); } ?>

														</div>

													<?php } ?>

												<?php if (get_sub_field('link')) { ?></a><?php } ?>

											</div>

										<?php endwhile; ?>

									</section>




							<?php

							// --------------------------------------------------------------------------
							//   Slideshow
							// --------------------------------------------------------------------------

							elseif (get_row_layout() == 'slideshow'):?>


								<section class="slideshow-section">

								<?php if(get_sub_field('slideshow')) { ?>

									<div class="slideshow <?php echo get_blocks_classes(); ?>">

										<?php $images = get_sub_field('slideshow'); foreach($images as $image) { ?>

										<div class="slide block bg-image" style="background-image: url(<?php echo $image['sizes']['hero']; ?>);">

												<img src="<?php echo $image['sizes']['banner']; ?>" alt="<?php echo $alt; ?>" />

								 		</div>

										<?php } ?>

									</div>

								<?php } ?>

								</section>




							<?php endif; ?>

						<?php endwhile; ?>

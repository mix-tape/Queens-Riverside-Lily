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

							$numtabs = 0;
							$numwidths = 0;

							while (the_flexible_field('content')): ?>



								<?php

								// --------------------------------------------------------------------------
								//   Text Block
								// --------------------------------------------------------------------------

								if (get_row_layout() == 'heading'): ?>

									<h<?php the_sub_field('heading_level'); ?> class="heading <?php if (get_sub_field('padding')) { echo 'vertical-padding'; } ?>">

										<?php the_sub_field('content'); ?>

									</h<?php the_sub_field('heading_level'); ?>>

								<?php /*// Text Block ///////*/ elseif (get_row_layout() == 'text_block'): ?>

									<div class="standard <?php if (get_sub_field('padding')) { echo 'vertical-padding'; } ?>">

										<?php the_sub_field('content'); ?>

									</div>



								<?php

								// --------------------------------------------------------------------------
								//   Full Width Text Block
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'full_width'): $numwidths++; ?>

									<div class="full-width-wrapper" id="<?php echo 'full-width-' . $numwidths; ?>">

										<style scoped>
											<?php echo '#full-width-' . $numwidths; ?> h1,
											<?php echo '#full-width-' . $numwidths; ?> h2,
											<?php echo '#full-width-' . $numwidths; ?> h3,
											<?php echo '#full-width-' . $numwidths; ?> h4,
											<?php echo '#full-width-' . $numwidths; ?> h5,
											<?php echo '#full-width-' . $numwidths; ?> h6,
											<?php echo '#full-width-' . $numwidths; ?> p {
												color: <?php the_sub_field('text_colour'); ?>;
											}

										</style>

										<div class="full-width <?php if (get_sub_field('padding')) { echo 'vertical-padding'; } ?>" style="background-color: <?php the_sub_field('background_colour'); ?>; <?php $image = get_sub_field('background_image'); if ($image) { echo "background-image: url(" . $image['url'] . ")"; } ?>">

											<div class="center">

												<div class="standard"><?php the_sub_field('content'); ?></div>

											</div>

										</div>

									</div>



								<?php

								// --------------------------------------------------------------------------
								//   Columns
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'columns'): ?>

									<?php if (get_sub_field('columns')): ?>

									<?php $columns = get_sub_field('columns'); ?>

									<?php $count = count($columns); ?>

									<div class="columns columns-<?php echo $count; ?> <?php if (get_sub_field('padding')) { echo 'vertical-padding'; } ?>">

										<?php foreach ($columns as $column): ?>

											<div class="single-column" >

												<?php echo $column['content']; ?>

											</div>

										<?php endforeach; ?>

									</div>

								<?php endif; ?>



								<?php

								// --------------------------------------------------------------------------
								//   Odd Columns
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'odd_columns'): ?>

									<?php if (get_sub_field('columns')): ?>

									<?php $columns = get_sub_field('columns'); ?>

									<?php $count = count($columns); ?>

									<div class="columns columns-<?php echo $count; ?> <?php if (get_sub_field('padding')) { echo 'vertical-padding'; } ?>">

										<?php foreach ($columns as $column): ?>

											<div class="odd-column <?php echo $column['size']; ?>" >

												<?php echo $column['content']; ?>

											</div>

										<?php endforeach; ?>

									</div>

									<?php endif; ?>



								<?php

								// --------------------------------------------------------------------------
								//   Tabs
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'tabs'):

									if (have_rows('tabs')) { $firstTab = true; ?>

										<section class="accordion-tabs <?php if (get_sub_field('padding')) echo 'vertical-padding'; ?>">

											<?php while ( have_rows('tabs') ) { the_row(); ?>

											<div class="header-and-content">

												<a href="#" class="<?php if ($firstTab) echo "is-active"; $firstTab = false; ?>"><?php the_sub_field('title'); ?></a>

												<div class="content"><?php the_sub_field('content') ?></div>

											</div>

											<?php } ?>

										</section>

									<?php } ?>



								<?php

								// --------------------------------------------------------------------------
								//   Accordion
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'accordion'):?>

									<section class="accordion">

										<div class="header-and-content">

											<a href="#" class="<?php if ($firstTab) echo "is-active"; $firstTab = false; ?>"><?php the_sub_field('title'); ?></a>

											<div class="content"><?php the_sub_field('content') ?></div>

										</div>

									</section>



								<?php

								// --------------------------------------------------------------------------
								//   Slideshow
								// --------------------------------------------------------------------------

								elseif (get_row_layout() == 'slideshow'):?>

									<section class="<?php if (get_sub_field('padding')) echo 'vertical-padding'; ?>">

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



							<?php

							// --------------------------------------------------------------------------
							//   Gallery
							// --------------------------------------------------------------------------

							elseif (get_row_layout() == 'gallery'):?>

								<?php

								$columns = get_sub_field('columns');

								$numbers = array("zero", "one", "two", "three", "four", "five", "six");

								$sizes = array("full", "large", "large", "large", "medium", "medium" )

								?>

								<section class="gallery <?php if (get_sub_field('padding')) { echo 'vertical-padding'; } ?>">

									<div class="row <?php echo $columnclass = $numbers[$columns]; ?>">

										<?php $i = 1; $images = get_sub_field('gallery'); if ($images) { foreach( $images as $image ): ?>

										<figure>

											<a href="<?php echo $image['url']; ?>">

												<img title="<?php echo $image['title']; ?>" src="<?php echo $image['sizes'][$sizes[$columns]]; ?>" alt="<?php echo $image['alt']; ?>" />

											</a>

											<?php if (get_sub_field('captions') && $image['caption']) { ?><figcaption><?php echo $image['caption']; ?></figcaption><?php } ?>

										</figure>

									<?php if ( $i % $columns == 0 ) { ?>

									</div>

									<div class="row <?php echo $columnclass; ?>">

									<?php } $i++; ?>

										<?php endforeach; } ?>

									</div>

								</section>

								<?php endif; ?>

							<?php endwhile; ?>

						</div>


				<?php

					// --------------------------------------------------------------------------
					//  Pivot Backgound Colour
					// --------------------------------------------------------------------------

					// ----- Set our first row to cyan ----- //

					$cyan_row = true;

					// ----- Usage ----- //

					// This will check the variable and output the class,
					// then switch the variable to the opposite value.

					// ($cyan_row) ? 'cyan' : 'dark-blue'; $cyan_row = !$cyan_row;

				?>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<section class="blocks text-block left-logo white-text <?= ($cyan_row) ? 'cyan' : 'darkblue'; $cyan_row = !$cyan_row; ?>">

						<article <?php post_class('section') ?> id="post-<?php the_ID(); ?>">

							<div class="logo">

								<?php $image = get_field('title_background');
											$url = $image['url'];
											$alt = $image['alt'];
											$imageSize = $image['sizes']['single-post-thumbnail'];
								?>

								<img src="<?php echo $imageSize; ?>" alt="<?php echo $alt; ?>" />

							</div>

							<div class="standard">

								<header>

									<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

								</header>

								<?php the_excerpt(); ?>

								<footer>

									<time datetime="<?php the_time('Y-m-d')?>"><?php the_time('F jS, Y') ?></time>

									<a href="<?php the_permalink(); ?>" class="ghost-button">Read more</a>

								</footer>

							</div>

						</div>

					</section>

				<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php endif; ?>



				<?php if (show_posts_nav()) : ?>
				<nav class="paging">
					<?php sandpit_pagination(); ?>
				</nav>
				<?php endif; ?>

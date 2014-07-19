<?php get_header(); ?>

<div class="fullscreen-wrapper" id="content-wrapper">

	<section id="content" role="main" class="full-width">

		<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>


		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<?php

				$image = get_field('title_background');
				$url = $image['url'];
				$alt = $image['alt'];
				$imageSize = $image['sizes']['hero']; ?>

			<header class="page-header <?php echo get_field('title_background_colour'); if ($image) echo ' bg-image'; ?>" style="background-image: url(<?php echo $imageSize; ?>)">

				<h2 class="page-title"><?php the_title(); ?></h2>

			</header>
			
			<section class="blocks news-title">
				<div class="section">
						<div class="standard">
						
								<p class="meta">
									<time datetime="<?php the_time('Y-m-d')?>"><?php the_time('j\<\s\u\b\>S\<\/\s\u\b\> F Y') ?></time>
								</p>
								
						</div>
				</div>
			</section>

			<?php get_template_part('content', 'blocks'); ?>

			<footer>
			
			<section class="blocks back-to-news">
				<div class="section">
						<div class="standard">

							<a href="<?php echo get_permalink(get_option( 'page_for_posts' )); ?>" class="button">Back to news</a>
							
						</div>
				</div>
			</section>

			</footer>

		</article>


		<?php } } ?>

	</section>

</div>

<?php get_template_part('section', 'master'); ?>

<?php get_footer(); ?>

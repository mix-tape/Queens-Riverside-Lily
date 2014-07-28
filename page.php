<?php get_header(); ?>

<?php get_template_part( 'banner' ); ?>

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


			<?php get_template_part('content', 'blocks'); ?>

		</article>


		<?php } } ?>

	</section>

</div>

<?php get_template_part('section', 'master'); ?>

<?php get_footer(); ?>

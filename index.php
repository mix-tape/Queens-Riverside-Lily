<?php get_header(); ?>

<div class="fullscreen-wrapper" id="content-wrapper">

	<section id="content" role="main" class="full-width">

		<?php

			$image = get_field('title_background', get_option( 'page_for_posts' ));
			$url = $image['url'];
			$alt = $image['alt'];
			$imageSize = $image['sizes']['hero'];

		?>

		<header class="page-header bg-image white-text" style="background-image: url(<?php echo $imageSize; ?>)">

			<h2 class="page-title"><?php echo get_the_title(get_option( 'page_for_posts' )); ?></h2>

		</header>

	</section>

</div>

<?php get_template_part('loop'); ?>

<?php get_footer(); ?>

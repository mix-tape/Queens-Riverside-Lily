<?php get_header(); ?>

<?php get_template_part( 'banner' ); ?>

<div class="fullscreen-wrapper" id="content-wrapper">

	<section id="content" role="main" class="full-width">

		<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>


		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<header>

				<h2 class="page-title"><?php the_title(); ?></h2>

			</header>


			<?php get_template_part('content', 'blocks'); ?>


		</article>


		<?php } } ?>

	</section>

</div>

<?php get_template_part('section', 'livelily'); ?>

<?php get_template_part('section', 'community'); ?>

<?php get_footer(); ?>

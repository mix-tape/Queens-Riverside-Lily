<?php get_header(); ?>

<?php get_template_part( 'banner', 'home' ); ?>

<div class="fullscreen-wrapper" id="content-wrapper">

	<section id="content" role="main" class="full-width">

		<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>


		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">


			<?php get_template_part('content', 'blocks'); ?>


		</article>


		<?php } } ?>

	</section>

</div>

<?php get_template_part('section', 'master'); ?>

<?php get_footer(); ?>

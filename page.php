<?php get_header(); ?>

<?php get_template_part( 'banner' ); ?>


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


<?php get_template_part('section', 'livelily'); ?>

<?php get_template_part('section', 'community'); ?>

<?php get_footer(); ?>

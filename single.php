<?php get_header(); ?>

	<div class="wrapper" id="main-wrapper">

		<div class="section" id="main">

			<div class="section-content" id="main-content">

				<section id="content" role="main">

					<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>

					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">

						<header>

							<h2><?php the_title(); ?></h2>

							<p class="meta">

								<time datetime="<?php the_time('Y-m-d')?>">Posted <?php the_time('F jS, Y') ?></time>

								<span class="author">by <?php the_author() ?></span>.

								<span class="category">Posted in <?php the_category( ', ', 'multiple' ); ?></span>

							</p>

						</header>

						<?php get_template_part('content', 'blocks'); ?>

						<footer>



						</footer>

					</article>

					<?php comments_template(); ?>

					<?php } } ?>

				</section>

				<?php get_sidebar(); ?>

			</div><!-- End #main-content -->
				
		</div><!-- End #main -->
	
	</div><!-- End #main-wrapper -->
	
<?php get_footer(); ?>
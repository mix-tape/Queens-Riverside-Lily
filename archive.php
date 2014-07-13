<?php get_header(); ?>

	<div class="wrapper" id="main-wrapper">

		<div class="section" id="main">

			<div class="section-content" id="main-content">

				<section id="content" role="main">
				
					<?php if ( is_category() ) : ?>
					<h2 class="archive-title"><?php single_cat_title(); ?></h2>
					<?php elseif( is_tag() ) : ?>
					<h2 class="archive-title">Posts Tagged &ldquo;<?php single_tag_title(); ?>&rdquo;</h2>
					<?php elseif (is_day()) : ?>
					<h2 class="archive-title">Archive for <?php the_time('F jS, Y'); ?></h2>
					<?php elseif (is_month()) : ?>
					<h2 class="archive-title">Archive for <?php the_time('F, Y'); ?></h2>
					<?php elseif (is_year()) : ?>
					<h2 class="archive-title">Archive for <?php the_time('Y'); ?></h2>
					<?php elseif (is_author()) : ?>
					<h2 class="archive-title">Author Archive</h2>
					<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
					<h2 class="archive-title">Blog Archives</h2>
					<?php endif; ?>
				
					<?php get_template_part('loop'); ?>
				
				</section>

				<?php get_sidebar(); ?>

			</div><!-- End #main-content -->
				
		</div><!-- End #main -->
	
	</div><!-- End #main-wrapper -->
	
<?php get_footer(); ?>
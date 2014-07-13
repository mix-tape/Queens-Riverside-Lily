				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					
						<header>
							
							<time datetime="<?php the_time('Y-m-d')?>"><?php the_time('F jS, Y') ?></time> 
							
							<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
							
							<p class="meta">
								
								<span class="author">by <?php the_author_posts_link() ?></span> 
																
							</p>
													
						</header>
						
						<?php the_excerpt(); ?>
						
						<footer>
							
							
						
						</footer>
						
					</article>
				
				<?php endwhile; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
				<?php endif; ?>
				
				
				
				<?php if (show_posts_nav()) : ?>
				<nav class="paging">
					<?php sandpit_pagination(); ?>						
				</nav>
				<?php endif; ?>
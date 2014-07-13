
	<div class="wrapper" id="banner-wrapper">

		<div class="section" id="banner">

			<div class="section-content" id="banner-content">

				<?php if ( get_field('slideshow') ) { ?>
				
				
					<div id="hero">
	
	
						<?php while(has_sub_field('slideshow')) { ?>
	
							
							<div>
	
								<img src="<?php $imagedata = get_sub_field('image'); echo $imagedata['sizes']['hero']; ?>" alt="" />
	
							</div>
	
	
						<?php }	?>
				 		
	
					</div>
					
					
				<?php } ?>

			</div>

		</div>

	</div>

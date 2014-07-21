
	<div class="fullscreen-wrapper" id="register-wrapper">

		<div class="section" id="register">

			<div class="section-content" id="register-content">

				<?php if (get_field('intro_text')) { the_field('intro_text'); } else { the_field('intro_text', 'options'); } ?>

				<?php gravity_form(1, false, false, false, '', true); gravity_form_enqueue_scripts(1, true); ?>

			</div>

		</div>

	</div>

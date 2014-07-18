<?php

// ==========================================================================
//
//  Section Master
//    Process the Visible Page Sections field and output required sections
//
// ==========================================================================

$sections = get_field('visible_page_sections');

if ($sections) {

	foreach ($sections as $section) {

		get_template_part('section', $section);

	}

} elseif (!get_field('visible_page_sections')) {

	get_template_part('section', 'video');
	get_template_part('section', 'livelily-statement');
	get_template_part('section', 'register');
	get_template_part('section', 'instagram');
	get_template_part('section', 'community');

}

?>

<?php

get_header();

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 

ergo_include_section("elements/hero-simple",array('Title'=>'{{speakers-hero-title}}')); ?>

<div class="page-main page-main-dark" style="min-height: 1000px;">
	
	<div style="position: relative;z-index: 0;"><div class="page-main-gradient"></div></div>

	<div class="page-main-contain"><?php

		ergo_include_section("mirren-elements/speakers-list");
		ergo_include_section("mirren-elements/partners");
		ergo_include_section("elements/footer-cta"); ?>
		
	</div>
</div><?php

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");

get_footer(); ?>
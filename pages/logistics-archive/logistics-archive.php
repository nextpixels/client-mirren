<?php

get_header();

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 


ergo_include_section("logistics-hero",array());
ergo_include_section("elements/hero-footer-cta",array());	?>

<div class="page-main page-main-dark" style="min-height: 1000px;">
	<div style="position: relative;"><div class="page-main-gradient"></div></div>
	<div class="page-main-contain"><?php
		ergo_include_section("support-tiles");
		
		ergo_include_section("elements/hotels");
		ergo_include_section("about-2");	 ?>
		<br /><br /><?php
		ergo_include_section("elements/partners");		?>
	</div>
</div><?php

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");

get_footer(); ?>
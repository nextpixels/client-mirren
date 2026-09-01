<?php

 get_header();

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 

ergo_include_section("elements/hero-simple",array('Title'=>'{{attend-hero-title}}')); ?>


<div class="page-main page-main-dark">
	<div style="position: relative;"><div class="page-main-gradient"></div></div>
	<div class="page-main-contain"> 
	

		<div class="contain-700 p-mobile-750 p-t-25 p-b-50 text-center p-lead">
			{{attend-hero-text}}
		</div><?php

		//ergo_include_section("intro");
		ergo_include_section("attend-in-person");
		ergo_include_section("attend-virtual");
		//ergo_include_section("attend-hybrid");
		//ergo_include_section("venue");	
		ergo_include_section("mirren-elements/partners");
		ergo_include_section("elements/footer-cta");		?>
		
	</div>
</div><?php
			
require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");

get_footer(); ?>
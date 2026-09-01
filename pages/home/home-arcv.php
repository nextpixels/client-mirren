<?php

 get_header();

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 

/*
ergo_include_section("../ergo/acf-blocks/popup",array(
	"DisplayOnLoad" => true,
	"Width" => 900,
	"Height" => 500,
	"HtmlFile" => get_stylesheet_directory()."/elements/popup-ai-conference/popup-ai-conference.php"
));
*/
ergo_include_section("home-hero",array());
ergo_include_section("elements/hero-footer-cta",array());


?>

<div class="page-main page-main-dark">
	<div style="position: relative;"><div class="page-main-gradient"></div></div>
	<div class="page-main-contain"><?php

		ergo_include_section("video"); ?>
		<a id="main-content"></a> <?php
		ergo_include_section("featured-sessions");
		ergo_include_section("featured-tiles");
		//ergo_include_section("elements/logo-train-autoscroll");
		//ergo_include_section("gallery");	
		//ergo_include_section("testimonials");
		//ergo_include_section("footer-cta");
		ergo_include_section("mirren-elements/partners");
		ergo_include_section("elements/footer-cta");
				?>
		
	</div>
		
</div><?php
			
require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");

get_footer(); ?>
<?php

 get_header();

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 

require_once(get_template_directory()."/functions/ergo-includestylesheet.php");
ergo_include_stylesheet(get_stylesheet_directory()."/pages/agenda/agenda.min.css");

ergo_include_section("elements/hero-simple",array('Title'=>'{{agenda-hero-title}}'));


?>



<div class="page-main page-main-dark">
	<div style="position: relative;"><div class="page-main-gradient"></div></div>
	<div class="page-main-contain p-t-25"><?php

		ergo_include_section("mirren-elements/agenda-list");	 ?>
		<br /><br /><?php
		ergo_include_section("mirren-elements/partners");
		ergo_include_section("elements/footer-cta");		?>
		
	</div>
</div><?php

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");

get_footer(); 


?>
<?php
require_once(get_template_directory()."/functions/ergo-include-image.php"); 

?>

<section class="section-virtual ">
	
	<div class="section-standard columns-fluid collapse-900 p-t-med p-b-med">
		<div class="col-6 p-r-50 p-remove-900 vertical-center horizontal-center">
			<div><?php
				ergo_include_image(get_stylesheet_directory_uri()."/pages/attend/virtual/virtual-image.webp","Attend MirrenLive Virtually",array(
					"Fallback" => get_stylesheet_directory_uri()."/pages/attend/virtual/virtual-image.jpg",
					"Style" => "max-width: 100%;"
				));	?>
			</div>
		</div>
		<div class="col-6 p-l-50 p-remove-900 text-center-lessthan-900 vertical-center">
			<div>
				<h2 class="">{{section-virtual-title}}</h2>
				<div  class="scroll-effects fade-in">
					{{section-virtual-text}}
				</div>
				
				<div class="p-t-25">
					<a href="<?php echo get_site_url(); ?>/register" class="btn btn-primary">Register</a>
				</div>
			</div>	
		</div>
	</div>

</section>
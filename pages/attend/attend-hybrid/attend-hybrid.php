<?php

include_once(get_stylesheet_directory()."/pages/attend/fn-render-icon.php"); 

?>

<section class="section-standard p-b-50 p-t-50" style="overflow: hidden;">
	
	<div class="contain-standard p-mobile-standard columns-fluid collapse-900 p-remove-900" style="z-index: 1; position: relative;">
		<div class="col-7 p-r-50 p-remove-900 vertical-center">
			
			<div>
				<h2 class="">{{attend-hybrid-title}}</h2>
				<div  class="scroll-effects fade-in padding-b-50">
					{{attend-hybrid-text}}
				</div>
				
				<div class="columns-fluid collapse-600 contain-800 p-t-50"><?php	
						render_icon(array(
							"Id" => 7,
							"Image" => "opportunity-peers.svg"
						));
						
						render_icon(array(
							"Id" => 8,
							"Image" => "opportunity-handshake.svg"
						));
						
						render_icon(array(
							"Id" => 9,
							"Image" => "opportunity-innovation.svg"
						)); ?>
				</div>
				
				
				<div class="p-t-25">
					<a href="/register" class="btn btn-primary">Register</a>
				</div>
			</div>
			
		</div>
		<div class="col-5 p-l-50 p-remove-900 text-center"><?php
				ergo_include_image(get_stylesheet_directory_uri()."/pages/attend/attend-virtual/virtual-image.webp","Attend MirrenLive Virtually",array(
					"Fallback" => get_stylesheet_directory_uri()."/pages/attend/attend-virtual/virtual-image.jpg",
					"Style" => "max-width: 100%;"
				));	?>
		</div>
	</div>

</section>
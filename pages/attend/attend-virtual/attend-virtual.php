<?php

include_once(get_stylesheet_directory()."/pages/attend/fn-render-icon.php"); 

//$image = get_field('virtual_image')['url'];
$image = get_stylesheet_directory_uri()."/pages/attend/attend-virtual/attend-virtually-laptop.webp";
?>

<section class="section-standard p-b-50 p-t-50" style="overflow: hidden;">
	
	<div class="contain-standard columns-fluid collapse-900 p-remove-900" style="z-index: 1; position: relative;">
		<div class="col-6 p-b-25"><?php
				ergo_include_image($image,"Attend MirrenLive Virtually",array(
					"Style" => "max-width: 100%;"
				));	?>
		</div>
		<div class="col-6 vertical-center">
			
			<div>
				<h2 class="" style="margin-bottom: 0;">{{attend-virtual}}</h2>
				<div class="subtitle p-b-15">{{attend-virtual-subtitle}}</div>
				<div  class="scroll-effects fade-in padding-b-50">
					{{attend-virtual-text}}
				</div>
				
				
				<div class="columns-fluid collapse-600 contain-800 p-t-50"><?php	
						render_icon(array(
							"Id" => 4,
							"Image" => "opportunity-multiple-logins-solid-white.svg"
						));
						
						render_icon(array(
							"Id" => 5,
							"Image" => "opportunity-live-speakers-solid-white.svg"
						));
						
						render_icon(array(
							"Id" => 6,
							"Image" => "opportunity-engage-solid-white.svg"
						)); ?>
				</div>
				
				
				<div class="p-t-25">
					<a href="<?php echo get_field('hero_cta_button_href', 'options') ?>" class="btn btn-primary" style="margin-right: 20px;">Register</a>  <a href="<?php echo get_site_url(); ?>/agenda">See Full Agenda <i class="fa fa-angle-right" aria-hidden="true" style="font-size: 14px;"></i></a>
				</div>
			</div>
			
		</div>
		
	</div>

</section>
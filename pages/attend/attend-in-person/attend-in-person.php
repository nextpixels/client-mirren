<?php

include_once(get_stylesheet_directory()."/pages/attend/fn-render-icon.php"); 

$image = get_field('in_person_image')['url'];

?>

<section class="section-standard p-b-50 p-t-50" style="overflow: hidden;">
	
	<div class="contain-standard p-mobile-standard columns-fluid collapse-900 p-remove-900" style="z-index: 1; position: relative;">
		<div class="col-7 p-r-50 p-remove-900 vertical-center">
			
			<div>
				<h2 class="" style="margin-bottom: 0;">{{attend-in-preson-title}}</h2>
				<div class="subtitle p-b-15">{{attend-in-preson-subtitle}}</div>
				<div  class="scroll-effects fade-in padding-b-50">
					{{attend-in-preson-text}}
				</div>
				
				<div class="columns-fluid collapse-600 contain-800 p-t-50"><?php	
						render_icon(array(
							"Id" => 1,
							"Image" => "opportunity-network-white.svg"
						));
						
						render_icon(array(
							"Id" => 2,
							"Image" => "opportunity-meet-speakers-white.svg"
						));
						
						render_icon(array(
							"Id" => 3,
							"Image" => "opportunity-innovation-solid-white.svg"
						)); ?>
				</div>
				
				
				<div class="p-t-25">
					<a href="<?php echo get_field('hero_cta_button_href', 'options') ?>" class="btn btn-primary" style="margin-right: 20px;">Register</a>  <a href="<?php echo get_site_url(); ?>/agenda">See Full Agenda <i class="fa fa-angle-right" aria-hidden="true" style="font-size: 14px;"></i></a>
				</div>
			</div>
			
		</div>
		<div class="col-5 p-l-50 p-remove-900 text-center hide-lessthan-900"><?php
				ergo_include_image($image,"Attend MirrenLive Virtually",array(
					"Style" => "max-width: 100%;"
				));	?>
		</div>
	</div>

</section>
<?php

$data[$i] = array(
	"Id" => "0"
);

?>

<section class="attend-opportunity">
	<div class="attend-opportunity-wrapper">
		<div class="section-standard p-t-med p-b-med" style="position: relative; z-index: 1;">
		
			<div class="contain-600">
				<div class="text-centered p-b-25">
					<div class="strapline">{{opportunity-strapline}}</div>
					<h2>{{opportunity-title}}</h2>
				</div>
			</div>
			
			<div class="columns-fluid collapse-600 contain-800 p-b-50"><?php
			
				render_opportunity_tile(array(
					"Id" => 1,
					"Image" => "opportunity-peers.svg"
				));
				
				render_opportunity_tile(array(
					"Id" => 2,
					"Image" => "opportunity-handshake.svg"
				));
				
				render_opportunity_tile(array(
					"Id" => 3,
					"Image" => "opportunity-innovation.svg"
				)); ?>
			
			</div>
			
			<div class="contain-600 text-centered">
				<div class="p-l-15 p-r-15" style="display: inline-block;"><a href="<?php echo get_site_url(); ?>/agenda" class="btn btn-primary">See Agenda</a></div>
				<div class="p-l-15 p-r-15" style="display: inline-block;"><a href="<?php echo get_site_url(); ?>/register" class="btn btn-primary">Register</a></div>
			</div>

		</div>
	</div>
</section><?php


function render_opportunity_tile($data){ ?>
	<div class="opportunity-tile col-4 p-b-50 p-l-15 p-r-15 p-r-remove-700">
		<div style="text-align: center;">
			<?php ergo_include_image(get_stylesheet_directory_uri()."/pages/attend/opportunity/".$data['Image'],"",array('Class'=>'opportunity-image p-b-15')); ?>
			<h3>{{opportunity-title-<?php echo $data['Id']; ?>}}</h3>
		</div>
	</div><?php
}	?>
<div class="contain-standard p-mobile-standard p-t-125 columns-fluid collapse-800"><?php

	render_support_tile("email");
	render_support_tile("phone");
	render_support_tile("venue");	?>
	
</div><?php


function render_support_tile($type){ ?>
	<div class="col-4 p-b-25">
		<div class="p-r-20 p-remove-800" style="height: 100%;">
			<div class="tile-gray text-center" style="height: 100%; padding-bottom: 20px;">
				<div class="tile-gray-icon-wrapper">
					<?php ergo_include_image(get_stylesheet_directory_uri()."/pages/logistics/support-tiles/ico-".$type.".svg","",array('Class'=>'','Style'=>'width: 25px; max-height: 32px;'));  ?>
				</div>
				<div class="p-b-15">
					<h2 class="h2-small">{{support-<?php echo $type; ?>-title}}</h2>
				</div>
				<div>
					{{support-<?php echo $type; ?>-text}}
				</div>
			</div>
		</div>
	</div><?php
}	?>

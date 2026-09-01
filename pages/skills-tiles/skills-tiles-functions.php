<?php

function featured_tile($text){ ?>
	<div class="col-4 p-b-50 p-r-35 p-r-remove-700">
		<div class="columns-flex">
			<div class="col col-75">
				<?php ergo_include_image(get_stylesheet_directory_uri()."/elements-acf/skills-tiles/featured-session-icon.svg","",array('Class'=>'featured-image-icon')); ?>
			</div>
			<div class="col col-fluid">
				<h3><?php echo $text; ?></h3>
			</div>
		</div>
	</div><?php
}	

?>
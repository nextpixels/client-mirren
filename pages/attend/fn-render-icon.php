<?php

function render_icon($data){ ?>
	<div class="opportunity-tile col-4 p-b-15 p-l-15 p-r-15 p-r-remove-700">
		<div style="text-align: center;">
			<?php ergo_include_image(get_stylesheet_directory_uri()."/pages/attend/images/".$data['Image'],"",array('Class'=>'opportunity-image p-b-15')); ?>
			<h3>{{opportunity-title-<?php echo $data['Id']; ?>}}</h3>
		</div>
	</div><?php

}	?>
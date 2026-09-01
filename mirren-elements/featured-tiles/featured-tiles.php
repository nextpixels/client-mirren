<section id="featured-tiles" class="featured-tiles">

	<div class="contain-standard p-mobile-standard p-standard" style="position: relative; z-index: 1;">
	
		<div class="contain-800">
			<div class="text-center text-left-1000 p-b-25">
				<h2>{{featured-tiles-title}}</h2>
			</div>
		</div>
		
		<div class="columns-fluid collapse-700"><?php
			for ($i=0;$i<6;$i++){
				featured_tile($i);
			} ?>
			
		</div>
		
		<div class="text-center">
			<a href="<?php echo get_site_url(); ?>/agenda" class="btn btn-primary">See Agenda</a>
		</div>
</section><?php



function featured_tile($id){ ?>
	<div class="col-4 p-b-50 p-r-35 p-r-remove-700">
		<div class="columns-flex">
			<div class="col col-75">
				<?php ergo_include_image(get_stylesheet_directory_uri()."/pages/home/featured-tiles/featured-session-icon.svg","",array('Class'=>'featured-image-icon')); ?>
			</div>
			<div class="col col-fluid">
				<h3>{{featured-tiles-v2-<?php echo $id; ?>}}</h3>
			</div>
		</div>
	</div><?php
}	?>
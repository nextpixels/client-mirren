<?php
if (stristr($_SERVER['REQUEST_URI'],"wp-admin")){ ?>
	<div class="p-25 text-center" style="border: 1px solid #CCC; cursor: pointer;">
		Background Image (not editable)
	</div>
	<?php
}
else{ ?>
	<div class="contain-1100 hide-lessthan-1000">
		<div class="columns-fluid">
			<div class="col-8" style="width: 60%; position: relative;">
				<img class="splash-hero-image" src="<?php echo get_stylesheet_directory_uri(); ?>/pages/splash/background-image/splash-hero-background-2024.jpg" />
			</div>
			<div class="col-4" style="width: 40%;"></div>
		</div>
		</div>
	<?php
} ?>


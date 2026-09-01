<?php

	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");
	require_once(get_template_directory()."/functions/ergo-include-section.php");
	require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php");

	ergo_embed_styles_scripts(__DIR__);	

	$title = get_field('title');


?>

<section class="hero-simple-wrapper">
	<div class="hero-simple contain-1100 p-mobile-1150">
		<div class="hero-simple-content">
			
			<div class="columns-fluid collapse-700">
				<div class="col-6 hero-simple-content-title">
					<div class="text-center"><h1><?php echo $title; ?></h1></div>	
				</div>
				<div class="col-6 hero-simple-content-callout"><?php
					if (!empty($calloutText)){ ?>	
						<div class="hero-callout" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/elements-acf/mirren-home-hero/callout-background.webp');">
							<div class="hero-callout-inner">
								<div class="hero-callout-text-wrapper">
									<div class="strapline"><?php echo $calloutStrapline; ?></div>
									<?php echo $calloutText; ?>
								</div>
							</div>
						</div><?php
					} ?>
				
				</div>
			</div>
			
		</div>
	</div>
</section>
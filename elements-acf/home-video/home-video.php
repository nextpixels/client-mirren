<?php

	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");
	ergo_embed_styles_scripts(__DIR__);	
	
	
	$title = get_field('title');
	$text = get_field('text');
	$buttonUrl = get_field('button_url');
	$buttonLabel = get_field('button_label');
	
?>


<section id="home-intro" class="section-video" style="overflow: hidden;">
	<div class="p-b-50 p-remove-900">
		
		<div class="content-area contain-standard p-mobile-standard columns-fluid collapse-900 p-t-75" style="z-index: 1; position: relative; background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/elements-acf/home-video/home-video-background.webp');">
			<div class="col-6 p-r-50 p-remove-900 vertical-center">
				
				<div class="p-b-50">
					<h2 class=""><?php echo $title; ?></h2>
					<div class="h2-separator"></div>
					<div  class="video-content scroll-effects fade-in padding-b-50">
						<?php echo $text; ?>
					</div><?php
					
					if (!empty($buttonUrl) && !empty($buttonLabel)){ ?>
						<div class="p-t-25">
							<a href="<?php echo $buttonUrl; ?>" class="btn btn-primary"><?php echo $buttonLabel; ?></a>
						</div><?php
					} ?>
					
				</div>
				
			</div>
			<?php /*<div class="col-6 col-right p-l-50 p-remove-900 text-center-lessthan-900" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/elements-acf/home-video/video-background.webp');"> */ ?>
			<div class="col-6 col-right p-l-50 p-remove-900 text-center-lessthan-900">
				

					<div style="padding: 0; min-height:300px; margin-top: 25px; background-size: cover; background-position: top center;">
					<?php /*
					
					  
						<video  controls poster="<?php echo get_stylesheet_directory_uri(); ?>/elements-acf/home-video/video-cover.jpg" style="width: 100%;">
							<source src="<?php echo get_stylesheet_directory_uri(); ?>/elements-acf/home-video/mirren-live-recap-promo-sizzle.mp4" type="video/mp4">
							Your browser does not support the video tag.
						</video>
					*/ ?>
					</div>

			
			</div>
		</div>
	
	</div>
</section>



	<?php /* <div class="video-container" style="padding: 0; min-height:300px; margin-top: 25px; background-image:url('<?php echo get_stylesheet_directory_uri()."/pages/home/video/video-cover.jpg" ;?>'); background-size: cover; background-position: top center;"> */ ?>
				<?php /*
				<div class="video-container" style="padding: 0; min-height:300px; margin-top: 25px; background-size: cover; background-position: top center;">
					
				<script src="https://fast.wistia.com/embed/medias/d2nfgeqru0.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_d2nfgeqru0 videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/d2nfgeqru0/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>
				
				</div>	*/ ?>
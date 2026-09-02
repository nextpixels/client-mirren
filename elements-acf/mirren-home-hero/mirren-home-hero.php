<?php

include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");
require_once(get_template_directory()."/functions/ergo-include-section.php");
require_once(get_template_directory()."/functions/ergo-include-image.php");

ergo_embed_styles_scripts(__DIR__); 

$title = get_field('title');
$strapline = get_field('strapline');
$sectionClasses = get_field('section_classes');
$backgroundImage = get_field('background_image');
$logoSubtext = wp_specialchars_decode(get_field('logo_subtext'));
$logoImage = get_field('logo_image');
$contentMaxWidth = get_field('content_maximum_width');
$css = get_field('css');

$calloutStrapline = get_field('callout_strapline');

?>

<style><?php
	if (!empty($contentMaxWidth)){ ?>
		.home-hero-content-column-content{
			max-width: <?php echo $contentMaxWidth; ?>px;
		}
		@media(max-width: 900px){
			.home-hero-content-column-content{
				margin: 0 auto;
			}
		}<?php
	}

	if (!empty($css)){
		echo ergo_minify_css($css);
	} ?>
</style>

<div class="home-hero <?php echo $sectionClasses; ?>">
	<div class="home-hero-background-image" style="background-image: url('<?php echo $backgroundImage; ?>);">
		<div style="height: 100%; display: flex; align-items: center;">
		<div class="home-hero-content contain-1100 p-mobile-1150">
			<div class="columns-fluid collapse-900">
				<div class="col-6 home-hero-content-column">
					
					<div class="home-hero-content-column-content"><?php
						if (!empty($strapline)){ ?>
							<div class="strapline"><?php echo $strapline; ?></div><?php
						}

						if (!empty($logoImage)){
							ergo_include_image($logoImage,"",array('Class' => 'home-hero-logo'));
						}

						if (!empty($logoSubtext)){ ?>
							<div class="hero-subtitle">
								<?php echo $logoSubtext;; ?>
							</div><?php
						} ?>
						<h1><?php echo $title; ?></h1>	
						<?php echo wp_specialchars_decode(get_field('hero_text')); ?>
					</div>
				</div>


				<div class="col-6 text-right col-callout vertical-center"><?php
					$callout = get_field('callout_text');
					if (!empty($callout)){ ?>
						<div class="hero-callout">
							<div class="hero-callout-inner">
								<div class="hero-callout-text-wrapper"><?php
									if (!empty($calloutStrapline)){ ?>
										<div class="strapline"><?php echo $calloutStrapline; ?></div><?php 
									} ?>
									<?php echo $callout; ?>
								</div>
							</div>
						</div><?php
					} ?>
				</div>
			</div>
		</div>
</div>
	</div>
</div>

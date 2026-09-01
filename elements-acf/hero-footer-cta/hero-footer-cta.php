<?php

	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");
	require_once(get_template_directory()."/functions/ergo-include-section.php");

	ergo_embed_styles_scripts(__DIR__);	

	$title = get_field('title');
	$text = get_field('text');
	$buttonTarget = get_field('button_target');
	$buttonLabel = get_field('button_label');

	if (empty($title)){
		$title 					=  get_field('hero_cta_title', 'options');
	}
	if (empty($text)){
		$text 					=  get_field('hero_cta_text', 'options');
	}
	if (empty($buttonTarget)){
		$buttonTarget 	=  get_field('hero_cta_button_href', 'options');
	}
	if (empty($buttonLabel)){
		$buttonLabel 	=  get_field('hero_cta_button_text', 'options');
	}
	
?>

<section id="hero-footer-cta" class="p-t-25 p-b-25">
	<div class="contain-1200 p-mobile-1250 text-center">
		<h2><?php echo $title; ?></h2><?php
		if ($text){ ?>
			<p><?php echo $text; ?></p><?php
		} ?>
		<div class="p-t-15"><?php
			if (stristr($buttonTarget,"http")){ ?>
				<a href="<?php echo $buttonTarget; ?>" class="btn btn-primary"><?php echo $buttonLabel; ?></a><?php
			}
			else{ ?>
				<a href="<?php echo get_site_url()."/".$buttonTarget; ?>" class="btn btn-primary"><?php echo $buttonLabel; ?></a><?php
			}	?>
		</div>
	</div>
</section>
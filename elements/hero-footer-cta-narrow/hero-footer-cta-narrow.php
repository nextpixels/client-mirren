<?php
	$title 					=  get_field('hero_cta_title', 'options');
	$text 					=  get_field('hero_cta_text', 'options');
	$buttonTarget 	=  get_field('hero_cta_button_href', 'options');
	$buttonLabel 	=  get_field('hero_cta_button_text', 'options');
?>

<section id="hero-footer-cta-narrow">
	<div class="contain-700 p-mobile-750 text-center">
		
		<div class="columns-fluid collapse-600">
			<div class="col-6 vertical-center horizontal-center">
				<h2><?php echo $title; ?></h2><?php
				if ($text){ ?>
					<p><?php echo $text; ?></p><?php
				} ?>
			</div>
			<div class="col-6 vertical-center horizontal-center"><?php
			if (stristr($buttonTarget,"http")){ ?>
				<a href="<?php echo $buttonTarget; ?>" class="btn btn-primary"><?php echo $buttonLabel; ?></a><?php
			}
			else{ ?>
				<a href="<?php echo get_site_url()."/".$buttonTarget; ?>" class="btn btn-primary"><?php echo $buttonLabel; ?></a><?php
			}	?>
			</div>
		</div>

	</div>
</section>
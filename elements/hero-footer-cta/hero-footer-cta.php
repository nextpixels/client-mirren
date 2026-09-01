<?php
	$title 					=  get_field('hero_cta_title', 'options');
	$text 					=  get_field('hero_cta_text', 'options');
	$buttonTarget 	=  get_field('hero_cta_button_href', 'options');
	$buttonLabel 	=  get_field('hero_cta_button_text', 'options');
	
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
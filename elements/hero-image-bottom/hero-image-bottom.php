<?php

	require_once(get_template_directory()."/functions/ergo-include-image.php");
	require_once(get_stylesheet_directory()."/elements/hero-common/get-data.php");

?>

<section id="page-hero" class="page-hero <?php echo $options['Settings']['Class']; ?>" style="<?php echo $options['Settings']['WrapperStyle']; ?>">
	
	<div class="contain-standard p-mobile-standard" style="position: relative;">
		
				<?php require_once(get_stylesheet_directory()."/elements/hero-common/render-hero-content.php"); ?>
		
	</div><?php
	
	if ($options['Settings']['BackgroundImageFullWidth'] == true){
		$imageOptions['Class'] = "hero-image";
		$imageOptions['Style'] = "width: 100%;";
		$imageOptions['NoLazy'] = true;
		ergo_include_image($options['BackgroundImage'],"",$imageOptions);
	}
	else{ ?>
		<div class="hero-image-wrapper contain-1200"><?php
			$imageOptions['Class'] = "hero-image";
			$imageOptions['Style'] = "width: 100%;";
			$imageOptions['NoLazy'] = true;
			ergo_include_image($options['BackgroundImage'],"",$imageOptions);	?>
		</div><?php
	} ?>
</section>
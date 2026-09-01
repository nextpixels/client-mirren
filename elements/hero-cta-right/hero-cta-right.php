<?php

	require_once(get_template_directory()."/functions/ergo-include-image.php");
	require_once(get_stylesheet_directory()."/elements/hero-common/get-data.php");

	if(!$options['CollapseWidth']){
		$options['CollapseWidth'] = "800";
	}
	if(!$options['Image_Class']){
		$options['Image_Class'] = "hide-lessthan-".$options['CollapseWidth'];
	}
	if(!$options['Image_Style']){
		$options['Image_Style'] = "position: absolute; right: 0; bottom: 0; z-index: 0;";
	}

	if (!$options['Image_Code_Placement']){
		$options['Image_Code_Placement'] = "above";			//options: above, below This just specified where the image is placed in the code -- basically whether it's positioned above or below the hero text content. Normally, it's placed at the top, and absolutely positioned, but it can sometimes be helpful to place the image ater the content.
	}
	
?>

<section id="page-hero" class="page-hero <?php echo $options['Class']; ?>" style="<?php echo $options['WrapperStyle']; ?>;">
	
	<div class="hero-background">
		<div class="contain-standard p-mobile-standard columns-fluid collapse-<?php echo $options['CollapseWidth']; ?> hero-content" style="position: relative;"><?php
			if ($options['HideCTABox'] != true){ ?>
				<div class="col-8 hero-content-section"><?php 
					if ($options['Image'] && $options['Image_Code_Placement'] == "above"){
						ergo_include_image(get_stylesheet_directory_uri().$options['Image'],"",array('Class'=>'hero-desktop-image '.$options['Image_Class'],'Style'=>$options['Image_Style'])); 
					}	?>
					<div class="p-r-75 p-remove-<?php echo $options['CollapseWidth']; ?> vertical-center" style="height: 100%; position: relative; z-index: 1;">
						<?php require_once(get_stylesheet_directory()."/elements/hero-common/render-hero-content.php"); ?>
					</div>
				</div>
				<div class="col-4 p-t-25" style="position: relative;">
						<div class="hero-cta-box">
							<?php require_once(get_stylesheet_directory()."/elements/hero-common/render-hero-cta-box-content.php"); ?>
						</div>
				</div><?php
			}
			else{ ?>
				<div class="col-12 hero-content-section">
					<?php ergo_include_image(get_stylesheet_directory_uri().$options['Image'],"",array('Class'=>'hero-desktop-image '.$options['Image_Class'],'Style'=>$options['Image_Style'])); ?>
					<div class="p-r-75 vertical-center" style="height: 100%; position: relative; z-index: 1;">
						<?php require_once(get_stylesheet_directory()."/elements/hero-common/render-hero-content.php"); ?>
					</div>
				</div><?php
			} ?>
			
		</div>
		
		<div class="hide-morethan-<?php echo $options['CollapseWidth']; ?> hero-mobile-image text-right">
			<?php ergo_include_image(get_stylesheet_directory_uri().$options['Image_Mobile'],"",array('Class'=>'','Style'=>'max-width: 100%;')); ?>
		</div>
		
	</div>
	
</section>
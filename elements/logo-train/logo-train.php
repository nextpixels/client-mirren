<?php

	//Logo Train ?>

	<section id="logotrain" class=" logotrain text-invert">
			<div class="contain-1100 padding-mobile-1150 padding-t-75 padding-b-25">
				<div class="contain-700 text-centered">
					<h2 class="padding-b-75 h2-small">Advancing Research for 500+ Labs</h2>
				</div><?php
				
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-havard"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-yale"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-johnshopkins"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-mit"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-cleveland-clinic"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-georgetown"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-universitypittsburgh"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-universitytennessee"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-north-carolina"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-nc-state"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-university-virginia"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-stanford"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-utah"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-texas"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-iowa"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-ucdavis"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-ucriverside"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-uci"
				);
				$logotrain[] = array(
					"Title" => "",
					"Image" => "logotrain-ucla"
				);


				function display_logotrain_image($logotrainimage){ ?>
					<div class=" logotrain-image-wrapper flex-tile">
						
						<?php /*
						<img srcset="<?php echo get_stylesheet_directory_uri(); ?>/elements/logo-train/images/<?php echo $logotrainimage['Image']; ?>@2x.png 2x" src="<?php echo get_stylesheet_directory_uri(); ?>/elements/logo-train/images/<?php echo $logotrainimage['Image']; ?>.png" alt="" style="display: inline-block;"  loading="lazy" />
						*/ ?>
						<?php
						$baseImage = get_stylesheet_directory_uri()."/elements/logo-train/images/".$logotrainimage['Image'];
						?>
						
						<picture>
							<source type="image/webp" srcset="<?php echo $baseImage; ?>.webp 1x, <?php echo $baseImage; ?>@2x.webp 2x">
							<source type="image/jpeg" srcset="<?php echo $baseImage; ?>.jpg, <?php echo $baseImage; ?>@2x.jpg 2x">
							<img src="<?php echo $baseImage; ?>.jpg" alt="something" style="display: inline-block;" loading="lazy">
						</picture> 
						
					</div><?php
				}	

				/* Logo Train Desktop */ ?>
					<div id="hero-slideshow-logos" class="np-slideshow text-centered hide-lessthan-600" data-duration="5000" data-fadeinspeed="1000" data-fadeoutspeed="1000">
						<div class="np-slideshow-slide np-slideshow-slide-0" data-slideid="0">
							<div class=" logotrain-row flex-tiles"><?php
								display_logotrain_image($logotrain[0]);
								display_logotrain_image($logotrain[1]);
								display_logotrain_image($logotrain[2]);
								display_logotrain_image($logotrain[3]);							?>
							 </div>
						</div>
						
						<div class="np-slideshow-slide np-slideshow-slide-1" data-slideid="1">
							<div class=" logotrain-row flex-tiles"><?php
								display_logotrain_image($logotrain[4]);
								display_logotrain_image($logotrain[5]);
								display_logotrain_image($logotrain[6]);
								display_logotrain_image($logotrain[7]);
								?>
							 </div>
						</div>
						
						<div class="np-slideshow-slide np-slideshow-slide-2" data-slideid="2">
							<div class=" logotrain-row flex-tiles"><?php
								display_logotrain_image($logotrain[8]);
								display_logotrain_image($logotrain[9]);
								display_logotrain_image($logotrain[10]);
								display_logotrain_image($logotrain[11]);
								?>
							 </div>
						</div>
						
						<div class="np-slideshow-slide np-slideshow-slide-3" data-slideid="3">
							<div class=" logotrain-row flex-tiles"><?php
								display_logotrain_image($logotrain[12]);
								display_logotrain_image($logotrain[13]);
								display_logotrain_image($logotrain[14]);
								display_logotrain_image($logotrain[15]);
								?>
							 </div>
						</div>
						
						<div class="np-slideshow-slide np-slideshow-slide-4" data-slideid="4">
							<div class=" logotrain-row flex-tiles"><?php
								display_logotrain_image($logotrain[16]);
								display_logotrain_image($logotrain[17]);
								display_logotrain_image($logotrain[18]);
								?>
							 </div>
						</div>
						
						<div class="padding-b-50">
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-0 current" data-slide="0"></a>
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-1" data-slide="1"></a>
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-2" data-slide="2"></a>
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-3" data-slide="3"></a>
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-4" data-slide="4"></a>
						</div>		
					</div><?php
				
				/* End Logo Train Desktop */ 
				
				
				/* Logo Train Mobile */	?>
					
					<div id="hero-slideshow-logos" class="np-slideshow text-centered hide-morethan-600" data-duration="5000" data-fadeinspeed="1000" data-fadeoutspeed="1000">
						<div class="np-slideshow-slide np-slideshow-slide-0" data-slideid="0">
							<div class=" logotrain-row flex-tiles gap-0"><?php
								display_logotrain_image($logotrain[0]);
								display_logotrain_image($logotrain[1]);
								display_logotrain_image($logotrain[3]); ?>
							 </div>
							 <div class=" logotrain-row flex-tiles gap-0"><?php
								
								display_logotrain_image($logotrain[4]);
								display_logotrain_image($logotrain[5]);
								display_logotrain_image($logotrain[6]); ?>
							</div>
						</div>
						<div class="np-slideshow-slide np-slideshow-slide-1" data-slideid="1">
							<div class=" logotrain-row flex-tiles gap-0"><?php
								display_logotrain_image($logotrain[7]);
								display_logotrain_image($logotrain[8]);
								display_logotrain_image($logotrain[9]); ?>
							 </div>
							 <div class=" logotrain-row flex-tiles gap-0"><?php
								
								display_logotrain_image($logotrain[10]);
								display_logotrain_image($logotrain[11]);
								display_logotrain_image($logotrain[12]); ?>
							</div>
						</div>
						<div class="np-slideshow-slide np-slideshow-slide-2" data-slideid="2">
							<div class=" logotrain-row flex-tiles gap-0"><?php
								display_logotrain_image($logotrain[13]);
								display_logotrain_image($logotrain[14]);
								display_logotrain_image($logotrain[15]); ?>
							 </div>
							 <div class=" logotrain-row flex-tiles gap-0"><?php
								
								display_logotrain_image($logotrain[16]);
								display_logotrain_image($logotrain[17]);
								display_logotrain_image($logotrain[18]); ?>
							</div>
						</div>
						
						<div class="padding-b-50">
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-0 current" data-slide="0"></a>
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-1" data-slide="1"></a>
							<a href="#" class="np-slideshow-change-slide np-slideshow-change-slide-2" data-slide="2"></a>
						</div>		
					</div><?php
				
				/* End Logo Train Mobile */	?>
				
			</div>
		</section><?php
	
//End Logo Train */ ?>	
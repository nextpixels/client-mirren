<?php

	$partners = get_field('conference_partner', 'option');
	
	
	if( have_rows('conference_partner','option')){
		$count = 0;
		while( have_rows('conference_partner','option') ){
			the_row();
			$tmp 																= get_sub_field('conference_partner_image');
			$partnerImage[$count]['ImageUrl'] 			= $tmp['url'];
			$partnerImage[$count]['Link']					= get_sub_field('conference_partner_link');
			$partnerImage[$count]['CssClass']					= get_sub_field('css_class');
			$partnerImage[$count]['ImageSize']			= get_sub_field('conference_partner_image_size');
			if (!$partnerImage[$count]['ImageSize']){
				$partnerImage[$count]['ImageSize'] = "60%";
			}
			$count++;
		}
	}

	$partnersMaxWidth = get_field('conference_partners_max_width', 'option') ?: 1200;
	$partnersMaxWidthPadding = (int)$partnersMaxWidth + 50;
	
	if (empty($options['Title'])){
		$options['Title'] = "Conference Partners";
	}
	
	
	?>
		
	<section class="partners-section page-main-dark">	
		<div class="partners contain-<?php echo $partnersMaxWidth; ?> p-mobile-<?php echo $partnersMaxWidthPadding; ?> p-t-75 p-b-75">
			<h2><?php echo $options['Title']; ?></h2><?php
			if (!empty($options['Text'])){ ?>
				<p><?php echo $options['Text']; ?></p><?php
			}
			
			for ($i=0;$i<count($partnerImage);$i++){ 
				if ($partnerImage[$i]['ImageSize'] != "hide"){ ?>
					<div class="partner-logo-wrapper partner-logo-<?php echo $i; ?> <?php echo  $partnerImage[$i]['CssClass']; ?>">
						<div class="partner-logo-contain"><?php
							if ($partnerImage[$i]['Link']){ ?>
								<a href="<?php echo $partnerImage[$i]['Link']; ?>" target="_blank" style="display: block;"><img src="<?php echo $partnerImage[$i]['ImageUrl']; ?>" alt="" style="max-width: <?php echo $partnerImage[$i]['ImageSize']; ?>;" /></a><?php
							}
							else{ ?>
								<img src="<?php echo $partnerImage[$i]['ImageUrl']; ?>" alt="" style="max-width: <?php echo $partnerImage[$i]['ImageSize']; ?>;" /><?php
							} ?>
						</div>
					</div><?php
				}
			} ?>
		</div>
	</section>
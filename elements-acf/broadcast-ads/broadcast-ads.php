<?php

require_once(get_template_directory()."/functions/ergo-include-image.php");

$ads = array();

$BroadcastAds_Title 	= get_field('broadcastads_title');
$BroadcastAds_Text 	= get_field('broadcastads_text');

if( have_rows('broadcast_ads') ):
    while( have_rows('broadcast_ads') ): the_row();
        $ad_image = get_sub_field('ad_image');
        $ad_link  = get_sub_field('ad_link');

        $ads[] = array(
            'ad_image' => $ad_image,
            'ad_link'  => $ad_link
        );
    endwhile;
endif;

?>

<div class="contain-1100 p-mobile-1150">
	<div class="broadcast-ads">
	
		<div class="broadcast-ads-header"><?php
			if (!empty($BroadcastAds_Title)){ ?>
				<h2><?php echo $BroadcastAds_Title; ?></h2><?php
			}
			if (!empty($BroadcastAds_Text)){ ?>
				<p><?php echo $BroadcastAds_Text; ?></p><?php
			} ?>
		</div>

		<div class="columns-grid columns-grid-<?php echo count($ads); ?> column-gap-10"><?php
			foreach($ads as $ad){ ?>
				<div class="col p-b-25">
					<a href="<?php echo $ad['ad_link']; ?>" target="_blank"><?php
					ergo_include_image($ad['ad_image']); ?>
					</a><?php
					
					if (!empty($ad['ad_link'])){ ?>
						<div class="broadcast-ads-button-wrapper">
							<a href="<?php echo $ad['ad_link']; ?>" class="btn btn-primary" target="_blank">See More ></a>
						</div><?php
					} ?>			

				</div><?php
			} ?>
		</div>
	</div>
</div>

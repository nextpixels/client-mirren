<?php

	require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php");
	require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
	require_once(get_template_directory()."/functions/ergo-include-image.php");

	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");

	ergo_embed_styles_scripts(__DIR__);

	//Get the "session" repeater's rows into $sessions:
		$sessions = array();
		if (have_rows('session')) {
			$count = 0;
			while (have_rows('session')) {
				the_row();

				$sessions[$count]['Title'] 					= get_sub_field('title');
				$sessions[$count]['SubTitle'] 				= get_sub_field('sub_title');
				$sessions[$count]['SpeakerAgency'] 			= get_sub_field('speaker_agency');
				$sessions[$count]['SpeakerName'] 			= get_sub_field('speaker_name');
				$sessions[$count]['Image'] 					= get_sub_field('image');
				$sessions[$count]['TileBackgroundColor']	= get_sub_field('tile_background_color');

				$count++;
			}
		}

?>

<style><?php
	$tileNumber = 0;
	foreach($sessions as $session){

		if (!empty($session['TileBackgroundColor'])){
			echo ".featured-sessions-tile-".$tileNumber."{background-color: ".$session['TileBackgroundColor'].";}";
		}

		//Only use the image as a background above 900px -- below that it's shown as a regular
		//<img> at the bottom of the tile instead (see the "hide-lessthan-900" image in the markup below):
		if (!empty($session['Image'])){
			echo "@media (min-width: 901px){";
				echo ".featured-sessions-tile-".$tileNumber."{background-image: url('".$session['Image']."'); background-repeat: no-repeat; background-position: bottom right;}";
			echo "}";
		}

		$tileNumber++;
	}	?>
</style>

<section class="featured-sessions-v2 p-t-75 p-b-75">
	<div class="contain-1100 p-mobile-1150 columns-grid columns-grid-2 column-gap-30 row-gap-30 collapse-800"><?php
		$tileNumber = 0;
		foreach($sessions as $session){ ?>
			<div class="featured-sessions-tile featured-sessions-tile-<?php echo $tileNumber; ?>">

				<div class="featured-sessions-tile-content">

					<h3><?php echo $session['Title']; ?></h3>
					<div class="featured-sessions-tile-subtitle"><?php echo $session['SubTitle']; ?></div>

					<div class="featured-sessions-tile-person p-t-50">
						<div class="featured-sessions-tile-agency"><?php echo $session['SpeakerAgency']; ?></div>
						<div class="featured-sessions-tile-person-name"><?php echo $session['SpeakerName']; ?></div>
					</div>

				</div>
				<?php if (!empty($session['Image'])){
					ergo_include_image($session['Image'],"",array('Class' => 'featured-sessions-tile-image hide-morethan-900'));
				} ?>

			</div><?php
			$tileNumber++;
		} ?>
	</div>
</section>

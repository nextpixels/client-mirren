<?php

			
	require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php"); 
	require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
	//require_once("featured-sessions-functions.php");
	
	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");

	ergo_embed_styles_scripts(__DIR__);

	//Get the "session" repeater's rows into $sessions:
		$sessions = array();
		if (have_rows('session')) {
			$count = 0;
			while (have_rows('session')) {
				the_row();

				$sessions[$count]['Title'] 			= get_sub_field('title');
				$sessions[$count]['SubTitle'] 			= get_sub_field('sub_title');
				$sessions[$count]['SpeakerAgency'] 	= get_sub_field('speaker_agency');
				$sessions[$count]['SpeakerName'] 		= get_sub_field('speaker_name');

				$count++;
			}
		}

?>


<section class="featured-sessions-v2 p-t-75 p-b-75">
	<div class="contain-1100 p-mobile-1150 columns-grid columns-grid-2 column-gap-30 row-gap-30"><?php
		foreach($sessions as $session){ ?>
		<div class="featured-sessions-tile">
			<h3><?php echo $session['Title']; ?></h3>
			<div><?php echo $session['SubTitle']; ?></div>

		</div><?php
		} ?>
	</div>
</section>


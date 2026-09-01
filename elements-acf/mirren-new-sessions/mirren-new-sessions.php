<?php
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");
	require_once(get_template_directory()."/functions/ergo-include-image.php");
	require_once("mirren-new-sessions-functions.php");
	
	ergo_embed_styles_scripts(__DIR__);	
	
	
	
	$session = array();

	if ( have_rows('session') ) {
		$count = 0;

		while ( have_rows('session') ) {
			the_row();

			// Session-level fields
			$session_title          = get_sub_field('session_title');
			$session_text           = get_sub_field('session_text');
			$just_added_notice_text = get_sub_field('just_added_notice_text');

			// Initialize speakers array
			$speakers = array();

			// Loop through nested "speaker" repeater
			if ( have_rows('speakers') ) {
				$speaker_count = 0;

				while ( have_rows('speakers') ) {
					the_row();

					$speaker_name    = get_sub_field('speaker_name');
					$speaker_title   = get_sub_field('speaker_title');
					$speaker_company = get_sub_field('speaker_company');
					$speaker_image   = get_sub_field('speaker_image'); // This will be an array if it's an image field

					$speakers[$speaker_count] = array(
						'Name'    => $speaker_name,
						'Title'   => $speaker_title,
						'Company' => $speaker_company,
						'Image'   => $speaker_image,
					);

					$speaker_count++;
				}
			}

			// Combine session and speaker data
			$session[$count] = array(
				'Title'          => $session_title,
				'Text'           => $session_text,
				'JustAddedNotice'=> $just_added_notice_text,
				'Speakers'       => $speakers,
			);

			$count++;
		}
	}
	
	//print_r($session);

?>

<div class="mirren-new-sessions contain-1100 p-mobile-1150">
	<div class="columns-flex collapse-1000">
		<div class="col col-fluid p-r-20 p-remove-1000" style="height: 100%;">
		
			<div class="columns-grid columns-grid-2 collapse-600">
				<div class="col">
					<?php render_new_session_tile(array(
						'JustAddedText' => $session[0]['JustAddedNotice'],
						'Title' => $session[0]['Title'],
						'Text' => $session[0]['Text'],
						'Speakers' => $session[0]['Speakers'],
						'AgendaLink' => 'https://ai.mirren.com/agenda/',
					)); ?>
				</div>
				<div class="col">
					<?php render_new_session_tile(array(
						'JustAddedText' => $session[1]['JustAddedNotice'],
						'Title' => $session[1]['Title'],
						'Text' => $session[1]['Text'],
						'Speakers' => $session[1]['Speakers'],
						'AgendaLink' => 'https://ai.mirren.com/agenda/',
					)); ?>
				</div>
			</div>
			
			<div class="p-b-40 hide-lessthan-1000"></div>
			
			<?php render_new_session_tile(array('Type'=>'highlight','Class'=>'highlight-tile','Text'=>'30+ Agency Innovators Share Their AI Builds, Approach & Live Demos')); ?>
		
		</div>
		<div class="col col-400 p-l-20 large-tile p-remove-1000">
			<?php render_new_session_tile(array(
				'JustAddedText' => $session[2]['JustAddedNotice'],
				'Title' => $session[2]['Title'],
				'Text' => $session[2]['Text'],
				'Speakers' => $session[2]['Speakers'],
				'AgendaLink' => 'https://ai.mirren.com/agenda/')); ?>
				
				<?php /* render_new_session_tile(array(
				'JustAddedText' => $session[2]['JustAddedNotice'],
				'Title' => $session[2]['Title'],
				'Text' => $session[2]['Text'],
				'Speakers' => $session[2]['Speakers'],
				'AgendaLink' => 'https://ai.mirren.com/agenda/',
				'BackgroundImage'=>get_stylesheet_directory_uri().'/images/robot.svg'));  */ ?>
		</div>
	</div>
</div>
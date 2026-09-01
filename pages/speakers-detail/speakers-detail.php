<?php

require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
require_once(get_template_directory()."/functions/ergo-get-meta.php");
require_once(get_template_directory()."/functions/ergo_get_image_path_from_id.php");
require_once(get_template_directory()."/functions/ergo-include-image.php");
require_once(get_stylesheet_directory()."/functions/sessions-get-list.php");
require_once(get_template_directory()."/zephyr-functions/date-text-format.php");

$metaData 	= ergo_get_post_meta(get_the_id());
$session 		= sessions_get_list();

$speakerName = get_the_title();
//print_r($session);



//Find sessions with this user:
$speakerSessions = array();
echo "TODO: Apostrophes in names is currently causing an issue";
for ($i=0;$i<count($session);$i++){
	//echo "<Br />".format_for_url($session[$i]['session_speakers'])." -- ".format_for_url($speakerName);
	if (stristr(format_for_url($session[$i]['session_speakers']),format_for_url(($speakerName)))){
		$speakerSessions[count($speakerSessions)] = $i;
	}	
}


get_header(); ?>

<div class="contain-800 padding-mobile-850" style="min-height: 1000px;">
	<div class="p-t-150">
		
		<div class="p-b-25">
			<a href="<?php echo get_site_url(); ?>/speakers">< Return to Speakers</a>
		</div>
		
		<div class="columns-flex">
			
			<div class="col col-fluid">
				<div class="speaker-company"><?php echo $metaData['speaker_company']; ?></div>
				<h1 class="speaker-list-name"><?php echo $speakerName; ?></h1>
				<div class="speaker-title p-b-25"><?php echo $metaData['speaker_title']; ?></div>
				
				<div class="speaker-image" style="background-image:url(<?php echo ergo_get_image_path_from_id($metaData['speaker_image']); ?>);"></div>
				
				<div class="p-t-25 p-b-50">
					<?php echo $metaData['speaker_bio']; ?>
				</div>
				<h3 class="p-b-25">This Speaker's Sessions</h3><?php
				
				for ($i=0;$i<count($speakerSessions);$i++){
					$key = $speakerSessions[$i]; ?>
					<div class="speaker-detail-session-tile">
						<h4 class="p-b-15"><?php echo $session[$key]['session_title']; ?></h4>
						<div class=""><?php echo  text_format($session[$key]['session_date'],"M j, Y"); ?> | <?php echo text_format($session[$key]['session_date'].$session[$key]['session_time'],"g:i a"); ?></div>
						<div class="">
							<?php echo $session[$key]['session_description']; ?>
						</div>
					</div><?php
				}	?>
			</div>
		</div>
		<br /><br /><br />
	</div>
</div><?php

get_footer();

?>

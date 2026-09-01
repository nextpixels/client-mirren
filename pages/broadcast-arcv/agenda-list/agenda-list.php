<?php

require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
require_once(get_template_directory()."/zephyr-functions/date-text-format.php");
require_once(get_template_directory()."/functions/ergo-get-meta.php");
require_once(get_stylesheet_directory()."/mirren-elements/functions/sessions-get-list.php");
require_once(get_stylesheet_directory()."/functions/speakers-get-list.php");
require_once(get_stylesheet_directory()."/functions/speakers-render-speaker-tile.php");

//Get Sessions:
$session = sessions_get_list();

//print_r($session);

$dateBlocks = get_date_blocks($session);
$timeBlocks = get_date_time_blocks($session);

//Get Speakers List [TODO -- THIS IS STRAIGHT UP COPIED FROM SPEAKERS-LIST.PHP]:
	$speakers = speakers_get_list();
	$speakersByName = array();
	
	for ($i=0;$i<count($speakers);$i++){
		
		$key = format_for_url($speakers[$i]['name']);
		$speakersByName[$key]['name'] = $speakers[$i]['name'];
		$speakersByName[$key]['image'] = $speakers[$i]['image'];
		$speakersByName[$key]['speaker_company'] = $speakers[$i]['speaker_company'];
		$speakersByName[$key]['speaker_title'] = $speakers[$i]['speaker_title'];
		$speakersByName[$key]['url'] = $speakers[$i]['url'];
		$speakersByName[$key]['name_key'] = $key;
		$speakersByName[$key]['speaker_bio'] = nl2br($speakers[$i]['speaker_bio']);
		$speakersByName[$key]['supress_bio_popup'] = $speakers[$i]['suppress_bio_popup'];
	}
	
	
//Get page meta:
	$postMeta = ergo_get_post_meta(get_the_id());



//Tab to show:
	$showTab = get_query_var('tab');
	if (!$showTab){
		$showTab =  "20230516";
	}
?>

<script>
	var default_tab = "<?php echo $showTab; ?>";
	var agenda_data = [];<?php
	for ($i=0;$i<count($session);$i++){ ?>
		agenda_data[<?php echo $i; ?>] = [];
		agenda_data[<?php echo $i; ?>]['title'] = "<?php echo $session[$i]['session_title']; ?>";
		agenda_data[<?php echo $i; ?>]['description'] = "<?php echo $session[$i]['session_description']; ?>";<?php
	}	?>
	
	
	var speakersByName = <?php echo json_encode($speakersByName); ?>;
	var speakerSessions = <?php echo json_encode($speakerSessions); ?>;
	var sessions = <?php echo json_encode($session); ?>
</script>



<div id="session-detail" class="right-panel session-detail">
	<div class="p-b-25"><a href="#" id="" class="hide-click-off-link">Close</a></div>
	<div class="p-b-25"><h2 id="session-detail-title" class="h2-small"></h2></div>
	<div id="session-detail-description"></div>
</div>

<div id="speaker-detail" class="right-panel speaker-detail">
	<div class="p-b-15"><a href="#" id="speaker-detail-close" class="hide-click-off-link">Close</a></div>
	<div id="speaker-detail-company" class="speaker-detail-company p-t-25"></div>
	<div class="p-b-25">
		<div id="speaker-detail-name"></div>
		<div id="speaker-detail-title" class="speaker-detail-title"></div>
	</div>
	<div id="speaker-detail-image" class="speakers-detail-image"></div>
	<div class="p-b-10"></div>
	<div id="speaker-detail-description" class="p-b-50"></div>
	<?php /*
	<h3 class="p-b-15">This Speaker's Sessions</h3>
	<div id="speaker-detail-sessions"></div>
	*/ ?>
</div>

<div id="agenda-listing-grid" class="contain-standard p-mobile-standard" ><?php

	render_day_navigation($dateBlocks,$postMeta);	?>
	
	<div class="day-content-wrapper">
		<div class="day-content-wrapper-background"></div>
		<div class="day-content-wrapper-background-bottom"></div>
		<div class="day-content-wrapper-content"><?php
			for ($lpDay=0;$lpDay<count($dateBlocks);$lpDay++){ ?>
				<div id="day-<?php echo $dateBlocks[$lpDay]; ?>" class="day-content"><?php 
					render_track_headings($dateBlocks[$lpDay],$lpDay,$postMeta);
					render_day($session,$dateBlocks[$lpDay],$timeBlocks,$speakersByName);	?>
				</div><?php
			}	 ?>
		</div>
		
	</div>
	
	<div class="day-navigation-bottom"><?php
		render_day_navigation($dateBlocks,$postMeta);	?>
	</div>
	
</div><?php



function render_track_headings($day,$tabNum,$postMeta){ 

	$tracks = $postMeta['tab_tracks_'.($tabNum + 1)];	
	if ($tracks == 1){
		$colWidth = "12";
		$showTrackNum = false;
	}
	else{
		$colWidth = "4";
		$showTrackNum = true;
	}	?>
	
	<div class="columns-flex collapse-900 p-b-15"><?php 
	//echo "Tab: ".$tabNum;
	//echo "Tracks: ".$postMeta['tab_tracks_'.($tabNum + 1)];
			?>
		
		<div class="col col-150">&nbsp;</div>
		<div class="col col-fluid">
			<div class="columns-fluid collapse-800"><?php
				for ($i=0;$i<$tracks;$i++){ 
					$key = $i+1; ?>
					<div class="col-<?php echo $colWidth; ?> track-header track-header-<?php echo $key; ?>">
						<div class="track-header-content"><?php
							if ($showTrackNum == true){
								if ($i==0){
									$trackName = "Track One";
								}
								if ($i==1){
									$trackName = "Track Two";
								}
								if ($i==2){
									$trackName = "Track Three";
								}
							} ?>
							
							<h3>{{track-strapline-<?php echo $day; ?>-<?php echo $key; ?>}}</h3>
							<h4>{{track-title-<?php echo $day; ?>-<?php echo $key; ?>}}</h4>
							<div class="track-header-text">{{track-text-<?php echo $day; ?>-<?php echo $key; ?>}}</div>
						</div>
					</div><?php
				}	
				/*
				 ?>
			
				
				<div class="col-4 track-header track-header-1">
					<h3>Track One</h3>
					<h4>{{track-title-<?php echo $day; ?>-1}}</h4>
					<div class="track-header-text">{{track-text-<?php echo $day; ?>-1}}</div>
				</div>
				<div class="col-4 track-header track-header-2">
					<h3>Track Two</h3>
					<h4>{{track-title-<?php echo $day; ?>-2}}</h4>
					<div class="track-header-text">{{track-text-<?php echo $day; ?>-2}}</div>
				</div>
				<div class="col-4 track-header track-header-3">
						<h3>Track Three</h3>
					<h4>{{track-title-<?php echo $day; ?>-3}}</h4>
					<div class="track-header-text">{{track-text-<?php echo $day; ?>-3}}</div>
				</div>
				
				*/ ?>
			</div>
		</div>
	</div><?php
}


//Day Tabs
//{{day-title-<?php echo $dateBlocks[$i]; }}
function render_day_navigation($dateBlocks,$postMeta){ ?>
	<div class="day-navigation"><?php
		for ($i=0;$i<count($dateBlocks);$i++){
			$key = $i + 1; 	?>
			<a id="tab-<?php echo $dateBlocks[$i]; ?>" href="#" class="day-navigation-link tab-<?php echo strtolower($postMeta['tab_size_'.$key]); ?> tab-<?php echo $dateBlocks[$i]; ?>" style="display: inline-block" data-date="<?php echo $dateBlocks[$i]; ?>">
				<div class="day-navigation-tab-divet"></div>
				<h3><?php echo $postMeta['tab_title_'.$key]; ?></h3>
				<div class="day-navigation-date-wrapper">
					<?php
					if (!stristr($postMeta['hide_date_'.$key],"Hide Date")){ ?>
						<span class="day-navigation-date">
						<?php echo text_format($dateBlocks[$i],"M j, Y"); ?>
						</span><?php
					} ?>
			
				</div>
			
			</a><?php
		}	?>
	</div><?php
}


//Render Day
function render_day($session,$currentDay,$timeBlocks,$speakersByName){
	
	for ($i=0;$i<count($timeBlocks);$i++){ 
	
		if (substr($timeBlocks[$i],0,8) == $currentDay){		//If the current time block is part of the current day, show it:
			$sessionsCount = get_sessions_count_during_time_block($session,$timeBlocks,$i);	?>
			<div class="row-time row-time-<?php echo $timeBlocks[$i]; ?> row-items-<?php echo $sessionsCount; ?>">
				<div class="columns-flex collapse-900">
					<div class="col col-150">
						<div class="row-time-border-top"></div>
						<div class="row-time-time">
							<?php echo text_format($timeBlocks[$i],"g:i a"); ?> CT
						</div>
					</div>
					<div class="col col-fluid">
						<div class="columns-fluid"><?php
							$sessionNum = 1;
							for ($b=$i;$b<count($session);$b++){
								if ($session[$b]['session_timestamp'] == $timeBlocks[$i]){
									render_session_tile($session[$b],$speakersByName,$b);
									$sessionNum++;
								}
							}	?>
						</div>
					</div>
				</div>
				
			</div><?php
		
		}
	}
}


function has_virtual_session($data){
	if (stristr($data['has_virtual_session'],"Has Virtual Session")){
		return true;
	}
	return false;
}

//Render Session Tile
function render_session_tile($data,$speakersByName,$arrayId){  

	//print_r($data);
	
	if (stristr($data['is_keynote'],"Is Keynote")){
		$classAdd = "is-keynote";
	}
	?>
	<div class="session-tile track-<?php echo $data['session_track']; ?> <?php echo $data['class']; ?> <?php echo $classAdd; ?>">
		<div class="session-tile-header" style="position: relative;">
			<div class="session-tile-header-track hide-morethan-800">Track <?php echo $data['session_track']; ?></div>
			<h4><?php echo $data['session_title']; ?></h4>
			<div class="session-tile-header-footer columns-flex">
				<div class="col col-fluid"><?php
					if ($data['session_description']){ ?>
						<a href="#" class="session-detail-link" data-id="<?php echo $arrayId; ?>">See More</a><?php
					} ?>
				</div><?php
				if (has_virtual_session($data)){ ?>
					<div class="col col-50 vertical-center horizontal-right"><?php
					ergo_include_image(get_stylesheet_directory_uri()."/pages/agenda/agenda-list/icon-virtual-session.svg","",array('Class'=>'icon-session-virtual'));  ?>
					</div><?php
				} ?>
			</div>

			<!-- START: Broadcast Buttons -->
			<div class="buttons-box" style="">
				<?php if( get_field('live_meeting_session_button_link', $data['post_id']) ): ?>
		   		<div class="button-wrap">
		      		<a class="btn btn-primary" href="<?php the_field('live_meeting_session_button_link', $data['post_id']); ?>" target="_blank"><?php the_field('live_meeting_session_button_text', $data['post_id']); ?></a>
		   			<?php if( get_field('live_meeting_session_text', $data['post_id']) ): ?>
		   			<p class="link-description text-live-meeting"><?php the_field('live_meeting_session_text', $data['post_id']); ?></p>
		  			<?php endif; ?>
				</div>

		   		<?php else: ?>
		   		<div class="button-wrap button-wrap-disabled">
		      		<a class="btn btn-primary button-disabled" disabled href=""><?php the_field('live_meeting_session_button_text', $data['post_id']); ?></a>
		    		<?php if( get_field('live_meeting_session_text', $data['post_id']) ): ?>
		   			<p class="link-description text-live-meeting"><?php the_field('live_meeting_session_text', $data['post_id']); ?></p>
		   			<?php endif; ?>
				</div>
		   		<?php endif; ?>
		   

		   		<?php if( get_field('recorded_meeting_session_button_link', $data['post_id']) ): ?>
		   		<div class="button-wrap">
		      		<a class="btn btn-primary" href="<?php the_field('recorded_meeting_session_button_link', $data['post_id']); ?>" target="_blank">Watch Recording</a>
					<?php if( get_field('recorded_meeting_session_text', $data['post_id']) ): ?>
		   			<p class="link-description"><?php the_field('recorded_meeting_session_text', $data['post_id']); ?></p>
		   			<?php endif; ?>
		   		</div>
		   		<?php else: ?>

		   		<div class="button-wrap button-wrap-disabled">
		      		<a class="btn btn-primary button-disabled" disabled href="" target="_blank">Watch Recording</a>
					<?php if( get_field('recorded_meeting_session_text', $data['post_id']) ): ?>
		   			<p class="link-description"><?php the_field('recorded_meeting_session_text', $data['post_id']); ?></p>
		   			<?php endif; ?>
				</div>
		   		<?php endif; ?>
			</div>
			<!-- END: Broadcast Buttons -->
			
		</div><?php

		if ($data['is_keynote'] && !$data['session_speakers']){
			//If it's a keynote (aka full width), and there aren't speakers, don't show the body of the tile.
		}
		else{	?>
			<div class="session-tile-body" style="min-height: 100px;"><?php 
				render_session_speakers($data,$speakersByName); ?>
			</div><?php
		} ?>
	</div><?php
}


function render_session_speakers($data,$speakersByName){
	$speakersList = explode("\n",$data['session_speakers']);
	
	for ($i=0;$i<count($speakersList);$i++){
		$key = format_for_url($speakersList[$i]);
		$speakersByName[$key]['url'] = "#";
		//name_key
		speakers_render_speaker_tile($speakersByName[$key],$data['session_moderator']);
	}
}


//Count how many sessions there are in a timeBlocks
function get_sessions_count_during_time_block($session,$timeBlocks,$i){
	$items = 0;
	for ($b=$i;$b<count($session);$b++){
		if ($session[$b]['session_timestamp'] == $timeBlocks[$i]){
			$items++;
		}
	}
	return $items;
}


//Create a list of dates:
function get_date_blocks($session){
	$dateblocks = array();
	$key = 0;
	for ($i=0;$i<count($session);$i++){
		if (date_is_different($session,$i)){ 
			$dateblocks[$key] = $session[$i]['session_date'];
			$key++;
		}
	}
	
	return $dateblocks;
}


//Create a list of times:
function get_date_time_blocks($session){
	$datetimeblocks = array();
	$key = 0;
	for ($i=0;$i<count($session);$i++){
		if (date_or_time_is_different($session,$i)){ 
			$datetimeblocks[$key] = $session[$i]['session_date'].$session[$i]['session_time'];
			$key++;
		}
	}
	
	return $datetimeblocks;
}


//Returns true if this session is at a different date than the previous
function date_is_different($session,$i){
	if ($session[$i]['session_date'] != $session[$i-1]['session_date']){
		return true;
	}
	return false;
}


//Returns true if this session is at a different time or date than the previous
function date_or_time_is_different($session,$i){
	if ($session[$i]['session_date'].$session[$i]['session_time'] != $session[$i-1]['session_date'].$session[$i-1]['session_time']){
		return true;
	}
	return false;
}

//Just returns true if there is a previous record (should be false for the first record)
function previous_record($session,$i){
	if ($session[$i-1]['session_date']){
		return true;
	}
	return false;
}

?>
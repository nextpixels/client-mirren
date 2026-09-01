<?php
/*
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
*/


/*
//Settings (Place in _settings.php):
//Allow Tracks to Be Expandable/Collapsable on Mobile?  $togglableTracksOnMobile

$mobileAgendaFormat = "by-track", "by-time"				//by-track will group all sessions into tracks first, then times.  If by-time, things are grouped first by time, then each track within that time block


*/

if (empty($mobileAgendaFormat)){
	$mobileAgendaFormat == "by-track";
}

require(get_stylesheet_directory()."/_settings.php");

require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
require_once(get_template_directory()."/zephyr-functions/date-text-format.php");
require_once(get_template_directory()."/zephyr-functions/url-get-final-segment.php");
require_once(get_template_directory()."/functions/ergo-get-meta.php");
require_once(get_stylesheet_directory()."/mirren-elements/functions/sessions-get-list.php");
require_once(get_stylesheet_directory()."/functions/speakers-get-list.php");
require_once(get_stylesheet_directory()."/functions/speakers-render-speaker-tile.php");
require_once(get_template_directory()."/functions/ergo-include-script.php");
require_once(get_template_directory()."/functions/ergo-includestylesheet.php");

//Script for accordion functionality (mobile)
ergo_include_script(get_template_directory()."/acf-blocks/text-accordion/text-accordion.min.js");
ergo_include_stylesheet(get_template_directory()."/acf-blocks/text-accordion/text-accordion.min.css");

//Get Sessions:
$session = sessions_get_list();
$sessionData = $session;

//print_r($session);

$dateBlocks = get_date_blocks($session);
$timeBlocks = get_date_time_blocks($session);

//Get Speakers List [TODO -- THIS IS STRAIGHT UP COPIED FROM SPEAKERS-LIST.PHP]:
	$speakers = speakers_get_list();
	$speakersByName = array();
	
	if (is_array($speakers)){
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
	}
	
	
//Get page meta:
	$postMeta = ergo_get_post_meta(get_the_id());
	
//Tab to show:
	$showTab = get_query_var('tab');
	if (!$showTab){
		$showTab =  get_field('default_tab');
	}
	if (!$showTab){
		$showTab =  $dateBlocks[0];
	}
	
	//If it's the current day of a tab, just show that one:
		if (!get_query_var('tab')){
			if (is_array($dateBlocks) && in_array(date("Ymd"),$dateBlocks)){
				$showTab = date("Ymd");
			}
		}

//Timezone:
	if(!$timeZone){
		$timeZone = "ET";
	}
	
//echo "Final Segment: ".url_get_final_segment();	
	
//Allow Tracks to Be Expandable/Collapsable on Mobile?
	if(!$togglableTracksOnMobile){
		$togglableTracksOnMobile = false;
	} ?>

<script>
	var default_tab = "<?php echo $showTab; ?>";
	var agenda_data = [];<?php
	if (is_array($session)){
		for ($i=0;$i<count($session);$i++){ ?>
			agenda_data[<?php echo $i; ?>] = [];
			agenda_data[<?php echo $i; ?>]['title'] = "<?php echo $session[$i]['session_title']; ?>";<?php
			
			//$description 		= str_replace("&quot;","\&quot;",$session[$i]['session_description']); 
			//$description 		= html_entity_decode($description);?>
			
			agenda_data[<?php echo $i; ?>]['description'] = "<?php echo $session[$i]['session_description']; ?>";<?php
		}
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
	
	//Mobile View 	?>
		<div class="agenda-mobile hide-morethan-900"><?php
			if (is_array($dateBlocks)){
				for ($lpDay=0;$lpDay<count($dateBlocks);$lpDay++){ 
				
					$caretUrl = get_template_directory_uri()."/acf-blocks/text-accordion/caret.svg";	
					$caretUrl = get_stylesheet_directory_uri()."/mirren-elements/agenda-list/caret-plus.svg";
					$caretUrlOpen = get_stylesheet_directory_uri()."/mirren-elements/agenda-list/caret-minus.svg"; ?>
					
					<?php /*
					//If keeping day content closed by default:
					<div id="accordion-<?php echo $lpDay; ?>" class="text-accordion text-accordion-group-daylist open" style="margin-top: 25px;"> */ ?>
					<div id="accordion-<?php echo $lpDay; ?>" class="text-accordion text-accordion-group-daylist open" style="margin-top: 25px;">
						<div class="day-title-mobile agenda-mobile-date text-accordion-title js-text-accordion-title" data-closeopen="true" style="position: relative;">

							<div class="" style="width: 30px; position: absolute;">
								<div style="text-align: center; width: 26px; height: 30px; display: flex; align-items: center;">
									<div style="width: 15px; height: 15px; margin: 0 auto;">
										<img class="caret caret-closed" src="<?php echo $caretUrl; ?>" alt="" style="width: 15px; height: 15px;" />
										<img class="caret caret-open" src="<?php echo $caretUrlOpen; ?>" alt="" style="width: 15px; height: 15px;" />
									</div>
								</div>
							</div>
							
							<div class="day-header-mobile-<?php echo $dateBlocks[$lpDay]; ?>" style="padding-left: 30px;">
								<span class="day-header-mobile-title" style="display: inline-block; margin-right: 6px; padding-top: 0; padding-bottom: 0;">{{mobile-agenda-day-<?php echo $lpDay; ?>}}</span>
								<span class="day-header-mobile-date" style="padding-top: 0;"><?php echo text_format($dateBlocks[$lpDay],"M j"); ?></span>
							</div>
						</div>
						<?php /* 
						//If keeping day content closed by default:
						<div class="day-body-mobile text-accordion-body" style="display: none;"> */ ?>
						<div class="day-body-mobile text-accordion-body"><?PHP
						
							if ($mobileAgendaFormat == "by-time"){
								mobile_render_sessions_by_time(array(
									'Day' => $dateBlocks[$lpDay],
									'TabNum' => $lpDay,
									'Sessions' => $session,
									'SpeakersByName' => $speakersByName,
									'Timezone' => $timeZone,
									'TogglableTracks' => $togglableTracksOnMobile
								),$postMeta,$timeBlocks,$sessionData);
							}
							else{

								render_sessions_by_track(array(
									'Day' => $dateBlocks[$lpDay],
									'TabNum' => $lpDay,
									'Sessions' => $session,
									'SpeakersByName' => $speakersByName,
									'Timezone' => $timeZone,
									'TogglableTracks' => $togglableTracksOnMobile
								),$postMeta,$timeBlocks,$sessionData);
							}
							?>
							
						</div>
					</div><?php
				}	
			}
			else{ ?>
				No Sessions Found<?php
			}
			?>
		</div><?php
	//End Mobile View

	
	//Desktop View	

		render_day_navigation($dateBlocks,$postMeta);	?>
		
		<div class="day-content-wrapper hide-lessthan-900">
			<div class="day-content-wrapper-background"></div>
			<div class="day-content-wrapper-background-bottom"></div>
			<div class="day-content-wrapper-content"><?php
				if (count($dateBlocks) == 0){ ?>
					No Sessions Found<?php	
				}
				else{
					for ($lpDay=0;$lpDay<count($dateBlocks);$lpDay++){ ?>
						<div id="day-<?php echo $dateBlocks[$lpDay]; ?>" class="day-content day-content-tab-<?php echo $lpDay; ?>"><?php
							
							//Desktop View ?>
								<div><?php
									render_track_headings($dateBlocks[$lpDay],$lpDay,$postMeta);
									render_day($session,$dateBlocks[$lpDay],$timeBlocks,$speakersByName,$sessionData,array('Timezone'=>$timeZone));	?>
								</div>
								
						</div><?php
					}
				}				?>
			</div>
			
		</div>
	
		<div class="day-navigation-bottom"><?php
			render_day_navigation($dateBlocks,$postMeta);	?>
		</div><?php
	//End Desktop View ?>
	
</div><?php

function track_has_sessions($currentTrack,$timeBlocks,$options){
	
	//Loop through all time blocks:
		for ($b=0;$b<count($timeBlocks);$b++){ 
			
			if (substr($timeBlocks[$b],0,8) == $options['Day']){
				
				//If the current day matches a time block:
				//Loop through all sessions, if there is a match for a session (the session is on that day)
					for ($c=0;$c<count($options['Sessions']);$c++){
						if ($options['Sessions'][$c]['session_timestamp'] == $timeBlocks[$b]){
							
							//If a session matches the day/track, the target track has sessions, so show it:
								if ($options['Sessions'][$c]['session_track'] == $currentTrack){
									return true;
								}
						}
					}
			}
		}
	return false;
}

function mobile_render_sessions_by_time($options=array(),$postMeta,$timeBlocks,$sessionData){
	
	for ($b=0;$b<count($timeBlocks);$b++){
		
			if (substr($timeBlocks[$b],0,8) == $options['Day']){
				//echo "<br /><br />".$timeBlocks[$b];
				
				
				
				
				
				
				//Loop through all sessions.  If it matches the track number, show the session tile:
										$sessionNum = 1;
										for ($c=0;$c<count($options['Sessions']);$c++){
											
											if ($options['Sessions'][$c]['session_timestamp'] == $timeBlocks[$b]){
												//echo "<br />Title: ".$options['Sessions'][$c]['session_title'];
												//if ($options['Sessions'][$c]['session_track'] == $i+1 || $options['Sessions'][$c]['is_keynote']){
												
													//Show the time: 
														
													?>
														<div class="track-body-mobile-time track-body-mobile-time-<?php echo $timeBlocks[$b]; ?> p-t-15 p-b-5"><?php
															echo text_format($timeBlocks[$b],"g:i a")." ".$options['Timezone']; ?>
														</div><?php
														
													//Display the Tile:
														
														render_session_tile($options['Sessions'][$c],$options['SpeakersByName'],$c,$sessionData);
												//}
												
												$sessionNum++;
											}
										}
				
				
				
				
				
				
			}
	}
	//print_r($sessionData);
}

function render_sessions_by_track($options=array(),$postMeta,$timeBlocks,$sessionData){ 
	
	$tracks = 3;
	$caretUrl = get_template_directory_uri()."/acf-blocks/text-accordion/caret.svg";	
	$caretUrl = get_stylesheet_directory_uri()."/mirren-elements/agenda-list/caret-plus.svg";
	$caretUrlOpen = get_stylesheet_directory_uri()."/mirren-elements/agenda-list/caret-minus.svg";	
	
	if ($options['TogglableTracks'] == true){ 
		$trackBodyClass = "text-accordion-body";
		$trackBodyStyle = "display: none; padding-left: 35px;";
		$groupClass = "allow-toggling";
	} ?>
	
	<div id="group-<?php echo $options['Day']; ?>" class="sessions-by-track text-accordion-group <?php echo $groupClass; ?>"><?php
	
		for ($i=0;$i<$tracks;$i++){ 

			//Are there sessions for this date/track
			$showTrack = track_has_sessions(($i+1),$timeBlocks,$options);
		
			if ($showTrack){ ?>

				<div id="<?php echo $options['Day']; ?>-<?php echo $i; ?>" class="text-accordion text-accordion-group-<?php echo $options['Day']; ?> closed" style="margin-bottom: 12px;">
					<div id="title-<?php echo $options['Day']; ?>-<?php echo $i; ?>" class="track-title-mobile js-text-accordion-title" data-closeopen="true" style="position: relative; display: flex; align-items: center;">
					
						<?php
						if ($options['TogglableTracks'] == true){ ?>
							<div class="" style="width: 25px;">
								<div style="text-align: center; width: 25px;">
									<div style="width: 15px; height: 15px; margin: 0 auto;">
										<img class="caret caret-closed" src="<?php echo $caretUrl; ?>" alt="" style="width: 15px; height: 15px;" />
										<img class="caret caret-open" src="<?php echo $caretUrlOpen; ?>" alt="" style="width: 15px; height: 15px;" />
									</div>
								</div>
							</div><?php
						} ?>

						<div class="track-title-mobile-content"><?php							
							$trackLabel[0] = "{{day-".$options['Day']."-track-1-label}}";
							$trackLabel[1] = "{{day-".$options['Day']."-track-2-label}}";
							$trackLabel[2] = "{{day-".$options['Day']."-track-3-label}}"; 
							
							if (isset($trackLabel[$i]) && trim($trackLabel[$i]) != "" && strlen(trim($trackLabel[$i])) > 0){ ?>
								<div class="strapline"><?php echo $trackLabel[$i]; ?></div><?php
							} ?>
							<div class="track-header-text"><h4>{{track-title-<?php echo $options['Day']; ?>-<?php echo $i+1; ?>}}</h4></div>
						</div>
					</div>
				
					<div class="track-body track-body-mobile <?php echo $trackBodyClass; ?>" style="<?php echo $trackBodyStyle; ?>;">
						<div class="track-header-text p-b-15">{{track-text-<?php echo $options['Day']; ?>-<?php echo $i+1; ?>}}</div>
						
						<div class=""><?php
							for ($b=0;$b<count($timeBlocks);$b++){ 
								if (substr($timeBlocks[$b],0,8) == $options['Day']){

										//Loop through all sessions.  If it matches the track number, show the session tile:
										$sessionNum = 1;
										for ($c=0;$c<count($options['Sessions']);$c++){
											
											if ($options['Sessions'][$c]['session_timestamp'] == $timeBlocks[$b]){
												
												if ($options['Sessions'][$c]['session_track'] == $i+1 || $options['Sessions'][$c]['is_keynote']){
												
													//Show the time: ?>
														<div class="track-body-mobile-time track-body-mobile-time-<?php echo $timeBlocks[$b]; ?> p-t-15 p-b-5"><?php
															echo text_format($timeBlocks[$b],"g:i a")." ".$options['Timezone']; ?>
														</div><?php
														
													//Display the Tile:
														
														render_session_tile($options['Sessions'][$c],$options['SpeakersByName'],$c,$sessionData);
												}
												
												$sessionNum++;
											}
										}
								}
							}	?>
						</div>
					</div>
				</div>
				
			<?php
		}
		}	?>
		
	</div><?php
}


function render_track_headings($day,$tabNum,$postMeta){ 

	$tracks = $postMeta['tab_tracks_'.($tabNum + 1)];	
	if ($tracks == 1){
		$colWidth = "12";
		$showTrackNum = false;
	}
	elseif ($tracks == 2){
		$colWidth = "6";
		$showTrackNum = true;
	}
	else{
		$colWidth = "4";
		$showTrackNum = true;
	}	?>
	
	<div class="columns-flex collapse-900 p-b-15">		
		<div class="col col-150">&nbsp;</div>
		<div class="col col-fluid">
			<div class="columns-fluid collapse-800"><?php
				for ($i=0;$i<$tracks;$i++){ 
					$key = $i+1; 

					render_track_heading(array(
						"ColumnNum" => $i+1,
						"ColumnWidth" => $colWidth,
						"ShowTrackNum" => $showTrackNum,
						"Day" => $day				
					));
					
				}	 ?>
			</div>
		</div>
	</div><?php
}

function render_track_heading($data=array()){ ?>
	<div class="col-<?php echo $data['ColumnWidth']; ?> track-header track-header-<?php echo $data['ColumnNum']; ?>">
		<div class="track-header-content"><?php
			if ($data['ShowTrackNum'] == true){
				if ($data['ColumnNum'] == 1){
					$trackName = "Track One";
				}
				if ($data['ColumnNum'] == 2){
					$trackName = "Track Two";
				}
				if ($data['ColumnNum'] == 3){
					$trackName = "Track Three";
				}
			} ?>
			
			<h3>{{track-strapline-<?php echo $data['Day']; ?>-<?php echo $data['ColumnNum']; ?>}}</h3>
			<h4>{{track-title-<?php echo $data['Day']; ?>-<?php echo $data['ColumnNum']; ?>}}</h4>
			<div class="track-header-text">{{track-text-<?php echo $data['Day']; ?>-<?php echo $data['ColumnNum']; ?>}}</div>
		</div>
	</div><?php
}


//Day Tabs
//{{day-title-<?php echo $dateBlocks[$i]; }}
function render_day_navigation($dateBlocks,$postMeta){ ?>

	<div class="day-navigation-wrapper">
		<div class="contain-1100 hide-lessthan-900" style="position: relative; z-index: 100;">
			<div class="virtual-key">
				<img class="icon-virtual-key" src="<?php echo get_stylesheet_directory_uri(); ?>/mirren-elements/agenda-list/icon-virtual-session.svg" alt="" style="" loading="lazy">Virtual Speaker
				<div class="virtual-key-popup">
					Indicates speaker will be presenting remotely
				</div>
			</div>
		</div>
		
		<div class="day-navigation hide-lessthan-900 days-<?php echo count($dateBlocks); ?>"><?php
			for ($i=0;$i<count($dateBlocks);$i++){
				$key = $i + 1; 	?>
				<a id="tab-<?php echo $dateBlocks[$i]; ?>" href="#" class="day-navigation-link tab-<?php echo strtolower($postMeta['tab_size_'.$key]); ?> tab-<?php echo $dateBlocks[$i]; ?>" data-date="<?php echo $dateBlocks[$i]; ?>">
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
			} ?>
		</div>
	</div><?php
	
}


//Render Day
function render_day($session,$currentDay,$timeBlocks,$speakersByName,$sessionData,$options=array()){
	
	for ($i=0;$i<count($timeBlocks);$i++){ 
	
		if (substr($timeBlocks[$i],0,8) == $currentDay){		//If the current time block is part of the current day, show it:
			$sessionsCount = get_sessions_count_during_time_block($session,$timeBlocks,$i);	
			
			//Show the time block (checking to see if there are non-grouped sessions for the timeblock.  If so, show it.  If there are only
			//grouped sessions, don't show the time block since these get shown in the parent time block:
				$showTimeBlock = false;
				for ($b=$i;$b<count($session);$b++){
					if ($session[$b]['session_timestamp'] == $timeBlocks[$i]){
						if (!$session[$b]['session_group']){
							$showTimeBlock = true;
						}
					}
				}
			
			if ($showTimeBlock == true){	?>
				<div class="row-time row-time-<?php echo $timeBlocks[$i]; ?> row-items-<?php echo $sessionsCount; ?>">
					<div class="columns-flex collapse-900">
						<div class="col col-150">
							<div class="row-time-border-top"></div>
							<div class="row-time-time">
								<?php echo text_format($timeBlocks[$i],"g:i a"); ?> <?php echo $options['Timezone']; ?>
							</div>
						</div>
						<div class="col col-fluid">
							<div class="columns-fluid"><?php
								$sessionNum = 1;
								for ($b=$i;$b<count($session);$b++){
									if ($session[$b]['session_timestamp'] == $timeBlocks[$i]){
										if (!$session[$b]['session_group']){	//Don't show it if it's a "grouped child session"
											render_session_tile($session[$b],$speakersByName,$b,$sessionData);
											$sessionNum++;
										}
									}
								}	?>
							</div>
						</div>
					</div>
				</div><?php
			}
		
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
function render_session_tile($data,$speakersByName,$arrayId,$sessionData,$options=array()){  
	
	if (stristr($data['is_keynote'],"Is Keynote")){
		$classAdd = "is-keynote";
	}	
	
	$sessionTileClass = "";
	if (isset($data['pre-title']) && $data['pre-title'] != ""){
		$sessionTileClass = "has-pretitle";
	} ?>
	
	<div class="session-tile track-<?php echo $data['session_track']; ?> <?php echo $data['class']; ?> <?php echo $sessionTileClass; ?> tile-time-<?php echo $data['session_date'].$data['session_time']; ?> <?php echo $classAdd; ?>">
		
		<div class="session-tile-header " style="position: relative;"><?PHP
		
			if (isset($data['pre-title']) && $data['pre-title'] != ""){ ?>
				<div class="section-tile-preheader"><?php echo $data['pre-title']; ?></div><?php
			} ?>
			
			<div class="session-tile-header-padding">
				<div class="session-tile-header-track hide-morethan-800">Track <?php echo $data['session_track']; ?></div><?php
				
				if ($options['ShowTime'] == true){ ?>
					<div class="session-tile-header-time"><?php
						echo text_format($data['session_date'].$data['session_time'],"g:i a"); ?> <?php echo $options['Timezone']; ?>
					</div><?php
				} ?>
				
				<h4><?php echo $data['session_title']; ?></h4>
				<div class="session-tile-header-footer columns-flex">
					<div class="col col-fluid"><?php
						if ($data['session_description']){ ?>
							<a href="#" class="session-detail-link" data-id="<?php echo $arrayId; ?>">See More</a><?php
						} ?>
					</div><?php
					if (has_virtual_session($data)){ ?>
						<div class="col col-50 vertical-center horizontal-right"><?php
						ergo_include_image(get_stylesheet_directory_uri()."/mirren-elements/agenda-list/icon-virtual-session.svg","",array('Class'=>'icon-session-virtual'));  ?>
						</div><?php
					} ?>
				</div><?php
				
				render_broadcast_buttons($data); ?>
			</div>
		</div><?php

		if ($data['is_keynote'] && !$data['session_speakers']){
			//If it's a keynote (aka full width), and there aren't speakers, don't show the body of the tile.
		}
		else{ ?>
			<div class="session-tile-body"><?php
			
				//Only show the speakers box if there are speakers:
					$speakersList = explode("\n",$data['session_speakers']);
					$hasSpeakers = false;
					for ($i=0;$i<count($speakersList);$i++){
						$key = format_for_url($speakersList[$i]);
						$speakersByName[$key]['url'] = "#";
						if (isset($key) && $key != ""){
							$hasSpeakers = true;
						}							
					}				

					if ($hasSpeakers == true){ ?>
						<div class="session-tile-body-padding"><?php 
							render_session_speakers($data,$speakersByName); ?>
						</div><?PHP
					}	?>
				
				<div><?php
					//Any grouped sessions?
						$currentSessionDateTime = substr($data['session_date'].$data['session_time'],0,12);
						for ($lpGrouped = 0;$lpGrouped<count($sessionData);$lpGrouped++){
							
							//If we match the current time block, and if we're in the same track, show the child session:
							if ($sessionData[$lpGrouped]['session_group'] == $currentSessionDateTime && $data['session_track'] == $sessionData[$lpGrouped]['session_track']){ ?>
								<div><?php
									render_session_tile($sessionData[$lpGrouped],$speakersByName,$lpGrouped,$sessionData,array('ShowTime'=>true)); ?>
								</div><?php
							}
							
						} ?>
				</div>
		
			</div><?php
		} 
		
		?>
<?php
		
		?>
	</div><?php
}


function render_broadcast_buttons($data){ ?>
				<!-- START: Broadcast Buttons --><?php 
			
			if (url_get_final_segment() == "broadcast"){ ?>
				
				<?php if( get_field('display_broadcast_buttons', $data['post_id']) ): ?>
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
					<div class="button-wrap button-wrap-watch-recording">
						<a class="btn btn-primary" href="<?php the_field('recorded_meeting_session_button_link', $data['post_id']); ?>" target="_blank">Watch Recording</a>
						<?php if( get_field('recorded_meeting_session_text', $data['post_id']) ): ?>
						<p class="link-description"><?php the_field('recorded_meeting_session_text', $data['post_id']); ?></p>
						<?php endif; ?>
					</div>
					<?php else: ?>

					<div class="button-wrap button-wrap-watch-recording button-wrap-disabled">
						<a class="btn btn-primary button-disabled" disabled href="" target="_blank">Watch Recording</a>
						<?php if( get_field('recorded_meeting_session_text', $data['post_id']) ): ?>
						<p class="link-description"><?php the_field('recorded_meeting_session_text', $data['post_id']); ?></p>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?><?php
				
			}	?>
			<!-- END: Broadcast Buttons --><?php
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
	if (is_array($session)){
		for ($i=0;$i<count($session);$i++){
			if (date_is_different($session,$i)){ 
				$dateblocks[$key] = $session[$i]['session_date'];
				$key++;
			}
		}
	}
	return $dateblocks;
}


//Create a list of times:
function get_date_time_blocks($session){
	$datetimeblocks = array();
	$key = 0;
	if (is_array($session)){
		for ($i=0;$i<count($session);$i++){
			if (date_or_time_is_different($session,$i)){ 
				$datetimeblocks[$key] = $session[$i]['session_date'].$session[$i]['session_time'];
				$key++;
			}
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
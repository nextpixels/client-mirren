<?php

require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php");
require_once(get_stylesheet_directory()."/functions/speakers-render-speaker-tile.php");

function render_broadcast_buttons($data){ 

	if (url_get_final_segment() == "broadcast"){ 

		$joinMeetingLabel 						= get_field('join_button_label');	//"Join Now";	//get_field('live_meeting_session_button_text', $data['post_id']);
		$joinMeetingText_Default 			= get_field('join_button_default_text');
		$joinMeetingText 						= get_field('live_meeting_session_text', $data['post_id']);

		$watchRecordingLabel					= get_field('watch_recording_button_label');	//"Watch&nbsp;Recording";
		$watchRecordingText_Default	= get_field('watch_recording_default_text');	//"All Access Pass: See login email for recording password.";
		$watchRecordingText					= get_field('recorded_meeting_session_text', $data['post_id']); 

		$displayButtons = get_field('display_broadcast_buttons',$data['post_id']);
		
		//print_r($displayButtons);
		
		?>
		
		<div class="buttons-box"><?php 
			if ($displayButtons != "no"){
				//Join Now Buttons (enabled/disabled);
					if( get_field('live_meeting_session_button_link', $data['post_id']) ){ ?>
						<div class="button-wrap">
							<a class="btn btn-primary" href="<?php the_field('live_meeting_session_button_link', $data['post_id']); ?>" target="_blank"><?php echo $joinMeetingLabel; ?></a><?php 
							render_broadcast_buttons_join_text($joinMeetingText,$joinMeetingText_Default); ?>
						</div><?php
					}
					//Disabled:
					else{ ?>
						<div class="button-wrap button-wrap-disabled">
							<a class="btn btn-primary button-disabled" disabled href=""><?php echo $joinMeetingLabel; ?></a><?php 
							render_broadcast_buttons_join_text($joinMeetingText,$joinMeetingText_Default); ?>
						</div><?php
					} 

				//Watch Recording Buttons
					if( get_field('recorded_meeting_session_button_link', $data['post_id']) ){ ?>
						<div class="button-wrap button-wrap-watch-recording">
							<a class="btn btn-primary" href="<?php the_field('recorded_meeting_session_button_link', $data['post_id']); ?>" target="_blank"><?php echo $watchRecordingLabel; ?></a><?php
							render_broadcast_buttons_recording_text($watchRecordingText,$watchRecordingText_Default); ?>
						</div><?php
					}
					else{ ?>
						<div class="button-wrap button-wrap-watch-recording button-wrap-disabled">
							<a class="btn btn-primary button-disabled" disabled href="" target="_blank"><?php echo $watchRecordingLabel; ?></a><?php
							render_broadcast_buttons_recording_text($watchRecordingText,$watchRecordingText_Default); ?>
						</div><?php 
					} 
			} ?>
		</div><?php

	}	
}

function render_broadcast_buttons_recording_text($watchRecordingText,$watchRecordingText_Default){
	if(!empty($watchRecordingText_Default)){ ?>
		<p class="link-description"><?php echo $watchRecordingText_Default; ?></p><?php 
	}
	if(!empty($watchRecordingText)){ ?>
		<p class="link-description"><?php echo $watchRecordingText; ?></p><?php 
	}
}

function render_broadcast_buttons_join_text($joinMeetingText,$joinMeetingText_Default){
	if(!empty($joinMeetingText_Default)){ ?>
		<p class="link-description text-live-meeting"><?php echo $joinMeetingText_Default; ?></p><?php 
	}
	if(!empty($joinMeetingText)){ ?>
		<p class="link-description text-live-meeting"><?php echo $joinMeetingText; ?></p><?php 
	}
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
							<a href="#" class="session-detail-link" data-id="<?php echo $arrayId; ?>"><span class="non-hideable">Explore </span><span class="hideable">Session</span></a><?php
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
			
				if (!empty($data['room'])){ ?>
					<div style="padding: 12px 4px 12px 12px; font-size: .9rem;"><?php
						echo "Room: ".$data['room']; ?>
					</div><?php
				}

				if (!empty($data['image-body'])){

					$imageUrl = wp_get_attachment_image_url($data['image-body'], 'full');
					
					?>
					<img src="<?php echo $imageUrl; ?>" style="max-width: 100%; float: left;" />
					<?php
				}
			
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
	</div><?php
}



function agenda_list_render_master_of_ceremonies(){
	global $post;
	
	if ($post->post_name == "broadcast"){
		
			$speaker_ids = array(); // initialize empty array
			if ( have_rows('master_of_ceremonies') ) {
				while ( have_rows('master_of_ceremonies') ) {
					the_row();
					$speaker_id = get_sub_field('speaker_id');

					if ( $speaker_id ) {
						$speaker_ids[] = $speaker_id; // add to array
					}
				}
			}
			
			if (count($speaker_ids) > 0){
			
			$args = array(
				'post_type' => 'speakers',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'post__in' => $speaker_ids,
				'orderby' => 'post__in'
			);
			
			$mcData = ergo_get_posts_from_args($args);	?>
			
			<div class="columns-flex collapse-900 p-b-15">		
				<div class="col col-150">&nbsp;</div>
				<div class="col col-fluid">
					<div class="columns-fluid collapse-800">
			
							<div class="master-of-ceremonies">
								<div class="master-of-ceremonies-title">
									<h4>Master of Ceremonies</h4>
								</div>
								
								<div class="session-tile-body">
									<div class="session-tile-body-padding columns-grid columns-grid-4"><?php
									
										foreach($mcData as $speaker){
											$speakerData['name'] = $speaker['Title'];
											$speakerData['image'] = wp_get_attachment_url($speaker['Meta']['speaker_image']);
											$speakerData['speaker_company'] = $speaker['Meta']['speaker_company'];
											$speakerData['speaker_title'] = $speaker['Meta']['speaker_title'];
											$speakerData['url'] = $speaker['Url'];
											$speakerData['name_key'] =  $speaker['Slug']; ?>
											
											<div class="col"><?php
												speakers_render_speaker_tile($speakerData); ?>
											</div><?php
											
										} ?>
									</div>
								</div>
							</div>
							
					</div>
				</div>
			</div><?php
		}
	}
}
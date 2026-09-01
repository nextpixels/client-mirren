<?php

//NOTE -- GONNA BE A PROBLEM IF 2 SPEAKEARS HAVE THE SAME NAME

require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
require_once(get_template_directory()."/functions/ergo-get-meta.php");
require_once(get_stylesheet_directory()."/functions/speakers-get-list.php");
require_once(get_stylesheet_directory()."/mirren-elements/functions/sessions-get-list.php");

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
		}
	}

//Get the speakers sessions:
	$speakerSessions = array();
	

	
	$session = sessions_get_list();
	
	//echo "Sessions: ";
	if (is_array($session)){
		for ($i=0;$i<count($session);$i++){
			//echo "<br />".$i;
			//echo $session[$i]['session_description'];
			//echo "<br />";
		//	$description 		= str_replace("&quot;","\&quot;",$session[$i]['session_description']); 
		//	$description 		= html_entity_decode($description);
			
		//	$session[$i]['session_description'] = $description;
			//Fix so this doesn't cause javascript errors:
			
				
						//echo "<br /><br />".$session[$i]['session_description'];
						//echo $session[$i]['session_description'];
		}
	}
	
	if (is_array($session)){
		for ($i=0;$i<count($session);$i++){
			
			$tmp = explode("\n",$session[$i]['session_speakers']);
			
			for ($b=0;$b<count($tmp);$b++){
				$speaker = format_for_url($tmp[$b]);
				if (is_array($speakerSessions[$speaker])){
					$key = count($speakerSessions[$speaker]);
				}
				else{
					$key = 0;
				}
				$speakerSessions[$speaker][$key] = $i;
			}
			
		}
	}

$metaData = ergo_get_post_meta(get_the_id());

$current_user = wp_get_current_user();

?>

<script>
	var speakersByName = <?php echo json_encode($speakersByName); ?>;
	var speakerSessions = <?php echo json_encode($speakerSessions); ?>;
	var sessions = <?php echo json_encode($session); ?>
</script>

<div id="speaker-detail" class="right-panel speaker-detail">
	<div class="p-b-15"><a href="#" id="speaker-detail-close" class="hide-click-off-link">Close</a></div>
	<div id="speaker-detail-company" class="speaker-detail-company p-t-25"></div>
	<div class="p-b-25">
		<div id="speaker-detail-name"></div>
		<div id="speaker-detail-title" class="speaker-detail-title"></div>
	</div>
	<div id="speaker-detail-image" class="speakers-list-image"></div>
	<div class="p-b-10"></div>
	<div id="speaker-detail-description" class="p-b-50"></div>
	<h3 class="p-b-15">This Speaker's Sessions</h3>
	<div id="speaker-detail-sessions"></div>
</div>

<section class="speakers-list">
	<div class="contain-standard p-mobile-standard p-b-50"><?php
	
		for ($i=0;$i<10;$i++){
			if ($metaData['title_'.($i+1)]){ ?>
				<div class="p-b-100">
				<div>
					<h2><?php echo $metaData['title_'.($i+1)]; ?></h2>
					<div class="h2-separator"></div>
				</div><?php
				
				$tmp = explode("\n",$metaData['listing_'.($i+1)]);  ?>
				<div class="columns-fluid  speakers-tiles collapse-800"><?php
					for ($b=0;$b<count($tmp);$b++){ 
						if ($speakersByName[format_for_url($tmp[$b])]){ ?>
							<div class="col-3"><?php
								$data = $speakersByName[format_for_url($tmp[$b])];
								speakers_render_speaker_tile($data); ?>
							</div><?php
						}
						else{ 
							if (user_can( $current_user, 'administrator' )) { ?>
								<div class="col-3"><?php
									echo "<span style='color: red;'>Not found: ".$tmp[$b]." (check your spelling)</span>"; ?>
								</div><?php	
							}							
						}
					} 
						?>
				</div>
				</div><?php
			}
			
		}	?>
		
	</div>
</section><?php

function speakers_render_speaker_tile($data,$moderator=null){ 
	if ($data['name']){ 
		if ($data['url'] && !stristr($data['supress_bio_popup'],"Suppress")){ ?>
			<a href="<?php echo $data['url']; ?>" class="js-speakers-list-tile speakers-list-tile" data-id="<?php echo $data['name_key']; ?>"><?php
		}
		else{ ?>
			<div class="speakers-list-tile" style="width: 100%; display: flex;"><?php
		} ?>
			
		<div class="speakers-list-wrapper-image">
			<div class="speakers-list-image" style="background-image: url('<?php echo $data['image']; ?>');"></div>
		</div>
		<div class="speakers-list-wrapper-content"><?php

			//Break apart any list of names with a comma, make into an array:
			$moderators = $moderator ? array_map('trim', explode(',', $moderator)) : [];	
			if (in_array($data['name'], $moderators)){ ?>
				<div class="speakers-list-moderator">Moderator</div><?php
			}	?>

			<div class="speakers-list-strapline"><?php echo $data['speaker_company']; ?></div>
			<div class="speakers-list-name"><?php echo $data['name']; ?></div>
			<div class="speakers-list-title"><?php echo $data['speaker_title']; ?></div>
		</div><?php


		if ($data['url'] && !stristr($data['supress_bio_popup'],"Suppress")){ ?>
			</a><?php
		}
		else{ ?>
			</div><?php
		}
	}
}

?>
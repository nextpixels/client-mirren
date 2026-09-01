<?php

			
	require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php"); 
	require_once(get_template_directory()."/zephyr-functions/str-format-for-url.php");
	require_once("featured-sessions-functions.php");
	
	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");

	ergo_embed_styles_scripts(__DIR__);	
	
	//Get the selected sessions to display:
		$page_id = 5;
		$sessionsToDisplay = [];
		if (have_rows('session_tiles')) {
			$i = 0;
			while (have_rows('session_tiles')) {
				the_row();

				$sessionsToDisplay[$i] = get_sub_field('session');
				$speakerToDisplay[$i]  = get_sub_field('speaker');
				$i++;
			}
		}
		
		
		
	//Get the sessions:
		$args = array(
			'post_type' => 'sessions',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'post__in' => $sessionsToDisplay,
			'orderby' => 'post__in'
		);
	
		$data = ergo_get_posts_from_args($args);
		
		
		

			
	//Get speaker data (just getting the first speaker for each session):
		$names = array();
		if (is_array($data)){
			
			for ($i=0;$i<count($sessionsToDisplay);$i++){


				//Get the session data:
					$postTitle = get_the_title($sessionsToDisplay[$i]);

				
				$data[$i]['Meta']['SessionTitle'] = get_the_title($sessionsToDisplay[$i]);
				
				
				$speaker = explode("\n",$data[$i]['Meta']['session_speakers']);
				
				//If a speaker was specified through the ACF form, use that, otherwise just use the first speaker:
					if ($speakerToDisplay[$i]){
						$names[$i] = format_for_url($speakerToDisplay[$i]);
						$data[$i]['Meta']['speaker'] = $speakerToDisplay[$i];
					}
					else{
						$names[$i] = format_for_url($speaker[0]);
						$data[$i]['Meta']['speaker'] = $speaker[0];
					}

			}


	//Get all the speaker data:
		$speakers_args = array(  
				'posts_per_page' => -1,
				'post_type'      => 'speakers',
				'post_status'    => 'publish',
				'post_name__in'  => $names
			);
			$speakers = ergo_get_posts_from_args($speakers_args);
			
			$speakersByName = array();
			if (is_array($speakers)){
				for ($i=0;$i<count($speakers);$i++){
					$key = format_for_url($speakers[$i]['Title']);
					$speakersByName[$key]['Name'] = $speakers[$i]['Title'];
					$speakersByName[$key]['Meta'] = $speakers[$i]['Meta'];	
				}
			}
	
		}	
		
	
		?>


<section id="featured-sessions" class="featured-sessions" style="position: relative; z-index: 1;">

	<div class="contain-standard p-mobile-standard p-standard">
	
		<div class="contain-800">
			<div class="text-center text-left-1000 p-b-25">
				<h2>Featured Sessions</h2>
				<div></div>
			</div>
		</div>
		
		<div class="columns-fluid collapse-900"><?php

			if (is_array($data)){
				for ($i=0;$i<count($data);$i++){
					featured_sessions_tile($data[$i],$speakersByName,$i);
				}
			}			?>
		</div>
		
		<div class="text-center">
			<a href="<?php echo get_site_url(); ?>/agenda/" class="btn btn-primary">See Full Lineup</a>
		</div>
</section>
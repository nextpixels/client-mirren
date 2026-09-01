<?php

require_once(get_template_directory()."/zephyr-functions/date-text-format.php");

function sessions_get_list(){
	$args = array(
		'post_type' => 'sessions',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'meta_value',
		'meta_key' => 'session_timestamp',
		'order' => 'ASC'
	);

	$queryPosts = get_posts($args,ARRAY_A);

	for ($i=0;$i<count($queryPosts);$i++){
			$session[$i]['post_id'] = $queryPosts[$i]-> ID;
			
		//Format meta data:
			$meta 		= get_post_meta($queryPosts[$i]-> ID);
			foreach ($meta as $key => $value) {
				if (substr($key,0,1) != "_"){
					$session[$i][$key] = $value[0];				
				}
			}
		
		$session[$i]['session_title'] = $queryPosts[$i]->post_title;
		
		if (!$session[$i]['session_track']){
			$session[$i]['session_track'] = 1;
		}
		
	}
	
	

	//Format the date and times better:
		if (is_array($session)){
			for ($i=0;$i<count($session);$i++){
				$tmp = explode(" ",$session[$i]['session_timestamp']);
				$session[$i]['session_date'] = str_replace("-","",$tmp[0]);
				$session[$i]['session_time'] = str_replace(":","",$tmp[1]);
				$session[$i]['session_timestamp'] = $session[$i]['session_date'].$session[$i]['session_time'];
				$session[$i]['session_datetime_nice'] = text_format($session[$i]['session_timestamp'],"M j, Y")." | ".text_format($session[$i]['session_timestamp'],"g:i a"); 
				
				//TODO: Need to find a better way of keeping the HTML in place for these
				//Fix so this doesn't cause javascript errors:
				
					$session[$i]['session_description'] = wpautop($session[$i]['session_description']);
				
					$session[$i]['session_description'] = htmlentities(($session[$i]['session_description']));
					$session[$i]['session_description'] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "", ($session[$i]['session_description']));
					
				//Ampersans (I think they get messed up from the above):
					$session[$i]['session_description']  = str_replace("&amp;","&",$session[$i]['session_description']);

				//More HTML formatting weirdness
					$session[$i]['session_description'] 		= str_replace("&quot;","\&quot;",$session[$i]['session_description']); 
					$session[$i]['session_description'] 		= html_entity_decode($session[$i]['session_description']);
					
					
					
			//Details		
					$session[$i]['session_details'] = wpautop($session[$i]['session_details']);
				
					$session[$i]['session_details'] = htmlentities(($session[$i]['session_details']));
					$session[$i]['session_details'] = str_replace(array("\r\n", "\n\r", "\r", "\n"), "", ($session[$i]['session_details']));
					
				//Ampersans (I think they get messed up from the above):
					$session[$i]['session_details']  = str_replace("&amp;","&",$session[$i]['session_details']);

				//More HTML formatting weirdness
					$session[$i]['session_details'] 		= str_replace("&quot;","\&quot;",$session[$i]['session_details']); 
					$session[$i]['session_details'] 		= html_entity_decode($session[$i]['session_details']);	
					
			

				//
			}
		}
	return $session;
	
}

?>
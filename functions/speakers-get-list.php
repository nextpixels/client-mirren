<?php

function speakers_get_list(){
	$args = array(
		'post_type' => 'speakers',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$queryPosts = get_posts($args,ARRAY_A);

	for ($i=0;$i<count($queryPosts);$i++){
		$speakers[$i]['name'] = $queryPosts[$i]->post_title;
		$speakers[$i]['url'] = get_permalink($queryPosts[$i]-> ID);
		
		//Format meta data:
			$meta 		= get_post_meta($queryPosts[$i]-> ID);
			foreach ($meta as $key => $value) {
				if (substr($key,0,1) != "_"){
					$speakers[$i][$key] = $value[0];				
				}
			}
			
			$speakers[$i]['image'] = wp_get_attachment_image_src($speakers[$i]['speaker_image'],'medium')[0];
			
	}
	
	return $speakers;
	
}


?>
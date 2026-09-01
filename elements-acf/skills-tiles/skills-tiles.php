<?php

require_once(get_template_directory()."/functions/ergo-include-image.php");
require_once("skills-tiles-functions.php");
include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");

ergo_embed_styles_scripts(__DIR__);	

$text = array();

if ( have_rows('skill_items') ) {
    $i = 0;

    while ( have_rows('skill_items') ) {
        the_row();

        $skill_title = get_sub_field('skill_title');

        if ( !empty($skill_title) ) {
            $text[$i] = $skill_title;
            $i++;
        }
    }
}

?>

<section id="featured-tiles" class="featured-tiles">

	<div class="contain-standard p-mobile-standard p-standard" style="position: relative; z-index: 1;">
	
		<div class="contain-800">
			<div class="text-center text-left-1000 p-b-25">
				<h2><?php echo get_field('title'); ?></h2>
				<div class="p-b-50"><?php echo get_field('intro_text'); ?></div>
			</div>
		</div>
		
		<div class="columns-fluid collapse-700"><?php
			/*
			$text[0] = "Identify the right off-the-shelf tools";
			$text[1] = "Integrate AI into daily project workflows";
			$text[2] = "Raise your fees by increasing client value";
			$text[3] = "Build custom tools (without heavy dev)";
			$text[4] = "Develop a practical AI Rollout Plan";
			$text[5] = "And so much more....";
		*/
			for ($i=0;$i<6;$i++){
				skills_tile($text[$i]);
			} 
			
			?>
			
		</div>
		
		<div class="text-center">
			<a href="<?php echo get_site_url(); ?>/agenda/" class="btn btn-primary">See All Sessions</a>
		</div>
</section><?php





?>
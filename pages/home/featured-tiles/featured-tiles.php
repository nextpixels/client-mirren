<?php
require_once(get_template_directory()."/functions/ergo-include-image.php");
require_once("featured-tiles-functions.php");
?>

<section id="featured-tiles" class="featured-tiles">

	<div class="contain-standard p-mobile-standard p-standard" style="position: relative; z-index: 1;">
	
		<div class="contain-800">
			<div class="text-center text-left-1000 p-b-25">
				<h2>KEY AI SKILLS YOUR TEAM WILL LEARN</h2>
				<div class="p-b-50">Practical Case Studies | Instructional Sessions | Hands-on Workshops</div>
			</div>
		</div>
		
		<div class="columns-fluid collapse-700"><?php
		
			$text[0] = "Identify the right off-the-shelf tools";
			$text[1] = "Integrate AI into daily project workflows";
			$text[2] = "Raise your fees by increasing client value";
			$text[3] = "Build custom tools (without heavy dev)";
			$text[4] = "Develop a practical AI Rollout Plan";
			$text[5] = "And so much more....";
		
			for ($i=0;$i<6;$i++){
				featured_tile($text[$i]);
			} ?>
			
		</div>
		
		<div class="text-center">
			<a href="<?php echo get_site_url(); ?>/agenda/" class="btn btn-primary">See All Sessions</a>
		</div>
</section><?php





?>
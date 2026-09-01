<?php

require_once(get_template_directory()."/functions/ergo-include-image.php"); 
require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php"); 

$args = array(
	'post_type' => 'hotels',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => 'date',
	'order' => 'DESC'
);

$hotels = ergo_get_posts_from_args($args);

$hotelsCount = 0;
for ($i=0;$i<count($hotels);$i++){ 
	if ($hotels[$i]['Meta']['type'] != "restaurant"){
		$hotelsCount++;
	}
}

if ($hotelsCount > 2){
	$columnWidth 		= "4";
	$sectionWidth 		= "900";
}
else{
	$columnWidth 	= "6";
	$sectionWidth 		= "800";
}
?>

<section class="section-hotels">
	
	<div class="text-centered">
	<?php /*	<h2>{{hotels-title}}</h2> */ ?>
		
		<div class="columns-fluid collapse-900 contain-<?php echo $sectionWidth; ?>"><?php
		
		for ($i=0;$i<count($hotels);$i++){ 
			if ($hotels[$i]['Meta']['type'] != "restaurant"){	?>
				<div class="col-<?php echo $columnWidth; ?> p-b-25">
					 <h3 class="h3-small"><?php echo $hotels[$i]['Title']; ?></h3>
					<div>
						<?php echo $hotels[$i]['Meta']['hotel_address_1']; ?><br />
						<?php echo $hotels[$i]['Meta']['hotel_address_2']; ?><br /><?php
						if ($hotels[$i]['Meta']['hotel_website']){ ?>
							<div class="p-t-10">
								<a href="<?php echo $hotels[$i]['Meta']['hotel_website']; ?>" target="_blank">Website ></a>
							</div><?php
						}	?>
					</div>
				</div><?php
			}
		}	?>
		</div>
		
	</div>

</section>
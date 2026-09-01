<?php


function featured_sessions_tile($data,$speakersByName,$tileId){ 

	if ($data['Meta']['speaker']){	
	
		$key = format_for_url($data['Meta']['speaker']); 
		
		?>
		
		<div class="col-4 p-b-50 p-r-35 p-r-remove-700">
			<div class="featured-session-tile featured-session-tile-<?php echo $tileId+1; ?>"><?php 
			
					
				/*
				<div class="featured-session-tile-title"><?php
					if ($data['Meta']['is_keynote']){ ?>
						Featured Keynote<?php
					}
					else{ ?>
						Featured Session<?php
					} ?>
				
				</div>
				*/ ?>
				<div class="featured-session-speaker-company"><?php echo $speakersByName[$key]['Meta']['speaker_company']; ?></div>
				<div class="featured-session-speaker-image" style="background-image: url('<?php echo wp_get_attachment_image_url($speakersByName[$key]['Meta']['speaker_image'],'full'); ?>');"></div>
				
				<div class="featured-session-tile-content">
					<h3 class="featured-session-title"><?php echo $data['Meta']['SessionTitle']; ?></h3>
				</div>
				<div class="featured-session-tile-footer">
					<div class="featured-session-speaker-name"><?php echo $speakersByName[$key]['Name']; ?></div>
					<div class="featured-session-speaker-title"><?php echo $speakersByName[$key]['Meta']['speaker_title']; ?></div>
				</div>
			</div>
		</div><?php
	}
}	

?>
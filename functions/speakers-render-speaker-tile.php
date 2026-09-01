<?php

function speakers_render_speaker_tile($data,$moderator=null){ 
	if ($data['name']){ 
		if ($data['url'] && !stristr($data['supress_bio_popup'],"Suppress")){ ?>
			<a href="<?php echo $data['url']; ?>" class="js-speakers-list-tile speakers-list-tile" data-id="<?php echo $data['name_key']; ?>"><?php
		}
		else{ ?>
			<div class="speakers-list-tile" style="width: 100%; display: flex;"><?php
		} ?>
			<div class="columns-flex collapse-1100">
				<div class="col col-150 p-r-10 p-b-5">
					<div class="speakers-list-image" style="background-image: url('<?php echo $data['image']; ?>');"></div>
				</div>
				<div class="col col-fluid text-left"><?php

					//Break apart any list of names with a comma, make into an array:
					$moderators = $moderator ? array_map('trim', explode(',', $moderator)) : [];	
					if (in_array($data['name'], $moderators)){ ?>
						<div class="speakers-list-moderator">Moderator</div><?php
					}	?>
						
					<div class="speakers-list-strapline"><?php echo $data['speaker_company']; ?></div>
					<div class="speakers-list-name"><?php echo $data['name']; ?></div>
					<div class="speakers-list-title"><?php echo $data['speaker_title']; ?></div>
				</div>
			</div>
				
				<?php /*
			<div class="speakers-list-wrapper-image">
				<div class="speakers-list-image" style="background-image: url('<?php echo $data['image']; ?>');"></div>
			</div>
			<div class="speakers-list-wrapper-content"><?php
				if ($moderator ==  $data['name']){ ?>
					<div class="speakers-list-moderator">Moderator</div><?php
				}	?>
				<div class="speakers-list-strapline"><?php echo $data['speaker_company']; ?></div>
				<div class="speakers-list-name"><?php echo $data['name']; ?></div>
				<div class="speakers-list-title"><?php echo $data['speaker_title']; ?></div>
			</div> */ ?>
			
			
			
			<?php
		if ($data['url'] && !stristr($data['supress_bio_popup'],"Suppress")){ ?>
			</a><?php
		}
		else{ ?>
			</div><?php
		}
	}
}	?>
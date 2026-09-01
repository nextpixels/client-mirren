<?php

function render_new_session_tile($data){ 
	$style = "";
	if (!empty($data['BackgroundImage'])){
		$style = "background-image: url('".$data['BackgroundImage']."');";
	}	
	
	
	//Are all of the speaker companies the same?
		if (!empty($data['Speakers']) && is_array($data['Speakers'])){ 
			$sameCompany = true;
			for ($i=1;$i<count($data['Speakers']);$i++){
				if ($data['Speakers'][$i]['Company'] != $data['Speakers'][$i-1]['Company']){
					$sameCompany = false;
					break;
				}
			}
		}
	
	?>
	
	<div class="new-sessions-tile <?php echo $data['Class']; ?>" style="<?php echo $style; ?>"><?php
		if ($data['Type'] == "highlight"){ ?>
			<div>
				<?php echo $data['Text']; ?>
			</div>
			<?php
		}
		else{ ?>
		
			<div class="new-sessions-tile-added-alert"><?php echo $data['JustAddedText']; ?></div><?php
		
			if (!empty($data['Speakers']) && is_array($data['Speakers']) && $sameCompany == true){ ?>
				<div class="new-sessions-tile-company"><?php echo $data['Speakers'][0]['Company']; ?></div><?php
			} ?>
			
			<h2><?php echo $data['Title']; ?></h2>
			<p>
				<?php echo $data['Text']; ?>
			</p><?php
			
			
			//print_r($data['Speakers']);
			if ( !empty($data['Speakers']) && is_array($data['Speakers']) ) {
				foreach ( $data['Speakers'] as $speaker ) { ?>
					<div class="p-b-15"><?php  
						if (!empty($speaker['Image'])){ ?>
							<img class="speaker-image" src="<?php echo $speaker['Image']; ?>" /><?php
						} ?>
						<div class="new-sessions-tile-speaker"><?php echo $speaker['Name']; ?></div>
						<div class="new-sessions-tile-speaker-title"><?php echo $speaker['Title']; 
						
						if ($sameCompany != true){
							echo ", ".$speaker['Company'];
						} ?>
						
						</div>
					</div><?php 
						
				}
			}
			
			/*
			if (!empty($data['SpeakerImage'])){ ?>
				<img class="speaker-image" src="<?php echo $data['SpeakerImage']; ?>" /><?php
			}
			*/
			?>
			
			
			
			<div class="link-wrapper p-t-15">
				<a class="new-sessions-tile-agenda-link" href="<?php echo $data['AgendaLink']; ?>">See Agenda <i class="fa fa-angle-right" aria-hidden="true"></i></a>
			</div>
			<?php
			
		} ?>
	</div><?php	
	
}	?>
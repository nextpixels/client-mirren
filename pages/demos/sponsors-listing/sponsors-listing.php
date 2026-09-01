<section class="sponsor-listing contain-1200 p-mobile-1250 p-t-50 p-b-100">
<?php

$postId = get_the_ID();

// Check rows exists.
if( have_rows('sponsor',$postId) ){

		// Loop through rows.
		while( have_rows('sponsor',$postId) ){
			the_row();

			// Load sub field value.
			$name 					= get_sub_field('sponsor_name');
			$subtitle				= get_sub_field('sponsor_subtitle');
			$description			= get_sub_field('sponsor_description');
			$url							= get_sub_field('sponsor_url');
			$video 					= get_sub_field('video');
					
			
			// Initialize an empty array to store contact information.
				$contacts = array();
				
			// Check if rows exist for the nested 'contacts' repeater.
				if( have_rows('contacts') ) {
					
					// Loop through each contact in the nested repeater.
					while( have_rows('contacts') ) {
						the_row();
						
						// Get sub-field values for the nested repeater.
						$contact_name = get_sub_field('name');
						$contact_title = get_sub_field('title');
						$contact_email = get_sub_field('email');
						$contact_phone = get_sub_field('phone');
						
						// Add the contact details to the array.
						$contacts[] = array(
							'name'  => $contact_name,
							'title' => $contact_title,
							'email' => $contact_email,
							'phone' => $contact_phone		
						);
					}
				}	?>
			
			<div class="sponsor-detail columns-fluid collapse-1100">
				<div class="col-6 p-r-25 p-remove-1100">
					<div class="p-b-25"><?php
						if (isset($video) && strlen(trim($video)) > 0){ ?>
							<video controls style="max-width: 100%;">
							  <source src="<?php echo $video; ?>" type="video/mp4">
							  Your browser does not support the video tag.
							</video><?php
						} ?>
					</div>
				</div>
				<div class="col-6 p-l-25 p-remove-1100">
					<h2><?php echo $name; ?></h2>
					<div class="subtitle"><?php echo $subtitle; ?></div>
					<div class="sponsor-detail-company-description">
						<?php echo $description; ?>
					</div><?php
					if ($url){ ?>
						<div>
							<a href="<?php echo $url; ?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i> <?php echo $url; ?></a>
						</div><?php
					} 
					
					if (count($contacts) > 0){ ?>
						<div class="sponsor-detail-contacts p-t-25">
						<h3>For More Information:</h3>
						<div class="columns-grid columns-grid-3 collapse-700"><?php
						
							for ($b=0;$b<count($contacts);$b++){ ?>
								<div class="col p-b-20">
								<div class="sponsor-detail-contacts-name"><strong><?php echo $contacts[$b]['name']; ?></strong></div>
								<div class="sponsor-detail-contacts-title"><?php echo $contacts[$b]['title']; ?></div>
								<div class="sponsor-detail-contacts-email"><a href="mailto: <?php echo $contacts[$b]['email']; ?>"><?php echo $contacts[$b]['email']; ?></a></div>
								<div class="sponsor-detail-contacts-phone"><?php echo $contacts[$b]['phone']; ?></div>
								</div><?php
							}	?>
							
						</div>
						</div><?php
					}
					?>
				</div>
			</div><?php

		}
		
}	?>

</div>
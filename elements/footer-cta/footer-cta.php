<?php

$heroCTATitle					=  get_field('footer_cta_title', 'options');
if (!isset($heroCTATitle)){
	$heroCTATitle = "Stay updated on the AI Event announcements";
} ?>

<div class="cta-form-wrapper p-l-20 p-r-20 p-t-50">
	<div class="contain-700 text-center">
			<h2><?php echo $heroCTATitle; ?></h2>
		</div>
	<div class="cta-form">
		<?php echo do_shortcode('[contact-form-7 id="13dc298" title="Home Page Form"]'); ?>
	</div>
</div>


<?php

if ($options['Content']['HideCTABox'] != true){ ?>
	<div>
		<?php /*
		<div class="text-center p-b-40">
			<div class="p-b-10">
				<h3><?php echo get_option('herocta_title');  ?></h3>
				<p><?php echo get_option('herocta_text');  ?></p>
			</div>
			<a href="<?php echo get_site_url()."/".get_option('herocta_button_target');  ?>" class="btn btn-primary"><?php echo get_option('herocta_button_label');  ?></a>
		</div> */ ?>
		
		<div>
			<div class="text-center p-b-10">
				<h4>Save Your Seat + Special Pricing Offer</h4>
			</div>
			<?php echo do_shortcode('[contact-form-7 id="138"]'); ?>
			<div class="text-center">
				<a href="contact">Questions? Contact Us</a>
			</div>
		</div>
	</div><?php
} ?>
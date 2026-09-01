<?php

require_once(get_template_directory()."/functions/ergo-include-section.php");
require_once(get_template_directory()."/functions/ergo-includestylesheet.php");

get_header();	

ergo_include_stylesheet(get_stylesheet_directory()."/pages/broadcast/broadcast.min.css");
 
?>

<!-- Duplicates password field to show the password-->
<script type="text/javascript">
$(document).ready(function() {
  $(".panel").append($('<input type="text" class="hidpassw" />'));
  $(".hidpassw").attr("post_password", $("#pwbox-1692").attr("post_password"));
  $("#pwbox-1692").attr("type", "text").removeAttr("post_password");

  $("body").on("keypress", "#pwbox-1692", function(e) {
    var code = e.which;
    if (code >= 32 && code <= 127) {
      var character = String.fromCharCode(code);
      $(".hidpassw").val($(".hidpassw").val() + character);
    }
  });
});
</script>

<?php
if( ! post_password_required() ){

//Remove the cookie -- this is originally set to note that the user has started the sign-in-process.  If they hit the main page, it will only show the password box 
//(this is mainly to be able to catch misspelled passwords.  By removing the cookie, the user will see the full login form (not just the password box) on their next sign-in
if (isset($_COOKIE['broadcast-user-submitted'])) {
	setcookie("broadcast-user-submitted", "", time() - 3600, "/");
}

// START: Broadcast Content - After granted access
require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 
//
//
//ergo_include_section("elements/hero",array(
//		"Title" => "{{agenda-hero-title}}",
//		"Image" => get_stylesheet_directory_URI()."/pages/agenda/hero-agenda-3.jpg",
//		"Column_Left" => 4,
//		"Height" => 320
//));
//
//ergo_include_section("elements/hero-footer-cta",array());



?>

<div class="page-main page-main-dark">
	<div style="position: relative;"><div class="page-main-gradient"></div></div>
	<div class="page-main-contain p-t-100">

		<?php
		ergo_include_section("elements-acf/broadcast-intro");
		ergo_include_section("mirren-elements/partners",array('Title'=>get_field('partners_title'),'Text'=>get_field('partners_text')));
		//ergo_include_section("elements-acf/broadcast-ads"); ?>
		
		<div class="p-t-50"></div>
		<div><?php
		ergo_include_section("mirren-elements/agenda-list");	 ?>
		</div>
		<br /><br /><?php
		//ergo_include_section("elements/partners");		?>
		
	</div>
</div><?php

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");
// END: Broadcast Content - After granted access

// START: Login page - Before granted access 
}

//If the user has submitted their company/email, but goofed on the password, show this screen, just asking for the password again.
else if ($_COOKIE['broadcast-user-submitted'] == true){  



	?>
	
		<section class="broadcast-hero" style="background-size: cover; background-position: top right; display: block; width: 100%; height: auto;">
		<div class="p-mobile-standard contain-standard">
			<div class="columns-fluid collapse-1000">
				<div class="col-6">
					<div class="broadcast-hero-main-content">
						<h1><?php the_field('broadcast_hero_cta_left_main_heading'); ?></h1>
						<p><?php the_field('broadcast_hero_cta_left_subheading'); ?></p>

						<div class="form-wrap-password form-show" style="opacity: 1; visibility: visible;">
							<div class="with-sidebar-container container gdlr-password-protected" style="padding-top: 20px; padding-bottom: 40px;" >
									<div class="gdlr-item">
										<p>Please reenter your password carefully</p>
										<?php the_content(); ?>
									</div>
								</div>
						</div> <!-- END of .broadcast-hero-main-content  -->
				</div>
				<div class="clear"></div>
			</div>
			<div class="col-6 hide-lessthan-1000">
				<?php /* <img class="" src="https://ai.mirren.com/wp-content/themes/mirren-ai/pages/home/home-hero/home-hero-image.svg" alt="" style="line-height: 0; " loading="lazy"> */ ?>
			</div>

			<!-- END of .columns-fluid  -->
		</div>
	</section><?php


}

//Initial login screen (company/email)
else{ // post password require

	$pageStatus = get_field('page_status');

	if ($pageStatus[0] == "post-event"){	?>

		<section class="broadcast-hero post-event" style="background-size: cover; background-position: top right; display: block; width: 100%; height: auto;">
			<div class="p-mobile-standard contain-standard">
				<div class="columns-fluid collapse-1000">
					<div class="col-6">
						<div class="broadcast-hero-main-content">
							<h1><?php echo get_field('post_event_title'); ?></h1>
							<div class="p-t-50">
								<?php echo get_field('post_event_text'); ?>
							</div>
						
							 <!-- END of .broadcast-hero-main-content  -->
					</div>
					<div class="clear"></div>
				</div>
				<div class="col-6 hide-lessthan-1000">
					<?php /* <img class="" src="https://ai.mirren.com/wp-content/themes/mirren-ai/pages/home/home-hero/home-hero-image.svg" alt="" style="line-height: 0; " loading="lazy"> */ ?>
				</div>

				<!-- END of .columns-fluid  -->
			</div>
		</section><?php 
	}
	else{ ?>

		<section class="broadcast-hero" style="background-size: cover; background-position: top right; display: block; width: 100%; height: auto;">
			<div class="p-mobile-standard contain-standard">
				<div class="columns-fluid collapse-1000">
					<div class="col-6">
						<div class="broadcast-hero-main-content">
							<h1><?php the_field('broadcast_hero_cta_left_main_heading'); ?></h1>
							<p><?php the_field('broadcast_hero_cta_left_subheading'); ?></p>
							<div class="broadcast-name-email-wrap">
								<?php echo do_shortcode( '[contact-form-7 id="1440" title="Broadcast Form"]' ); ?>
							</div>
							<div class="form-wrap-password">
								<div class="with-sidebar-container container gdlr-password-protected" style="padding-top: 20px; padding-bottom: 40px;" >
										<div class="gdlr-item">
											<?php the_content(); ?>
										</div>
									</div>
						</div> <!-- END of .broadcast-hero-main-content  -->
					</div>
					<div class="clear"></div>
				</div>
				<div class="col-6 hide-lessthan-1000">
					<?php /* <img class="" src="https://ai.mirren.com/wp-content/themes/mirren-ai/pages/home/home-hero/home-hero-image.svg" alt="" style="line-height: 0; " loading="lazy"> */ ?>
				</div>

				<!-- END of .columns-fluid  -->
			</div>
		</section><?php  

	}
}
// END: Login page - Before granted access 
get_footer(); ?>
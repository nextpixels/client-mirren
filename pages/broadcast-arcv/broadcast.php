<?php

 get_header();

if( ! post_password_required() ){

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); 
require_once(get_template_directory()."/functions/ergo-include-section.php"); 


ergo_include_section("elements/hero",array(
		"Title" => "{{agenda-hero-title}}",
		"Image" => get_stylesheet_directory_URI()."/pages/agenda/hero-agenda-3.jpg",
		"Column_Left" => 4,
		"Height" => 320
));

ergo_include_section("elements/hero-footer-cta",array());

?>

<div class="page-main page-main-dark">
	<div style="position: relative;"><div class="page-main-gradient"></div></div>
	<div class="page-main-contain p-t-100">

		<!-- START: Broadcast Intro -->
		<div id="broadcast-intro" class="contain-standard p-mobile-standard">
			<div class="broadcast-intro-wrap">
				<div class="broadcast-intro-top-header">
					<p class="logout-wrap" style="text-align: right; margin-bottom: 0; line-height: 1em;"><?php echo do_shortcode( '[logout_btn]' ); ?></p>
					<p class="support-wrap"><a href="mailto:events@hello.mirren.com" target="_blank" rel="noopener">SUPPORT</a></p>
				</div>
				<div class="broadcast-intro-content">
					<h3><?php echo do_shortcode( '[acf field="orange_box_main_headline"]' ); ?></h3>
					<!-- <p class="subtitle center"><strong>[acf field="orange_box_subtitle"]</strong></p> -->
					<div class="col-grid">
						<div class="col-6 padding-l-30 padding-r-30 text-left">
							<?php echo do_shortcode( '[acf field="orange_box_text_left"]' ); ?>
						</div>
						<div class="col-6 padding-l-30 padding-r-30 text-left">
							<?php echo do_shortcode( '[acf field="orange_box_text_right"]' ); ?>
						</div>
					</div>
				</div>
			</div>
	
			<div class="client_area">
				<div class="banner-wrap" style="text-align: center;">
					<a class="whole-div-link" href="[acf field='orange_box_image_link']" target="_blank" rel="noopener">
						<img src="<?php echo do_shortcode( '[acf field="orange_box_image"]' ); ?>" />
					</a>
				</div>
				<div class="banner-wrap" style="text-align: center;">
					<a class="whole-div-link" href="[acf field='orange_box_image_link_2']" target="_blank" rel="noopener">
						<img src="<?php echo do_shortcode( '[acf field="orange_box_image_2"]' ); ?>" />
					</a>
				</div>
				<div class="banner-wrap" style="text-align: center;">
					<a class="whole-div-link" href="[acf field='orange_box_image_link_3']" target="_blank" rel="noopener">
						<img src="<?php echo do_shortcode( '[acf field="orange_box_image_3"]' ); ?>" />
					</a>
				</div>
			</div>
			<?php echo do_shortcode( '[acf_if_value field="important_message_content"]' ); ?>
		</div>
		<!-- END: Broadcast Buttons -->


		<?php

		ergo_include_section("agenda-list");	 ?>
		<br /><br /><?php
		ergo_include_section("elements/partners");		?>
		
	</div>
</div><?php

require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");

}else{ // post password require ?>

<section class="home-hero" style="background-image: url(https://mirrenlivestg.wpengine.com/wp-content/uploads/2023/04/MirrenLive-Splash-2022-hero-2-1.jpeg); background-position: top center; display: block; width: 100%; height: 100%; float: left;">
	<div class="contain-1200">
		<div class="col-grid">
			<div class="col-8">
				<div class="home-hero-main-content">
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
				</div> <!-- END of .home-hero-main-content  -->
			</div>
			<div class="clear"></div>
		</div> <!-- END of .col-grid  -->
	</div>
</section>

<?php  }

get_footer(); ?>
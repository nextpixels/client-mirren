<?php

	include_once(get_template_directory()."/functions/ergo-embed-styles-scripts.php");
	ergo_embed_styles_scripts(__DIR__);	
	
	$headingSub 		= get_field('orange_box_main_subhead');

	$introTitleLeft 		= get_field('top_banner_title_left');
	$introTextLeft 		= get_field('orange_box_text_left');

	$introTitleRight 	= get_field('top_banner_title_right');
	$introTextRight		= get_field('orange_box_text_right');
	
?>		
		
		<div id="broadcast-intro-wrap" class="contain-standard p-mobile-standard">
			<div id="broadcast-intro" class="broadcast-intro-wrap">
				<div class="broadcast-intro-top-header">
					<p class="logout-wrap" style="margin-bottom: 0; display: inline-block;"> <?php echo do_shortcode( '[logout_btn]' ); ?></p>
					<p class="support-wrap" style="margin-bottom: 0; display: inline-block; margin-left: 10px;""><a href="mailto:events@hello.mirren.com" target="_blank" rel="noopener">SUPPORT</a></p>
				</div>
				<div class="broadcast-intro-content">
				
					<h1><?php echo do_shortcode( '[acf field="orange_box_main_headline"]' ); ?></h1><?php
					if (!empty($headingSub)){ ?>
						<h3><?php echo $headingSub; ?></h3><?php
					} ?>

					<!-- <p class="subtitle center"><strong>[acf field="orange_box_subtitle"]</strong></p> -->
					<div class="columns-fluid collapse-800">
						<div class="col-6 padding-l-30 padding-r-30 text-left p-b-15"><?php
						
							ergo_include_section("ergo/acf-blocks/text-accordion",array(
								'title' => $introTitleLeft,
								'text' => $introTextLeft 
							)); ?>

						</div>
						<div class="col-6 padding-l-30 padding-r-30 text-left p-b-15"><?php
						
							ergo_include_section("ergo/acf-blocks/text-accordion",array(
								'title' => $introTitleRight,
								'text' => $introTextRight 
							)); ?>
							
						</div>
					</div>
				</div>
			</div><?php 
			
			$importantMessage = get_field("important_message_content");
			if (!empty($importantMessage)){ ?>
				<div id="important-message"><?php
					
					if (isset($importantMessage)){ ?>
						<p><?php echo $importantMessage; ?></p><?php
					} ?>
				</div><?php
			} ?>
		</div>
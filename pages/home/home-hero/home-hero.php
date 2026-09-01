<?php
require_once(get_template_directory()."/functions/ergo-include-image.php");
?>

<div class="home-hero">
	<div class="contain-1100 p-mobile-1150">
		
	<div class="columns-fluid collapse-1000">
		<div class="col-6 home-hero-content-column">
			<div>
				<?php ergo_include_image(get_stylesheet_directory_uri()."/elements/header-hybrid/logo-white.svg","",$options=array()); ?>
		
				<div class="ergo-content-subtitle">Virtual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oct 29th, 2025</div>
		
				<?php /*
				<div class="columns-flex collapse-500 home-hero-info-box-wrapper">
					<div class="col col-150">
						<div class="home-hero-info-box">
							Virtual<br />
							Feb 7, 2024
						</div>
					</div>
					<div class="col col-fluid p-l-20 p-remove-500">
						<h2>{{home-hero-lead-text}}</h2>
						
					</div>
				</div> */ ?>
			
				<div class="home-hero-text-lead p-t-20">
					{{home-hero-text-lead}}
				</div>
				<div class="home-hero-text">
					{{home-hero-text}}
				</div>
				
				<div class="home-hero-benefits columns-fluid collapse-500">
					<div class="col-6">{{home-hero-benefit-1}}</div>
					<div class="col-6">{{home-hero-benefit-2}}</div>
					<div class="col-6">{{home-hero-benefit-3}}</div>
					<div class="col-6">{{home-hero-benefit-4}}</div>
				</div>
				
			</div>
		</div>
		<div class="col-6 home-hero-content-image">
			<?php ergo_include_image(get_stylesheet_directory_uri()."/pages/home/home-hero/home-hero-image.svg","",$options=array()); ?>
		</div>
	</div>

	</div>
</div>
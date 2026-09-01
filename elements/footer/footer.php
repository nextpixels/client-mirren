<?php 
require_once(get_stylesheet_directory()."/_settings.php");
?>

<footer id="site-footer" class="site-footer">
		<div class="contain-standard p-mobile-standard">
			<div class="site-footer-main">
			<div class="columns-fluid collapse-1000">
				<div class="col-3 p-r-50 p-remove-1000">
					<div class="footer-logo-wrapper p-b-25">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="Home page">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.svg" alt="<?php echo $websiteName; ?>" />
						</a>
					</div>
					
					<div class="p-b-15"><?php echo get_option('company_address'); ?></div>
					<div><a href="mailto: <?php echo get_option('company_email');  ?>"><?php echo get_option('company_email');  ?></a></div>
					
				</div>
				<div class="col-9 footer-navigation">
					<?php require_once("inc-footer-navigation-one-horizontal.php"); ?>
				</div>
			</div>
			</div>
			<div class="footer-more-info text-center p-b-15">
				For more information on the conference <a href="mailto: mirren@designingevents.com">send us an email</a> or give us a call at <img class="phone" src="<?php echo get_stylesheet_directory_uri(); ?>/images/phone-white.svg" /><br />
				If you’re interested in sponsoring, you can get more information by <a href="mailto: walter.willett@mirren.com?subject=Sponsorship Inquiry">emailing us here</a>. 
			</div>

			
			<div class="text-centered p-t-35">
				<?php /* © 2023 Mirren Live: May 7-8, 2024 All rights reserved. */ ?>
				<?php /* <span><small>&copy; <?php echo date("Y"); ?> <?php echo get_bloginfo('name'); ?> All rights reserved.</small></span> */ ?>
				<span><small>&copy; Mirren Business Development <?php echo date("Y"); ?></small></span>
			</div>
		</div>

</footer>



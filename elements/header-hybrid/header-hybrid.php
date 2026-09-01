<?php 
require_once(get_stylesheet_directory()."/_settings.php");
?>

<div class="menu-toggle-background" style=""></div>

<div class="contain-standard p-mobile-standard">

	<div class="columns-flex">
		<div class="col col-200 header-logo-column center-v">
			
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="Home page" style="height: 100%; display: flex; align-items: center;">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/elements/header-hybrid/logo-white.svg" alt="<?php echo $websiteName; ?>" />
				</a>
			
		</div>
		<div class="col col-fluid center-v">
			<nav id="site-navigation" class="main-navigation">

				<button class="menu-toggle menu-bars" aria-label="Toggle Main Navigation"  aria-controls="primary-menu" aria-expanded="false">
					<i class="navigation-open fa fa-bars" aria-hidden="true"></i>
					<i class="navigation-close fa fa-times" aria-hidden="true"></i>
				</button>
				
				<div class="main-navigation-inner"><?php	
					
					$parent_post = get_post($post->post_parent);
					$parent_post_title = strtolower($parent_post->post_title);
				
					wp_nav_menu( array('theme_location' => 'menu-1','menu_id'=> 'primary-menu') );	?>
					
				</div>
				
			</nav>
		</div>
		<div class="clear"></div>
	</div>
</div><?php 

?>
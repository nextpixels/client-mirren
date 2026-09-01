<?php
	
	/*
	Options:
	$options['Content']['BackgroundImageMobile'] = "https://api.hubspot.com/designmanager/v1/raw-assets/stream/by-path/hero-mobile.jpg?portalId=21419704&buffer=true&updated=1649866782456 ";
	$options['Settings']['CollapseWidth'] = 900;
	$options['Settings']['BackgroundMobile'] = '#3E0E38';			//Background of hero when in mobile, generally just a background color
	$options['Settings']['Class']	= 'wrapper-class'; 		//Applied to the hero wrapper
	$options['Settings']['Style']  = ".hero-mobile-image{ margin-top: -100px; }";		//Just gets added to the style section
	$options['Settings']['WrapperStyle']
	*/
	
	require_once(get_template_directory()."/functions/ergo-include-image.php");
	require_once(get_stylesheet_directory()."/elements/hero-common/get-data.php");

	if (!$options['MaxWidth']){
		$options['MaxWidth'] = "1100";
	}
	if (!$options['Column_Left']){
		$options['Column_Left'] = 6;
	}
	$options['Column_Right'] = 12 - $options['Column_Left'];
	
	if (!$options['Height']){
		$options['Height'] = 420;
	}
	?>
	
	
	<style>
		@media(min-width: 1000px){
			.page-hero-content-wrapper,
			.page-hero-columns,
			.page-hero-columns .col,
			.page-hero-image-wrapper{
				height: 100%;
			}
			.page-hero{
				height: <?php echo $options['Height']; ?>px;
			}
			.hero-image img{
				position: absolute;
				bottom: 0;
			}
			.col-content{
				display: flex;
				align-items: center;
			}
		}
		@media(max-width:999px){
			.hero-image img{
				width: 100%;
			}
		}
		<?php
		echo $options['Settings']['Style'];	 ?>
	</style>
	

	
	
<section id="page-hero" class="page-hero <?php echo $options['Class']; ?>" style="<?php echo $options['WrapperStyle']; ?>">
	<div class="page-hero-content-wrapper  contain-<?php echo $options['MaxWidth'] ; ?> p-mobile-<?php echo (int)$options['MaxWidth']+50 ; ?>">
		
		<div class="page-hero-columns columns-fluid collapse-1000">
			<div class="col col-<?php echo $options['Column_Left']; ?> col-content">
				<?php require_once(get_stylesheet_directory()."/elements/hero-common/render-hero-content.php"); ?>
			</div>
			<div class="col col-<?php echo $options['Column_Right']; ?> hero-image">
				<div class="page-hero-image-wrapper" style="position: relative;">
					<?php ergo_include_image($options['Image'],"",$imageOptions); ?>
				</div>
			</div>
		</div>
	
	
<?php
		
		if ($options['Content']['BackgroundImageMobile']){ 
		
			$imageOptions['Class'] = "hero-mobile-image";
			$imageOptions['Style'] = "width: 100%;";
			$imageOptions['NoLazy'] = true;

			ergo_include_image($options['Content']['BackgroundImageMobile'],"",$imageOptions);
			
			?>
			<?php
		} ?>
		
	</div><?php
	
	
	 ?>
	
</section>

<div id="after-hero"></div>
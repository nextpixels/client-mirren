<section class="hero-mirrenlive">
	<?php /* <div class="contain-1100 p-mobile-1150 hero-contain" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/<?php echo $options['Image']; ?>'); background-size: 1200px;"> */ ?>
	<div class="contain-1100 p-mobile-1150 hero-contain" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/elements/hero-secondary/secondary-hero-background.svg'); background-size: 1200px;">
		
		<div class="hero-content">
			<div style="position: absolute;">
				<div style="position: absolute; width: 32px; height: 32px; left: -50px; top: 15px;">

					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/hero-background-1-left.svg" style="width: 32px; height: 32px;" />
				</div>
				<h1><?php echo $options['Title']; ?></h1><?php
				if ($options['Text']){ ?>
					<div class="hero-content-text"><?php
						echo $options['Text']; ?>
					</div><?php
				}	?>
			</div>
		</div>
		
	</div>
</section>
<?php
/*
 * Template Name: Basic
 */

	
	get_header(); 

	?>

	<div class="page-basic">
	
		<div class="page-basic-gradient"></div>
		<div style="position: relative; z-index: 1;">
			
			<div class="contain-1200 padding-mobile-1250 padding-tb-75 col-grid collapse-900" style="min-height: 900px;">
				<div class="col-8 padding-r-100 padding-remove-900 article-content">
					
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>
				
				<div class="clear"></div>
			</div>
		</div>
	</div><?php
	
	get_footer();
	
?>
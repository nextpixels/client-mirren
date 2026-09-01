<?php
/**
* Template Name: Blank Full
**/

require_once(get_template_directory()."/functions/ergo-include-image.php");
require_once(get_template_directory()."/functions/ergo-include-section.php"); 
require_once(get_template_directory()."/functions/ergo-includestylesheet.php"); 

$post = get_post(); 
$slug = $post->post_name; 



if (file_exists(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.js")){ ?>
	<script><?php 
		echo file_get_contents(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.js");  ?>
	</script><?php
}


if (file_exists(get_stylesheet_directory()."/pages/".$slug."/".$slug.".php")){
	require_once(get_stylesheet_directory()."/pages/".$slug."/".$slug.".php");
}
else{

	get_header();	
	
	
	if (file_exists(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.css")){ ?>
		<style><?php 
			$stylesheetString =  file_get_contents(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.css"); 
			$stylesheetString = str_replace("./pages/",get_stylesheet_directory_uri()."/pages/",$stylesheetString);
			$stylesheetString = str_replace("./images/",get_stylesheet_directory_uri()."/images/",$stylesheetString);
			$stylesheetString = str_replace("./elements/",get_stylesheet_directory_uri()."/elements/",$stylesheetString);
			echo $stylesheetString;  ?>
		</style><?php
	}
	else{
		
	}
	
	require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-top.php"); ?>

		<div id="primary" class="content-area">
			<main id="main" class="site-main">
				<div>
					<?php
					while ( have_posts() ) :
						the_post();	
						get_template_part( 'template-parts/content', 'page' );
					endwhile; // End of the loop.
					?>
				</div>
			</main><!-- #main -->
		</div><!-- #primary --><?php
	
	require_once(get_template_directory()."/ergo-in-page-editing/editable-inpage-bottom.php");
	get_footer();

}	?>
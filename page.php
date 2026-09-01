<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ergo
 */


require_once(get_template_directory()."/functions/ergo-include-image.php");
require_once(get_template_directory()."/functions/ergo-include-section.php"); 
require_once(get_template_directory()."/functions/ergo-includestylesheet.php"); 

$post = get_post(); 
$slug = $post->post_name; 

/*
if (file_exists(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.css")){ ?>
	<style><?php 
		echo file_get_contents(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.css");  ?>
	</style><?php
}

if (file_exists(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.js")){ ?>
	<script><?php 
		echo file_get_contents(get_stylesheet_directory()."/pages/".$slug."/".$slug.".min.js");  ?>
	</script><?php
}
*/

if (file_exists(get_stylesheet_directory()."/pages/".$slug."/".$slug.".php")){
	require_once(get_stylesheet_directory()."/pages/".$slug."/".$slug.".php");
}
else{
	require_once(get_stylesheet_directory()."/page-default.php");
}	?>

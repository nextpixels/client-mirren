<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ergo
 */

get_header(); ?>

<style>
	@media(min-width:900px){
		.page-hero h1{
			width: 70%;
		}
	}
</style>


<?php //ergo_include_section("elements/hero-mini"); ?>

<div class="contain-1200 padding-mobile-1250"><?php

	$type = get_post_type();	?>

		<div class="contain-700 padding-mobile-850 p-t-75 padding-b-100 padding-t-10" style="min-height: 800px;"><?php
			require_once(get_template_directory()."/acf-blocks/blog-detail/blog-detail.php"); 	?>
			
		</div>

</div>
<?php
//get_sidebar();
get_footer();

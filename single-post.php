<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ergo
 */

require_once(get_template_directory()."/functions/ergo-include-image.php");

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

		<div class="contain-700 padding-mobile-850 p-t-75 padding-b-100 padding-t-10" style="min-height: 800px;">
			<?php /*
			<div class="p-b-25">
				<a href="<?php echo get_site_url(); ?>/blog/"><i class="fa fa-chevron-left" aria-hidden="true"></i> Return</a>
			</div><?php
			*/
		
			/*
			if ( has_post_thumbnail() ) {
				$image_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
				<div class="blog-detail-header-image"><?php
					ergo_include_image($image_url); ?>
				</div><?php
			}
			*/
			
			require_once(get_template_directory()."/acf-blocks/blog-detail/blog-detail.php"); 	?>
			
		</div>

</div>
<?php
//get_sidebar();
get_footer();

<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ergo
 */
 
get_header();

//Get the category featured image:
	$term = get_queried_object();
	$tmp = get_field('hero_image', $term);
	$heroImage = $tmp['url'];

if (stristr($_SERVER['REQUEST_URI'],"news")){
	ergo_include_section("elements/hero-basic",array('Content'=>array("Title" => "News")));
}
else{
	$title = "Blog";
	$category = single_term_title('',false);
	if ($category){
		$title .= ": ".$category;
	}

	if (!$heroImage){
		$heroImage = get_stylesheet_directory_uri()."/pages/blog/hero-blog.jpg";
	}
	
	ergo_include_section("elements/hero",array(
		'Content'=>array(
			"Title" => $title,
			"BackgroundImage" => $heroImage
		),
		'Settings'=>array(
			"Class" => "narrow"
		)
	));
	
}	?>

<div id="primary" class="content-area page-archive">

	<main id="main" class="site-main contain-1200 padding-mobile-1250 padding-b-100 padding-t-50"><?php
			
		if (stristr($_SERVER['REQUEST_URI'],"news")){
			ergo_include_section("elements/blog-list");
		}
		else{ ?>
			
			<div class="col-grid-flex collapse-900">
				<div class="col-10 padding-r-50 padding-remove-900">
					<?php ergo_include_section("elements/blog-tiles"); ?>
				</div>
				<div class="col-2 hide-lessthan-900">
					<?php ergo_include_section("elements/blog-categories-list"); ?>
				</div>
			</div><?php		
			
		} ?>

	</main>
</div><?php

get_footer();
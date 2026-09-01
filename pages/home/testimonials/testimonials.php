<?php

require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php"); 

$args = array( 
	'post_type' =>  'testimonials',
	'posts_per_page' => 32,
	'paged' => $paged
); 

$testimonials = ergo_get_posts_from_args($args); ?>

<link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri(); ?>/vendor/splide/splide-core.min.css' media='all' />

<script>
	document.addEventListener( 'DOMContentLoaded', function(e) {
		if (document.getElementById('slider-testimonials')) {
			var splide = new Splide('#slider-testimonials', {
				type  : 'fade',
				autoplay: true,
				perPage: 1,
				rewind: true,
				perMove: 1,
				lazyLoad: 'nearby'
			});
			splide.mount();
		}
	});
</script>

<section id="testimonials" class="testimonials">
	<div class="contain-standard p-mobile-standard" style="position: relative; z-index: 1;">
	<div id="slider-testimonials" class="splide">
			<div class="splide__track">
				<ul class="splide__list"><?php
					for ($i=0;$i<count($testimonials);$i++){
						render_testimonial_card_content($testimonials[$i]);
					}	?>
				</ul>
			</div>
		  </div>
	</div>
</section><?php

function render_testimonial_card_content($data){ ?>
	<li class="splide__slide testimonial-card">
		<?php ergo_include_image(get_stylesheet_directory_uri()."/pages/home/testimonials/testimonial-icon.svg","",array('Class'=>'testimonial-icon p-b-30')); ?>
		<div class="testimonial-card-testimonial"><?php echo $data['Meta']['testimonial_text']; ?></div>
		<div class="testimonial-card-name"><?php echo $data['Meta']['testimonial_name']; ?></div>
		<div><?php echo $data['Meta']['testimonial_name_title']; ?>, <?php echo $data['Meta']['testimonial_name_company']; ?></div>
	</li><?php
}	?>
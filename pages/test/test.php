<?php

 get_header();
 
 ?>

<link rel='stylesheet' href='<?php echo get_stylesheet_directory_uri(); ?>/pages/test/splide-core.min.css' media='all' />

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

<h2 id="carousel-heading">Splide Basic HTML Example</h2>
<section id="slider-testimonials" class="splide">
 
  <div class="splide__track">
		<ul class="splide__list">
			<li class="splide__slide" style="background: red;">Slide 01</li>
			<li class="splide__slide" style="background: yellow;">Slide 02</li>
			<li class="splide__slide" style="background: green;">Slide 03</li>
		</ul>
  </div>
</section>

<?php get_footer(); ?>
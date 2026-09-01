<?php

	//Get the images:
		$item = 0;
		for ($i=0;$i<20;$i++){
			$tmp = get_field('image_'.($i+1));
			if ($tmp['url']){
				$image[$item]['Url'] = $tmp['url'];
				$item++;
			}
		} ?>
	
	<script>
		document.addEventListener( 'DOMContentLoaded', function(e) {
			if (document.getElementById('slider-test')) {
				var splide = new Splide('#slider-test', {
					type   : 'loop',
					pagination: false,
					arrows: false,
					perPage: 4,
					breakpoints: {
						800: {
							perPage: 2,
						},
						600: {
							perPage: 1,
						},
					},
					autoScroll: {
						speed: .75,
						autoStart: true,
					},
				});
				splide.mount(window.splide.Extensions);
			}
		});
	</script>

	<section id="logotrain-autoscroll" class=" logotrain-autoscroll p-t-75">
		<div class="contain-1100 p-mobile-1150">
			<div class="contain-700 text-centered p-b-25">
				<h2>{{logo-train-autoscroll-title}}</h2>
				<p>{{logo-train-autoscroll-text}}</p>
			</div>

			<div id="slider-test" class="splide logo-train-autoscroll-logos">
				 <div class="splide__track">
					<ul class="splide__list"><?php
						for ($i=0;$i<count($image);$i++){ ?>
							<li class="splide__slide"><img src="<?php echo $image[$i]['Url']; ?>" alt="" /></li><?php
						}	?>
					</ul>
				</div>
			</div>

		</div>
	</section>
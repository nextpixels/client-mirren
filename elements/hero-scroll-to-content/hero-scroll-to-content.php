<?php
require_once(get_template_directory()."/functions/ergo-includestylesheet.php");
ergo_include_stylesheet(get_stylesheet_directory()."/elements/hero/hero-scroll-to-content.min.css");
?>

<script>

	document.addEventListener( 'DOMContentLoaded', function(e) {
	   render_scroll_to_content();
	})

	function scroll_to_content(e){
		e.preventDefault();
		document.getElementById('after-hero').scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});
		hide('#scroll-to-content');
	}
	
	function render_scroll_to_content(){
		var heroHeight = document.querySelector('#page-hero').offsetHeight;
		if (heroHeight > window.innerHeight){
			show('#scroll-to-content');
			
			window.onscroll = function(event) {
				if (this.scrollY > 100){
					add_class('#scroll-to-content','fade-out');
				}
			}
			
		}
	}
	
</script>

<div id="scroll-to-content" class="mouse_scroll" style="border: 2px solid red;">
	<?php /*
	<div class="mouse">
		<div class="wheel"></div>
	</div> */ ?>
	<div>
		<?php /* <span class="m_scroll_arrows unu"></span> */ ?>
		<span class="m_scroll_arrows doi"></span>
		<span class="m_scroll_arrows trei"></span>
	</div>
</div>
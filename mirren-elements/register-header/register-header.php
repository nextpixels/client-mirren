<?php

$highlightText 			=  get_field('highlight_box_text'); 

 ?>

<div class="hero-register">
	<h1>Register</h1>
</div><?php
 

//ergo_include_section("elements/hero-simple",array('Title'=>'Register')); 

if ($highlightText ){ ?>
	<div class="p-b-20">
		<div class="register-highlight">
			<h3 style="font-size: 1.2rem; margin: 0; color: #fff;"><?php echo $highlightText; ?></h3>
		</div>
	</div><?php
}	?>
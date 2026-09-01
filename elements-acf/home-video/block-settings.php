<?php
	
	acf_register_block_type(array(
		'name'          => 'Home Video Section',
		'title'         => 'Home Video Section',
		'render_template'   => 'elements-acf/home-video/home-video.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'home-video.php'
		),
		'align' => 'full'
	));
	
?>
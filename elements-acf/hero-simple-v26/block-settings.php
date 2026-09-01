<?php
	
	acf_register_block_type(array(
		'name'          => 'Hero Simple - v2026',
		'title'         => 'Hero Simple - v2026',
		'render_template'   => 'elements-acf/hero-simple-v26/hero-simple-v26.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'hero-simple-v26.php'
		),
		'align' => 'full'
	));
	
?>
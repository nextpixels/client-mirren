<?php
	
	acf_register_block_type(array(
		'name'          => 'Mirren Home Hero',
		'title'         => 'Mirren Home Hero',
		'render_template'   => 'elements-acf/mirren-home-hero/mirren-home-hero.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'mirren-home-hero.php'
		),
		'align' => 'full'
	));
	
?>
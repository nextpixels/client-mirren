<?php
	
	acf_register_block_type(array(
		'name'          => 'Featured Sessions',
		'title'         => 'Featured Sessions',
		'render_template'   => 'elements-acf/featured-sessions/featured-sessions.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'featured-sessions.php'
		),
		'align' => 'full'
	));
	
?>
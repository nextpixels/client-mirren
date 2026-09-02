<?php
	
	acf_register_block_type(array(
		'name'          => 'Featured Sessions v2',
		'title'         => 'Featured Sessions v2',
		'render_template'   => 'elements-acf/featured-sessions-v2/featured-sessions-v2.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'featured-sessions-v2.php'
		),
		'align' => 'full'
	));
	
?>
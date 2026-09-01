<?php
	
	acf_register_block_type(array(
		'name'          => 'Session Tile',
		'title'         => 'Session Tile',
		'render_template'   => 'elements-acf/session-tile/session-tile.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'session-tile.php'
		),
		'align' => 'full'
	));
	
?>
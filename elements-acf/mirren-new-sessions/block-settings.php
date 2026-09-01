<?php
	
	acf_register_block_type(array(
		'name'          => 'Mirren New Sessions',
		'title'         => 'Mirren New Sessions',
		'description'       => 'New Sessions',
		'render_template'   => 'elements-acf/mirren-new-sessions/mirren-new-sessions.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'mirren-new-sessions.php'
		),
		'align' => 'full'
	));
	
?>
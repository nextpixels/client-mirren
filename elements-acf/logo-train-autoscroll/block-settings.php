<?php
	
	acf_register_block_type(array(
		'name'          => 'Logo Train - Autoscroll',
		'title'         => 'Logo Train - Autoscroll',
		'render_template'   => 'elements-acf/logo-train-autoscroll/logo-train-autoscroll.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'logo-train-autoscroll.php'
		),
		'align' => 'full'
	));
	
?>
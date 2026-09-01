<?php
	
	acf_register_block_type(array(
		'name'          => 'Skills Tiles',
		'title'         => 'Skills Tiles',
		'render_template'   => 'elements-acf/skills-tiles/skills-tiles.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'skills-tiles.php'
		),
		'align' => 'full'
	));
	
?>
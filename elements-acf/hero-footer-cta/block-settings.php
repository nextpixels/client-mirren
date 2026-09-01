<?php
	
	acf_register_block_type(array(
		'name'          => 'Hero Footer CTA',
		'title'         => 'Hero Footer CTA',
		'render_template'   => 'elements-acf/hero-footer-cta/hero-footer-cta.php',
		'category'      => 'custom blocks',
		'icon'          => 'admin-appearance',
		'acf' => array(
			'mode' => 'preview',
			'renderTemplate' => 'hero-footer-cta.php'
		),
		'align' => 'full'
	));
	
?>
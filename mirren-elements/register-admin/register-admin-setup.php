<?php

function my_admin_menu() {
		add_menu_page(
			'Registrations',
			'Registrations',
			'manage_options',
			'registrations',
			'my_admin_page_contents',
			'dashicons-schedule',
			3
		);
	}

	add_action( 'admin_menu', 'my_admin_menu' );

	function my_admin_page_contents() {
		require_once("registrations-listing.php");
	}	?>
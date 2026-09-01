<?php

// Disable Emails
//add_filter('pre_wp_mail', 'di_disable_emails');
function di_disable_emails() {
	return false;
}

// Increase The Events Calendar (TEC) Zapier Queue Limit
add_filter( 'tec_event_automator_zapier_max_queue_items', function($max_items) {
	return 100;
}, 10, 1 );

	//Custom Post Types
		function create_posttype() {
			
			register_post_type( 'speakers',
				array(
					'labels' => array(
						'name' => __( 'Speakers' ),
						'singular_name' => __( 'Speaker' )
					),
					'supports'            => array( 'title','page-attributes'),
					'public' => true,
					'has_archive' => true,
					'rewrite' => array('slug' => 'speaker'),
				)
			);
			
			register_post_type( 'sessions',
				array(
					'labels' => array(
						'name' => __( 'Sessions' ),
						'singular_name' => __( 'Session' )
					),
					'supports'            => array( 'title','page-attributes'),
					'public' => true,
					'has_archive' => false,
					'rewrite' => array('slug' => 'session'),
				)
			);
			
			register_post_type( 'testimonials',
				array(
					'labels' => array(
						'name' => __( 'Testimonials' ),
						'singular_name' => __( 'Testimonial' )
					),
					'supports'            => array( 'title','page-attributes'),
					'public' => true,
					'has_archive' => false,
					'rewrite' => array('slug' => 'testimonial'),
				)
			);
			
			register_post_type( 'hotels',
				array(
					'labels' => array(
						'name' => __( 'Hotels' ),
						'singular_name' => __( 'Hotel' )
					),
					'supports'            => array( 'title','page-attributes'),
					'public' => true,
					'has_archive' => false,
					'rewrite' => array('slug' => 'hotel'),
				)
			);
			
			
			register_post_type( 'productproperites',
				array(
					'labels' => array(
						'name' => __( 'Product Properties' ),
						'singular_name' => __( 'Product Property' )
					),
					'supports'            => array( 'title','page-attributes'),
					'public' => true,
					'has_archive' => false,
					'rewrite' => array('slug' => 'productproperties'),
				)
			);
			
			register_post_type( 'exhibitors',
			  array(
				  'labels' => array(
					  'name' => __( 'Resources Center' ),
					  'singular_name' => __( 'Resources Center' )
				  ),
				  'public' => true,
				  'has_archive' => false,
				  'rewrite' => array('slug' => 'resource-center', 'with_front' => false)
			  )
		  );
			
		}
		
		add_action( 'init', 'create_posttype' );
	//Custom Post Types


	//Stylesheets
		function theme_styles() {
			wp_enqueue_style( 'site-css',  get_stylesheet_directory_uri().'/css/style.min.css',null, filemtime( get_stylesheet_directory() . '/css/style.min.css' ));
			wp_enqueue_style( 'theme-css',  get_stylesheet_directory_uri().'/theme-mirrenlive-2026/theme-mirrenlive-2026.min.css',null, filemtime( get_stylesheet_directory() . '/theme-mirrenlive-2026/theme-mirrenlive-2026.min.css' ));
		}
		add_action( 'wp_enqueue_scripts', 'theme_styles',99);
		function di_styles() {
			wp_enqueue_style( 'di-css',  get_stylesheet_directory_uri().'/css-di/di-style.css',null, filemtime( get_stylesheet_directory() . '/css-di/di-style.css' ));
		}
		add_action( 'wp_enqueue_scripts', 'di_styles',999);
	//Stylesheets	
	
	//Javascript
		function theme_js(){
			$uri = get_stylesheet_directory_uri();
			$dir = get_stylesheet_directory();
			$js_ver_di = date("ymd-Gis", filemtime($dir . '/js-di/di-scripts.js'));
			
			//wp_enqueue_script( 'site-js', '/dist/scripts.js', array(), "1119", true );
			$script_path = '/dist/scripts.js';
			$script_url  = '/dist/scripts.js';

			wp_enqueue_script(
				'site-js',
				$script_url,
				array(),
				filemtime( $script_path ),
				true
			);
			
			wp_enqueue_script( 'di-js', $uri .'/js-di/di-scripts.js', array(), $js_ver_di, true );
			$di_js_array = array(
				'ticket_cart_count' => (
						function_exists( 'WC' ) &&
						WC()->cart
					)
					? (int) WC()->cart->get_cart_contents_count()
					: 0,
				'virtual_only'							 => get_field('virtual_only_event', 'option'),
				'register_row_quantity_prompt_in_person' => get_field( 'register_row_quantity_prompt_in_person', 'option' ),
				'register_row_bundle_prompt_title'		 => get_field( 'register_row_bundle_prompt_title', 'option' ),
				'register_row_bundle_prompt_show_info'	 => get_field( 'register_row_bundle_prompt_show_info', 'option' ),
				'register_row_bundle_prompt_subtext'	 => get_field( 'register_row_bundle_prompt_subtext', 'option' ),
			);
			wp_localize_script( 'di-js', 'di_js_obj', $di_js_array);
		}
		add_action( 'wp_enqueue_scripts', 'theme_js',99);
		
	// Remove 'posts' post type from side menu
		/*
		add_action( 'admin_menu', 'remove_default_post_type' );

		function remove_default_post_type() {
			remove_menu_page( 'edit.php' );
		}
		*/

	//Make sure posts of type blog appear on archive category pages
		function namespace_add_custom_types( $query ) {
		  if( (is_category() || is_tag()) && $query->is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {
			$query->set( 'post_type', array(
			 'post', 'blog'
				));
			}
		}
		add_action( 'pre_get_posts', 'namespace_add_custom_types' );


		//Custom URL Parameters:
			add_action('init','add_get_val');
			function add_get_val() { 
				global $wp; 
				$wp->add_query_var('id'); 
				$wp->add_query_var('show'); 
				$wp->add_query_var('tab'); 
			}
	

	//Remove post types from Yoast sitemap
	/*
		add_filter( 'wpseo_sitemap_exclude_post_type', 'your_prefix_exclude_cpt_from_sitemap', 10, 2 );
		function your_prefix_exclude_cpt_from_sitemap( $value, $post_type ) {
			$post_types_to_exclude = [
				'post'
			];
			if ( in_array($post_type, $post_types_to_exclude) ) {
				return true;
			}
		}
	*/	


	//Custom Image Sizes:
		add_image_size( 'medium2x', 600, 600);
		add_image_size( 'thumbnail2x', 300, 300);


	//Options Page:
		if( function_exists('acf_add_options_page') ) {
			acf_add_options_page();
		}











add_action( 'woocommerce_cart_totals_before_order_total', 'bbloomer_show_total_discount_cart_checkout', 4 );
add_action( 'woocommerce_review_order_before_order_total', 'bbloomer_show_total_discount_cart_checkout', 4 );

function bbloomer_show_total_discount_cart_checkout() {

	//global $woocommerce;

	if( count( WC()->cart->get_applied_coupons() ) > 0 ) {
		$before_discount = 0;

		$cart_total = WC()->cart->cart_contents_total;

		if( $cart_total ){

			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$product = $values['data'];
				$regular_price = $product->get_regular_price();
				$discount = ( $regular_price - $sale_price ) * $values['quantity'];
				$before_discount += $discount;
			}

			if ( $before_discount != $cart_total ) {


				$saved = ( $before_discount -  $cart_total );

				echo '<tr><th>Subtotal</th><td data-title="Subtotal">' . wc_price( $cart_total + WC()->cart->get_discount_total() ) .'</td></tr>';

				echo '<tr><th>Discount</th><td data-title="Discount">-' . wc_price( WC()->cart->get_discount_total() ) .'</td></tr>';
			}

		}
	} else {
		$before_discount = 0;

		$cart_total = WC()->cart->cart_contents_total;

		if( $cart_total ){

			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$product = $values['data'];
				$regular_price = $product->get_regular_price();
				$discount = ( $regular_price - $sale_price ) * $values['quantity'];
				$before_discount += $discount;
			}

			if ( $before_discount != $cart_total ) {


				$saved = ( $before_discount -  $cart_total );

				echo '<tr><th>Subtotal</th><td data-title="Subtotal">' . wc_price( $before_discount + WC()->cart->get_discount_total() ) .'</td></tr>';

				echo '<tr><th>Discount</th><td data-title="Discount">-' . wc_price( $saved + WC()->cart->get_discount_total() ) .'</td></tr>';
			}

		}
	}


}



add_filter( 'gettext', 'change_cart_totals_text', 20, 3 );
function change_cart_totals_text( $translated, $text, $domain ) {
    if( function_exists( 'is_cart' ) && is_cart() && $translated == 'Cart totals' ){
        $translated = 'Registration Total';
    }
    return $translated;
}

//add_filter( 'gettext', 'woo_discount_text', 999, 3 );
function woo_discount_text( $translated, $text, $domain ) {

	if ( is_admin() ){
		return $translated;
	} else {
		//$translated = str_ireplace( 'Discount', 'Your Group Rate Savings', $translated );

		return $translated;
	}
}

// Change default checkout country
add_filter( 'default_checkout_billing_country', 'change_default_checkout_country' );
function change_default_checkout_country() {
	return 'US'; // country code
}


// Change default woocommerce field labels
/*add_filter( 'woocommerce_default_address_fields' , 'rename_woo_checkout_fields', 9999 );

function rename_woo_checkout_fields( $fields ) {

    $fields['city']['label'] = 'City';
	$fields['address_1']['label'] = "Company Address";
	$fields['address_1']['placeholder'] = "Company Address";

    return $fields;

}*/




add_filter( 'woocommerce_return_to_shop_redirect', 'bbloomer_change_return_shop_url' );
 
function bbloomer_change_return_shop_url() {
   return home_url();
}


// Replace strings in Tribes plugins

function tribe_replace_strings() {
	$custom_text = [
	  'Return to cart' => 'Edit number of attendees',
	  'Ticket ID'		=> 'Confirmation #',
	  'Ticket Type'		=> 'Pass Level',
	  'Attendee Registration' => 'Add Your Attendees',
	  'Each attendee specified will receive an email with their individual ticket included.' => 'Each attendee will recieve conference details closer to the event.',
	  'Back to cart' => 'Edit number of attendees',
	  'You\'ll receive your %s in another email.' => ' ',
	  'There is %s other ticket in your cart that does not require attendee information.' => ' ',
	  'There are %s other tickets in your cart that do not require attendee information.' =>  ' '
	];
   
	return $custom_text;
  }
   
   
   
  function tribe_custom_theme_text ( $translation, $text, $domain ) {
	// If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
	if ( ! check_if_tec_domains( $domain ) ) {
	  return $translation;
	}
   
	// String replacement.
	$custom_text = tribe_replace_strings();
   
	// If we don't have replacement text in our array, return the original (translated) text.
	if ( empty( $custom_text[$translation] ) ) {
	  return $translation;
	}
   
	return $custom_text[$translation];
  }
   
   
   
  function tribe_custom_theme_text_plurals ( $translation, $single, $plural, $number, $domain ) {
	// If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
	if ( ! check_if_tec_domains( $domain ) ) {
	  return $translation;
	}
   
	/** If you want to use the number in your logic, this is where you'd do it.
	 * Make sure you return as part of this, so you don't call the function at the end and undo your changes!
	 */
   
	// If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
	if ( 1 === $number ) {
	  return tribe_custom_theme_text ( $translation, $single, $domain );
	} else {
	  return tribe_custom_theme_text ( $translation, $plural, $domain );
	}
  }
   
   
   
  function tribe_custom_theme_text_with_context ( $translation, $text, $context, $domain ) {
	// If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
	if ( ! check_if_tec_domains( $domain ) ) {
	  return $translation;
	}
   
   
	// If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
	return tribe_custom_theme_text ( $translation, $text, $domain );
  }
   
   
   
  function tribe_custom_theme_text_plurals_with_context ( $translation, $single, $plural, $number, $context, $domain ) {
	// If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
	if ( ! check_if_tec_domains( $domain ) ) {
	  return $translation;
	}
   
	// If we're not doing any logic up above, just make sure your desired changes are in the $custom_text array above (in the `tribe_custom_theme_text` filter. )
	if ( 1 === $number ) {
	  return tribe_custom_theme_text ( $translation, $single, $domain );
	} else {
	  return tribe_custom_theme_text ( $translation, $plural, $domain );
	}
  }
   
  function check_if_tec_domains( $domain ) {
	$is_tribe_domain = strpos( $domain, 'tribe-' )      === 0;
	$is_tec_domain   = strpos( $domain, 'the-events-' ) === 0;
	$is_event_domain = strpos( $domain, 'event-' )      === 0;
   
	// If this text domain doesn't start with "tribe-", "the-events-", or "event-" bail.
	if ( ! $is_tribe_domain && ! $is_tec_domain && ! $is_event_domain ) {
	  return false;
	}
   
	return true;
  }
   
  // Base.
  add_filter( 'gettext', 'tribe_custom_theme_text', 20, 3 );
  // Plural-aware translations.
  add_filter( 'ngettext', 'tribe_custom_theme_text_plurals', 20, 5 );
  // Translations with context.
  add_filter( 'gettext_with_context', 'tribe_custom_theme_text_with_context', 20, 4 );
  // Plural-aware translations with context.
  add_filter( 'ngettext_with_context', 'tribe_custom_theme_text_plurals_with_context', 20, 6 );



// Rename "Coupon" code to "Registration" code

add_filter( 'gettext', 'woocommerce_rename_text', 10, 3 );
add_filter( 'gettext', 'woocommerce_rename_text', 10, 3 );
add_filter('woocommerce_coupon_error', 'rename_coupon_label', 10, 3);
add_filter('woocommerce_coupon_message', 'rename_coupon_label', 10, 3);
add_filter('woocommerce_cart_totals_coupon_label', 'rename_coupon_label',10, 1);
add_filter( 'woocommerce_checkout_coupon_message', 'woocommerce_rename_coupon_message_on_checkout' );


function woocommerce_rename_text( $translated_text, $text, $text_domain ) {
	// bail if not modifying frontend woocommerce text
	if ( is_admin() || 'woocommerce' !== $text_domain ) {
		return $translated_text;
	}
	if ( 'Coupon:' === $text ) {
		$translated_text = 'Registration Code:';
	}

	if ('Coupon has been removed.' === $text){
		$translated_text = 'Registration code has been removed.';
	}

	if ( 'Apply coupon' === $text ) {
		$translated_text = 'Apply';
	}

	if ( 'Coupon code' === $text ) {
		$translated_text = 'Registration Code';
	}

	if ( 'Product' === $text ) {
		$translated_text = 'Registration Type';
	}

	if ( 'Products' === $text ) {
		$translated_text = 'Registration Types';
	}

	if ( 'Thank you. Your order has been received.' === $text ) {
		$translated_text = "Thank you. Your registration is confirmed. A receipt has been emailed to you.";
	}

	if ( 'Card Code' === $text ) {
		$translated_text = 'Security Code';
	}

	if ( 'Discount' === $text ) {
		//$translated_text = 'Your Group Rate Savings';
	}

	return $translated_text;
}




// rename the "Have a Coupon?" message on the checkout page
function woocommerce_rename_coupon_message_on_checkout() {
	return 'Have a Registration Code?' . ' ' . __( 'Click here to enter your Registration Code', 'woocommerce' ) . '';
}


function rename_coupon_label($err, $err_code=null, $something=null){

	$err = str_ireplace("Coupon","Registration Code ",$err);

	return $err;
}

wp_oembed_add_provider( '/https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*/', 'http://fast.wistia.com/oembed', true);




// Adding calendar links to event emails

add_action( 'tribe_tickets_ical_links', 'add_export_buttons_to_email' );

function add_export_buttons_to_email( array $ticket ) {
	if ( ! class_exists( 'Tribe__Events__Main' ) ) {
		return;
	}

	global $post;
	$post = get_post( $ticket['event_id'] );

	if ( empty( $post ) ) {
		return;
	}

	$ical_link = add_query_arg( 'ical', '1', get_the_permalink( $post->ID ) );

	// Use the following line if you want to have `webcal://` links, that are wiped by Gmail and others.
	// $ical_link = str_replace( [ 'http://', 'https://' ], 'webcal://', $ical_link );

	$calendar_links = '<table style="padding: 15px;"><div class="tribe-events-cal-links">';
	$calendar_links .= '<a style="font-size: 11px" class="tribe-events-gcal tribe-events-button" href="' . Tribe__Events__Main::instance()->esc_gcal_url( tribe_get_gcal_link() ) . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__( 'Add to Google Calendar', 'the-events-calendar' ) . '">+ ' . esc_html__( 'Google Calendar', 'the-events-calendar' ) . '</a>';
	$calendar_links .= '   ';
	$calendar_links .= '<a  style="font-size: 11px" class="tribe-events-ical tribe-events-button" href="' . esc_url( $ical_link ) . '" title="' . esc_attr__( 'Download .ics file', 'the-events-calendar' ) . '" >+ ' . esc_html__( 'Add to iCalendar', 'the-events-calendar' ) . '</a>';
	$calendar_links .= '</div></table><!-- .tribe-events-cal-links -->';

	echo $calendar_links;
}



// Add "View attendee report" text for Events admin view

add_filter( 'post_row_actions', 'my_action_row', 10, 2 );

function my_action_row( $actions, $post ) {
	if ( $post->post_type == 'tribe_events' ) {
		// check capabilites
		$post_type_object = get_post_type_object( $post->post_type );
		if ( ! $post_type_object ) {
			return;
		}
		if ( ! current_user_can( $post_type_object->cap->edit_post, $post->ID ) ) {
			return;
		}

		// the get the meta and check
		$state = get_post_meta( $post->ID, 'v_state', true );

		 $actions['report'] = "<a class='view' title='" . esc_attr( __( 'View Attendee Report' ) ) . "' target='_blank' href='" . get_site_url() . '/reports/?id=' . $post->ID . "'>" . 'View Report' . '</a>';


	}
	return $actions;
}


require_once("mirren-elements/new-order-sync/new-order-sync.php");

//require_once("mirren-elements/register/register-setup.php");
//require_once("mirren-elements/register-admin/register-admin-setup.php");


	//Confirmation Emails:
// Send email via SMTP

// Set error reporting to only display fatal errors
//error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING);

/*
add_action( 'phpmailer_init', 'setup_phpmailer_init' );
function setup_phpmailer_init( PHPMailer $phpmailer ) {
    $phpmailer->Host = 'smtp.postmarkapp.com';
    $phpmailer->Port = 587;
    $phpmailer->Username = '94509273-4096-4811-af2f-13eb6ecfafdd'; 
    $phpmailer->Password = '94509273-4096-4811-af2f-13eb6ecfafdd'; 
    $phpmailer->SMTPAuth = true; 
    $phpmailer->SMTPSecure = 'tls'; 
    $phpmailer->IsSMTP();
}
*/


/*	
	add_action( 'phpmailer_init', 'my_phpmailer_example' );
	function my_phpmailer_example( $phpmailer ) {
		$phpmailer->isSMTP();     
		$phpmailer->Host = "smtp.postmarkapp.com";
		$phpmailer->Port = 587;
		$phpmailer->Username = "94509273-4096-4811-af2f-13eb6ecfafdd";
		$phpmailer->Password = "94509273-4096-4811-af2f-13eb6ecfafdd";
		$phpmailer->SMTPSecure = "tls";
		
		 // Add custom header
		$phpmailer->addCustomHeader( 'X-PM-Message-Stream: outbound' );
	}

*/

/*
Server: smtp.postmarkapp.com
Port: 587
Authentication
TLS, CRAM-MD5, or Plain text

username: 94509273-4096-4811-af2f-13eb6ecfafdd
password: 94509273-4096-4811-af2f-13eb6ecfafdd

Header: X-PM-Message-Stream: outbound
*/

// Create function for appending to DI log file.
if ( ! function_exists( 'di_debug_log' ) ) {
	function di_debug_log( $entry, $mode = 'a', $file = 'di_debug' ) {
		// Get WordPress content directory.
		$dir = WP_CONTENT_DIR;
		if ( is_object($entry) ) {
			$entry = (array) $entry;
		}
		// If the entry is array, json_encode.
		if ( is_array( $entry ) ) {
			$entry = json_encode( $entry );
		}
		// Write the log file.
		$file  = $dir . '/' . $file . '.log';
		$file  = fopen( $file, $mode );
		$bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" );
		fclose( $file );
		return $bytes;
	}
}

// Show custom fields when ACF is active
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

// Empty cart button functionality
/*add_action( 'woocommerce_proceed_to_checkout', 'di_add_empty_cart_button' );
function di_add_empty_cart_button(){
	echo '<div><a href="'. esc_url( add_query_arg( "empty_cart", "yes" ) ) .'" class="empty-cart checkout-button button alt wc-backward">Empty cart</a></div>';
}*/
add_action( 'wp_loaded', 'di_custom_woocommerce_empty_cart_action', 20 );
function di_custom_woocommerce_empty_cart_action() {
	if ( isset( $_GET['empty_cart'] ) && 'yes' === esc_html( $_GET['empty_cart'] ) ) {
		WC()->cart->empty_cart();
		$referer  = wp_get_referer() ? esc_url( remove_query_arg( 'empty_cart' ) ) : wc_get_cart_url();
		wp_safe_redirect( $referer );
	}
}

// Use each bundled product's ACF quantity as its cart input step
add_filter( 'woocommerce_cart_item_quantity', 'di_bundled_products_quantity_input_adjust', 10, 3 );
function di_bundled_products_quantity_input_adjust($product_quantity, $cart_item_key, $cart_item){
	$product_id = $cart_item['product_id'];
	$is_bundled = get_field( 'bundled_product', $product_id );
	if ( $is_bundled == 1 ) {
		$step = max( 1, absint( get_field( 'bundled_quantity', $product_id ) ) );
		$product_quantity = str_replace( 'class="input-text', 'class="bundled-qty input-text', $product_quantity );
		$product_quantity = str_replace( 'step="1"', 'step="'. $step .'" onkeydown="return false"', $product_quantity );
		$product_quantity = str_replace( '</div>', '<input type="number" class="bundled input-text qty text" value="1" aria-label="Product quantity" size="4" min="0" max="" step="1" onkeydown="return false" placeholder="" inputmode="numeric" autocomplete="off"></div>', $product_quantity );
	}
	return $product_quantity;
}

/**
 * Return the ticket product IDs a user has purchased for an event.
 *
 * This uses the same Event Tickets attendee/order lookup as the ticket
 * management page, so a child bundle is available only when the current user
 * has a valid attendee record for its configured parent ticket.
 *
 * @param int $event_id Event post ID.
 * @param int $user_id  WordPress user ID. Defaults to the current user.
 * @return array Purchased product IDs keyed by product ID.
 */
function di_get_user_purchased_event_ticket_product_ids(
	$event_id,
	$user_id = 0
) {
	static $purchased_product_ids_by_user_event = array();

	$event_id = absint( $event_id );
	$user_id  = $user_id ? absint( $user_id ) : get_current_user_id();

	if (
		! $event_id ||
		! $user_id ||
		! class_exists( 'Tribe__Tickets__Tickets_View' )
	) {
		return array();
	}

	$cache_key = $user_id . ':' . $event_id;

	if ( isset( $purchased_product_ids_by_user_event[ $cache_key ] ) ) {
		return $purchased_product_ids_by_user_event[ $cache_key ];
	}

	$purchased_product_ids = array();
	$view                  = Tribe__Tickets__Tickets_View::instance();
	$orders                = $view->get_event_attendees_by_order(
		$event_id,
		$user_id
	);

	if ( is_array( $orders ) ) {
		foreach ( $orders as $tickets ) {
			if ( ! is_array( $tickets ) ) {
				continue;
			}

			foreach ( $tickets as $ticket ) {
				$product_id = isset( $ticket['product_id'] )
					? absint( $ticket['product_id'] )
					: 0;

				if ( $product_id ) {
					$purchased_product_ids[ $product_id ] = true;
				}
			}
		}
	}

	$purchased_product_ids_by_user_event[ $cache_key ] =
		$purchased_product_ids;

	return $purchased_product_ids;
}

/**
 * Remove bundled add-ons whose configured parent is neither in the cart nor
 * previously purchased by the current user.
 *
 * This runs after WooCommerce processes the submitted cart quantities and when
 * the cart is loaded as a fallback for a stale session that already contains an
 * orphaned add-on.
 *
 * @param WC_Cart $cart Cart instance.
 * @return bool Whether at least one orphaned add-on was removed.
 */
function di_remove_orphaned_bundled_cart_items( $cart ) {
	static $is_syncing = false;

	if (
		$is_syncing ||
		! $cart instanceof WC_Cart ||
		! function_exists( 'get_field' )
	) {
		return false;
	}

	$is_syncing                  = true;
	$removed_any                 = false;
	$user_id                     = get_current_user_id();
	$purchased_products_by_event = array();

	do {
		$removed_item       = false;
		$cart_product_ids   = array();
		$cart_items         = $cart->get_cart();

		foreach ( $cart_items as $cart_item ) {
			$product_id = isset( $cart_item['product_id'] )
				? absint( $cart_item['product_id'] )
				: 0;

			$quantity = isset( $cart_item['quantity'] )
				? (int) $cart_item['quantity']
				: 0;

			if ( $product_id && $quantity > 0 ) {
				$cart_product_ids[ $product_id ] = true;
			}
		}

		foreach ( $cart_items as $cart_item_key => $cart_item ) {
			$product_id = isset( $cart_item['product_id'] )
				? absint( $cart_item['product_id'] )
				: 0;

			if (
				! $product_id ||
				! get_field( 'bundled_product', $product_id )
			) {
				continue;
			}

			$parent_id = absint(
				get_field( 'parent_id', $product_id )
			);

			if (
				! $parent_id ||
				isset( $cart_product_ids[ $parent_id ] )
			) {
				continue;
			}

			/*
			 * A logged-in purchaser may buy additional standalone bundles from
			 * the event's ticket-management page after buying the parent ticket.
			 */
			$parent_event_id = absint(
				get_post_meta(
					$parent_id,
					'_tribe_wooticket_for_event',
					true
				)
			);

			if ( $user_id && $parent_event_id ) {
				if (
					! isset(
						$purchased_products_by_event[
							$parent_event_id
						]
					)
				) {
					$purchased_products_by_event[ $parent_event_id ] =
						di_get_user_purchased_event_ticket_product_ids(
							$parent_event_id,
							$user_id
						);
				}

				if (
					isset(
						$purchased_products_by_event[
							$parent_event_id
						][ $parent_id ]
					)
				) {
					continue;
				}
			}

			if ( $cart->remove_cart_item( $cart_item_key ) ) {
				$removed_item = true;
				$removed_any  = true;
			}
		}
	} while ( $removed_item );

	$is_syncing = false;

	return $removed_any;
}

/**
 * Remove orphaned add-ons after WooCommerce applies the Update cart request.
 *
 * At this point a submitted parent quantity of zero has already removed the
 * parent from the cart, so the ACF parent_id relationship can be evaluated
 * against the final submitted cart state. A child is retained when the current
 * user already purchased that parent ticket for the same event.
 *
 * @param bool $cart_updated Whether WooCommerce changed the cart.
 * @return bool
 */
function di_remove_orphaned_bundled_cart_items_after_update( $cart_updated ) {
	if (
		function_exists( 'WC' ) &&
		WC()->cart instanceof WC_Cart &&
		di_remove_orphaned_bundled_cart_items( WC()->cart )
	) {
		$cart_updated = true;
	}

	return $cart_updated;
}

add_filter(
	'woocommerce_update_cart_action_cart_updated',
	'di_remove_orphaned_bundled_cart_items_after_update'
);

add_action(
	'woocommerce_cart_loaded_from_session',
	'di_remove_orphaned_bundled_cart_items',
	10
);

// ACF-first ticket pricing.
/**
 * Normalize an ACF or WooCommerce price value.
 *
 * Currency symbols and thousands separators are allowed in the ACF text
 * fields. A numeric zero is a valid configured price; false means that the
 * value was missing or invalid and the next fallback should be used.
 *
 * @param mixed $raw_price Raw price value.
 * @return float|false
 */
function di_normalize_ticket_price( $raw_price ) {
	if (
		false === $raw_price ||
		null === $raw_price ||
		is_array( $raw_price ) ||
		is_object( $raw_price )
	) {
		return false;
	}

	$price = trim( (string) $raw_price );

	if ( '' === $price ) {
		return false;
	}

	$price = str_replace( ',', '', $price );
	$price = preg_replace( '/[^\d.\-]/', '', $price );

	if ( ! is_numeric( $price ) ) {
		return false;
	}

	$price = (float) $price;

	return $price >= 0 ? $price : false;
}

/**
 * Return one normalized ACF ticket-price field.
 *
 * @param int    $product_id Product/ticket ID.
 * @param string $field_name ACF field name.
 * @return float|false
 */
function di_get_ticket_acf_price( $product_id, $field_name ) {
	if (
		! function_exists( 'get_field' ) ||
		! in_array( $field_name, array( 'sale_price', 'normal_price' ), true )
	) {
		return false;
	}

	return di_normalize_ticket_price(
		get_field( $field_name, absint( $product_id ) )
	);
}

/**
 * Return the raw attendee quantity represented by one displayed purchase.
 *
 * Standard tickets use one. Bundled tickets use their ACF bundled_quantity.
 *
 * @param int $product_id Product/ticket ID.
 * @return int
 */
function di_get_ticket_quantity_step( $product_id ) {
	if (
		! function_exists( 'get_field' ) ||
		! get_field( 'bundled_product', absint( $product_id ) )
	) {
		return 1;
	}

	return max(
		1,
		absint( get_field( 'bundled_quantity', absint( $product_id ) ) )
	);
}

/**
 * Resolve the authoritative price for any ticket product.
 *
 * Fallback order:
 * 1. ACF sale_price.
 * 2. ACF normal_price.
 * 3. The native WooCommerce/Event Tickets price.
 *
 * A bundled ACF price is the exact price for one displayed bundle. Its unit
 * price is divided by bundled_quantity because WooCommerce stores the raw
 * attendee-ticket quantity in the cart. A native fallback is already a unit
 * price, so it is multiplied only for the customer-facing bundle display.
 *
 * @param int   $product_id         Product/ticket ID.
 * @param mixed $default_unit_price Optional native unit price.
 * @return array|false
 */
function di_get_ticket_pricing( $product_id, $default_unit_price = false ) {
	$product_id = absint( $product_id );

	if ( ! $product_id ) {
		return false;
	}

	$quantity_step    = di_get_ticket_quantity_step( $product_id );
	$acf_sale_price   = di_get_ticket_acf_price( $product_id, 'sale_price' );
	$acf_normal_price = di_get_ticket_acf_price( $product_id, 'normal_price' );
	$source            = 'default';

	if ( false !== $acf_sale_price ) {
		$display_price = $acf_sale_price;
		$source        = 'sale_price';
	} elseif ( false !== $acf_normal_price ) {
		$display_price = $acf_normal_price;
		$source        = 'normal_price';
	} else {
		$default_unit_price = di_normalize_ticket_price(
			$default_unit_price
		);

		if ( false === $default_unit_price && function_exists( 'wc_get_product' ) ) {
			$default_product = wc_get_product( $product_id );

			if ( $default_product instanceof WC_Product ) {
				$default_unit_price = di_normalize_ticket_price(
					$default_product->get_price( 'edit' )
				);

				if ( false === $default_unit_price ) {
					$default_unit_price = di_normalize_ticket_price(
						$default_product->get_regular_price( 'edit' )
					);
				}
			}
		}

		if ( false === $default_unit_price ) {
			return false;
		}

		$display_price = $default_unit_price * $quantity_step;
	}

	return array(
		'source'           => $source,
		'display_price'    => $display_price,
		'unit_price'       => $display_price / $quantity_step,
		'quantity_step'    => $quantity_step,
		'acf_sale_price'   => $acf_sale_price,
		'acf_normal_price' => $acf_normal_price,
	);
}

/**
 * Return authoritative pricing for a WooCommerce cart item.
 *
 * @param array $cart_item WooCommerce cart item.
 * @return array|false
 */
function di_get_cart_item_ticket_pricing( $cart_item ) {
	if (
		empty( $cart_item['product_id'] ) ||
		empty( $cart_item['data'] ) ||
		! $cart_item['data'] instanceof WC_Product
	) {
		return false;
	}

	return di_get_ticket_pricing( absint( $cart_item['product_id'] ) );
}

/**
 * Set the internal per-ticket price before WooCommerce calculates cart totals.
 *
 * This applies to bundled and standard tickets alike. Checkout and order-item
 * totals inherit this value, so later order details and emails retain the exact
 * price paid even if the product's ACF fields change.
 */
add_action(
	'woocommerce_before_calculate_totals',
	'di_force_exact_ticket_prices',
	9999
);
function di_force_exact_ticket_prices( $cart ) {
	if (
		( is_admin() && ! defined( 'DOING_AJAX' ) ) ||
		! $cart instanceof WC_Cart
	) {
		return;
	}

	foreach ( $cart->get_cart() as $cart_item ) {
		$pricing = di_get_cart_item_ticket_pricing( $cart_item );

		if ( ! $pricing || 'default' === $pricing['source'] ) {
			continue;
		}

		$cart_item['data']->set_price(
			$pricing['unit_price']
		);
	}
}
/**
 * Display the configured purchase price in the cart's Price column.
 *
 * Bundled rows show the price for one displayed bundle rather than the
 * internal per-attendee unit price. Standard rows show the selected ACF price.
 */
add_filter(
	'woocommerce_cart_item_price',
	'di_display_exact_ticket_cart_price',
	9999,
	3
);
function di_display_exact_ticket_cart_price(
	$price_html,
	$cart_item,
	$cart_item_key
) {
	$pricing = di_get_cart_item_ticket_pricing( $cart_item );

	if (
		! $pricing ||
		! function_exists( 'WC' ) ||
		! WC()->cart
	) {
		return $price_html;
	}

	if (
		'default' === $pricing['source'] &&
		1 === $pricing['quantity_step']
	) {
		return $price_html;
	}

	$display_product = clone $cart_item['data'];

	$display_product->set_price(
		$pricing['display_price']
	);

	return WC()->cart->get_product_price(
		$display_product
	);
}
// End ACF-first ticket pricing.

// Modify proceed to checkout button text on cart page
add_filter('gettext', 'di_change_proceed_to_checkout_text', 20, 3);
function di_change_proceed_to_checkout_text($translated_text, $text, $domain) {
    if ($text === 'Proceed to checkout') {
        $translated_text = 'Next';
    }
    return $translated_text;
}

// Removes the "Optional" placeholder that is shown by default when IAC settings are set to "Allow"
add_filter( 'tribe_tickets_plus_attendee_registration_iac_fields', 'di_rework_attendee_fields', 10, 3 );
function di_rework_attendee_fields( $fields, $ticket_iac_setting, $ticket_id ){
	if ( $fields ) {
		foreach ( $fields as $type => $field ) {
			$fields[$type]['placeholder'] = '';
		}
	}
	return $fields;
}

// Add "Back" button to checkout
add_action('woocommerce_checkout_before_customer_details', function(){
	echo '<a href="'. get_site_url() .'/attendee-registration/?tickets_provider=tribe_wooticket">&lt; Back</a>';
}, 10);

// Modify checkout billing fields
add_filter('woocommerce_checkout_fields', 'didi_override_checkout_fields', 99999);
function didi_override_checkout_fields($fields)
{
	$fields['billing']['billing_postcode']['placeholder'] = 'Zip/Postal Code';
	$fields['billing']['billing_postcode']['label'] = 'Zip/Postal Code';

	return $fields;
}
add_filter( 'woocommerce_default_address_fields' , 'di_override_checkout_fields', 99999 );
function di_override_checkout_fields( $fields ) {

    $fields['city']['label'] = 'City';
	$fields['address_1']['label'] = "Billing Address";
	$fields['address_1']['placeholder'] = "Billing Address";
	$fields['billing_postcode']['label'] = 'Zip/Postal Code';
	$fields['billing_postcode']['placeholder'] = 'Zip/Postal Code';
	
    return $fields;
}

// Auto check "create an account" at checkout
add_filter('woocommerce_create_account_default_checked' , function ($checked){
	return true;
});

// Customize Stripe Checkout Field Appearance
add_filter( 'wc_stripe_upe_params', function ( $stripe_params ) {

	// Affects block checkout
	$stripe_params['blocksAppearance'] = (object) [ 'theme' => 'stripe' ];
	/*$stripe_params['blocksAppearance'] = (object) [ 
		//'theme' => 'night',
		'variables' => (object) [
			'colorIcon' => '#0D9EE8',
			'colorDanger' => '#ff0000',
			'iconCardErrorColor' => '#ff0000',
			'iconCardCvcErrorColor' => '#ff0000',
		],
		'iconStyle' => 'solid',
		'rules' => (object) [
			'.Label' => (object) [
				'color' => 'rgba(255,255,255,.8)',
			],
			'.Input' => (object) [
				'backgroundColor' => '#1F3D56',
				'borderColor' => '#0D9EE8',
				'color' => '#ffffff',
				'fontSize' => '16px',
			],
			'.Input::placeholder' => (object) [
				'color' => 'rgba(255,255,255,0.5)',
			],
			'.Input--invalid, .Label--invalid, .Error' => (object) [
				//'color' => '#ff0000',
			],
		],
	];*/

	// Affects shortcode checkout
	$stripe_params['appearance'] = (object) [ 'theme' => 'stripe'	];
	/*$stripe_params['appearance'] = (object) [ 
		//'theme' => 'night',
		'variables' => (object) [
			'colorIcon' => '#0D9EE8',
			'colorDanger' => '#ff0000',
			'iconCardErrorColor' => '#ff0000',
			'iconCardCvcErrorColor' => '#ff0000',
		],
		'iconStyle' => 'solid',
		'rules' => (object) [
			'.Label' => (object) [
				'color' => 'rgba(255,255,255,.8)',
			],
			'.Input' => (object) [
				'backgroundColor' => '#1F3D56',
				'borderColor' => '#0D9EE8',
				'color' => '#ffffff',
				'fontSize' => '16px',
			],
			'.Input::placeholder' => (object) [
				'color' => 'rgba(255,255,255,0.5)',
			],
			'.Input--invalid, .Label--invalid, .Error' => (object) [
				//'color' => '#ff0000',
			],
		],
	];*/
	
	return $stripe_params;
} );
// Clear Stripe's appearance transients
// Shortcode checkout
delete_transient( 'wc_stripe_appearance' );
// Block checkout
delete_transient( 'wc_stripe_blocks_appearance' );
// End Customize Stripe Checkout Field Appearance

/**
 * Get the purchaser's billing details when an attendee was automatically
 * assigned because no IAC name was submitted.
 *
 * @return array|false
 */
function mirren_get_auto_assigned_attendee_details( $order_id, $ticket_id, $attendee_number ) {
	if (
		null === $attendee_number ||
		! function_exists( 'wc_get_order' ) ||
		! function_exists( 'tribe' )
	) {
		return false;
	}

	$order = wc_get_order( $order_id );

	if ( ! $order instanceof WC_Order ) {
		return false;
	}

	try {
		$iac  = tribe( 'tickets-plus.attendee-registration.iac' );
		$meta = tribe( 'tickets-plus.meta' );
	} catch ( Throwable $e ) {
		return false;
	}

	if (
		! is_object( $iac ) ||
		! method_exists( $iac, 'get_iac_setting_for_ticket' ) ||
		'none' === $iac->get_iac_setting_for_ticket( $ticket_id ) ||
		! is_object( $meta ) ||
		! method_exists( $meta, 'get_meta_field_value_from_key_for_attendee' ) ||
		! method_exists( $meta, 'get_meta_fields_by_ticket' )
	) {
		return false;
	}

	/*
	 * Confirm that this ticket has the custom Last Name field. This limits
	 * the name adjustment to ticket fieldsets configured for split names.
	 */
	$has_last_name_field = false;

	foreach ( $meta->get_meta_fields_by_ticket( $ticket_id ) as $field ) {
		if ( isset( $field->slug ) && 'last-name' === $field->slug ) {
			$has_last_name_field = true;
			break;
		}
	}

	if ( ! $has_last_name_field ) {
		return false;
	}

	/*
	 * TEC stores the originally submitted IAC values by ticket and
	 * attendee index. A missing or blank IAC name means TEC will use
	 * the purchaser-name fallback.
	 */
	$submitted_name = $meta->get_meta_field_value_from_key_for_attendee(
		'tribe-tickets-plus-iac-name',
		(int) $ticket_id,
		(int) $attendee_number,
		(int) $order_id
	);

	if ( '' !== trim( (string) $submitted_name ) ) {
		return false;
	}

	$first_name  = trim( (string) $order->get_billing_first_name() );
	$last_name   = trim( (string) $order->get_billing_last_name() );
	$company_name = trim( (string) $order->get_meta( 'company_name', true ) );

	if (
		'' === $first_name &&
		'' === $last_name &&
		'' === $company_name
	) {
		return false;
	}

	return array(
		'first_name'   => $first_name,
		'last_name'    => $last_name,
		'company_name' => $company_name,
	);
}

/**
 * Replace TEC's purchaser full-name fallback with the purchaser's billing
 * first name.
 */
function mirren_filter_auto_assigned_attendee_name(
	$attendee_name,
	$attendee_number,
	$order_id,
	$ticket_id,
	$post_id,
	$provider
) {
	$details = mirren_get_auto_assigned_attendee_details(
		$order_id,
		$ticket_id,
		$attendee_number
	);

	if ( false === $details || '' === $details['first_name'] ) {
		return $attendee_name;
	}

	return sanitize_text_field( $details['first_name'] );
}
add_filter(
	'tribe_tickets_attendee_create_individual_name',
	'mirren_filter_auto_assigned_attendee_name',
	20,
	6
);

/**
 * Populate the custom Last Name and Company fields for tickets that were
 * automatically assigned to the purchaser.
 */
function mirren_populate_auto_assigned_attendee_meta(
	$attendee_meta,
	$attendee_id,
	$order_id,
	$ticket_id,
	$attendee_number
) {
	$details = mirren_get_auto_assigned_attendee_details(
		$order_id,
		$ticket_id,
		$attendee_number
	);

	/*
	 * The helper returns false when attendee details were explicitly
	 * submitted, so explicitly assigned attendees remain untouched.
	 */
	if ( false === $details ) {
		return $attendee_meta;
	}

	$current_last_name = isset( $attendee_meta['last-name'] )
		? trim( (string) $attendee_meta['last-name'] )
		: '';

	// Never overwrite an explicitly supplied last name.
	if (
		'' === $current_last_name &&
		'' !== $details['last_name']
	) {
		$attendee_meta['last-name'] = sanitize_text_field(
			$details['last_name']
		);
	}

	$current_company = isset( $attendee_meta['company'] )
		? trim( (string) $attendee_meta['company'] )
		: '';

	// Never overwrite an explicitly supplied company.
	if (
		'' === $current_company &&
		'' !== $details['company_name']
	) {
		$attendee_meta['company'] = sanitize_text_field(
			$details['company_name']
		);
	}

	return $attendee_meta;
}
add_filter(
	'tribe_tickets_plus_attendee_save_meta',
	'mirren_populate_auto_assigned_attendee_meta',
	20,
	5
);

// View Thank You Page @ Edit Order Admin
add_filter( 'woocommerce_order_actions', 'di_show_thank_you_page_order_admin_actions', 9999, 2 );
function di_show_thank_you_page_order_admin_actions( $actions, $order ) {
   if ( $order->has_status( wc_get_is_paid_statuses() ) ) {
      $actions['view_thankyou'] = 'Display thank you page';
   }
   return $actions;
}
add_action( 'woocommerce_order_action_view_thankyou', 'di_redirect_thank_you_page_order_admin_actions' );
function di_redirect_thank_you_page_order_admin_actions( $order ) {
   $url = add_query_arg( 'adm', $order->get_customer_id(), $order->get_checkout_order_received_url() );
   add_filter( 'redirect_post_location', function() use ( $url ) {
      return $url;
   });
}
add_filter( 'determine_current_user', 'di_admin_becomes_user_if_viewing_thank_you_page' );
function di_admin_becomes_user_if_viewing_thank_you_page( $user_id ) {
   if ( ! empty( $_GET['adm'] ) ) {
      $user_id = wc_clean( wp_unslash( $_GET['adm'] ) );
   }
   return $user_id;
}
// End View Thank You Page @ Edit Order Admin

// Keep users logged in for a year
function stay_logged_in_1_year( $expirein ) {
    return YEAR_IN_SECONDS; // 1 year in seconds
}
add_filter( 'auth_cookie_expiration', 'stay_logged_in_1_year', 99999 );

/**
 * Return the event ID selected in the Active Event options field.
 *
 * The ACF relationship field has a maximum of one selection, but its value is
 * still returned as an array.
 *
 * @return int
 */
function di_get_active_mirren_event_id() {
	if ( ! function_exists( 'get_field' ) ) {
		return 0;
	}

	$active_event = get_field( 'active_mirren_event', 'option' );

	if ( is_array( $active_event ) ) {
		$active_event = reset( $active_event );
	}

	if ( $active_event instanceof WP_Post ) {
		$active_event = $active_event->ID;
	}

	$event_id = absint( $active_event );

	if ( ! $event_id || 'tribe_events' !== get_post_type( $event_id ) ) {
		return 0;
	}

	return $event_id;
}

/**
 * Return the attendee-management URL for the active Mirren event.
 *
 * @return string
 */
function di_get_active_mirren_event_tickets_url() {
	$event_id = di_get_active_mirren_event_id();

	if ( ! $event_id ) {
		return '';
	}

	$event_url = get_permalink( $event_id );

	if ( ! $event_url ) {
		return '';
	}

	return trailingslashit( $event_url ) . 'tickets/';
}

// Redirect from manage attendees page to my account if logged out (since it otherwise displays a blank page)
function di_redirect_tickets_to_account() {
	if ( is_user_logged_in() ) {
		return;
	}

	$manage_attendees_url = di_get_active_mirren_event_tickets_url();
	$request_uri          = isset( $_SERVER['REQUEST_URI'] )
		? wp_unslash( $_SERVER['REQUEST_URI'] )
		: '';
	$request_path         = untrailingslashit(
		(string) wp_parse_url( $request_uri, PHP_URL_PATH )
	);
	$manage_attendees_path = untrailingslashit(
		(string) wp_parse_url( $manage_attendees_url, PHP_URL_PATH )
	);

	if (
		! $manage_attendees_path ||
		$request_path !== $manage_attendees_path
	) {
		return;
	}

	$my_account_url = get_permalink(
		get_option( 'woocommerce_myaccount_page_id' )
	);

	if ( $my_account_url ) {
		wp_safe_redirect( $my_account_url );
		exit;
	}
}
add_action( 'wp_loaded', 'di_redirect_tickets_to_account');

// My account before orders (if has_orders) add manage tickets button
add_action( 'woocommerce_before_account_orders', 'di_add_manage_tickets_btn_account', 10, 1 );
function di_add_manage_tickets_btn_account($has_orders) {
	if ( $has_orders ) {
		$btn_text             = get_field( 'manage_attendees_button_text', 'options' );
		$manage_attendees_url = di_get_active_mirren_event_tickets_url();
		echo '<div style="margin-bottom: 24px; text-align: center;">';
		if ( $manage_attendees_url ) {
			echo '<a href="' . esc_url( $manage_attendees_url ) . '" class="empty-cart checkout-button button alt wc-backward" style="margin-right: 12px;">' . $btn_text . '</a>';
		}
		
		$view = Tribe__Tickets__Tickets_View::instance();
		$user_id   = get_current_user_id();
		$event_id = di_get_active_mirren_event_id();
		$has_orders = false;
		$purchased_v_standard = false;
		$purchased_v_access = false;
		if ( $event_id && $user_id && $user_id !== 0 ) {
			$orders = $view->get_event_attendees_by_order( $event_id, $user_id );
			if ( !empty( $orders ) ) {
				$has_orders = true;
				foreach ( $orders as $order_id => $tickets ) {
					foreach ( $tickets as $ticket ) {
						if ( $ticket['product_id'] == '178' ) {
							$purchased_v_standard = true;
						}
						if ( $ticket['product_id'] == '179' ) {
							$purchased_v_access = true;
						}
					}
				}
			}
		}
		if ( $purchased_v_standard === true || $purchased_v_access === true ) {
		//if ( $purchased_v_access === true ) {
		//if ( $has_orders === true ) {
			if ( $manage_attendees_url ) {
				echo '<a href="' . esc_url( $manage_attendees_url ) . '" class="button">' . get_field( 'purchase_more_bundles_button_text', 'options' ) . '</a>';
			}
		}
		echo '</div>';
	}
}

// Modify "please log in" link at checkout
add_filter( 'woocommerce_registration_error_email_exists', 'custom_wc_login_error_message', 10, 2 );
function custom_wc_login_error_message( $error, $email ) {
	$login_url = wc_get_page_permalink( 'myaccount' ); // or use a custom URL here
	$custom_error = sprintf(
		__( 'An account is already registered with your email address. <a href="%s" target="_blank">Please log in</a> and check out again.', 'woocommerce' ),
		esc_url( $login_url )
	);
	return $custom_error;
}

// My account redirect all other pages to order history
add_action( 'template_redirect', 'di_my_account_custom_redirects' );
function di_my_account_custom_redirects() {
	if ( is_user_logged_in() ) {
		global $wp;
		//di_debug_log( $wp->request );
		//di_debug_log( parse_url( $wp->request, PHP_URL_PATH ) );
		$paths = array( 'my-account', 'my-account/downloads', 'my-account/edit-address', 'my-account/payment-methods', 'my-account/edit-account' );
		if ( in_array( parse_url( $wp->request, PHP_URL_PATH ), $paths ) ) {
			wp_redirect( home_url( '/my-account/orders/' ) );
			exit();
		}
	}
}

// Rename WooCommerce "Processing" order status
add_filter( 'wc_order_statuses', 'di_rename_order_status_msg', 20, 1 );
function di_rename_order_status_msg( $order_statuses ) {
	// Statuses: wc-pending, wc-on-hold, wc-processing, wc-completed
	$order_statuses['wc-processing'] = _x( 'Order Placed', 'Order status', 'woocommerce' );
	return $order_statuses;
}

// Manage Attendees
add_filter( 'tribe_tickets_ticket_type_moved_email_recipient', 'disable_email_when_moving_ticket' );
 // Disables the notification email when a ticket is moved
function disable_email_when_moving_ticket( $email_addr ) {
    if ( $_POST['action'] == 'move_ticket_type' ) {
        return '';  // Or invalid email
    }
    return $email_addr;
}
// Disables the notification email when an attendee is moved
add_filter( 'tribe_tickets_ticket_moved_email_recipient', '__return_null' );


/**
 * Set the Reply-To address for Event Tickets emails.
 *
 * The email address is managed through the ACF Options field:
 * tec_ticket_email_reply_to
 *
 * @param array $headers Email headers.
 *
 * @return array
 */
function di_tec_event_tickets_reply_to( $headers ) {

	if ( ! function_exists( 'get_field' ) ) {
		return $headers;
	}

	$reply_to = get_field( 'tec_ticket_email_reply_to', 'option' );

	if ( empty( $reply_to ) ) {
		return $headers;
	}

	$reply_to = sanitize_email( $reply_to );

	if ( ! is_email( $reply_to ) ) {
		return $headers;
	}

	$headers['Reply-To'] = $reply_to;

	return $headers;
}

add_filter( 'tec_tickets_emails_dispatcher_ticket_headers', 'di_tec_event_tickets_reply_to' );
add_filter( 'tec_tickets_emails_dispatcher_rsvp_headers', 'di_tec_event_tickets_reply_to' );
add_filter( 'tec_tickets_emails_dispatcher_rsvp-not-going_headers', 'di_tec_event_tickets_reply_to' );
add_filter( 'tec_tickets_emails_dispatcher_completed-order_headers', 'di_tec_event_tickets_reply_to' );
add_filter( 'tec_tickets_emails_dispatcher_purchase-receipt_headers', 'di_tec_event_tickets_reply_to' );


/**
 * Change admin email in notifications.
 *
 * This applies to password change notifications.
 *
 * @param (array) $pass_change_email Used to build wp_mail().
 * @param (array) The original user array.
 * @param (array) The updated user array.
 *
 * @return (array) $pass_change_email Updated wp_mail() content.
 */
add_filter('password_change_email', 'di_replace_admin_email_in_notification_emails', 10, 3);
function di_replace_admin_email_in_notification_emails( $pass_change_email, $user, $userdata ) {
	$pass_change_email['message'] = str_replace( '###ADMIN_EMAIL###', 'events@hello.mirren.com', $pass_change_email['message'] );

	return $pass_change_email;
}

/***** Cron that forces attendee updates *****/
// Initially set up because Event Tickets front end attendee updates were not triggering "attendee updated" Zaps
/*function cron_di_force_attendee_update_for_zapier_4ebe5b89() {
	
	// Calling wp_update_post on the attendee ID will trigger the "attendee updated" Zaps
	
	//$offset = (int) get_field('attendee_update_cron_offset', 'options');
	$offset = 290;
	
	$args = array(
		//'p'				=> 5349,
		'post_type'		=> 'tribe_wooticket',
		//'numberposts'	=> -1,
		'numberposts'	=> 10,
		'offset'		=> $offset,
		'fields'		=> 'ids',
	);
	$attendees = get_posts($args);
	
	if ( $attendees ) {
		
		$u = 0;
		$f = 0;
		$failed_arr = array();
		foreach ( $attendees as $attendee_id ) {

			$update = wp_update_post( array( 'ID' => $attendee_id ), true );

			if ( is_wp_error( $update ) || $update === 0 ) {
				//di_debug_log($attendee_id . ' attendee update failed');
				$failed_arr[] = $attendee_id;
				$f++;
			} else {
				//di_debug_log($attendee_id . ' attendee updated');
				$u++;
			}

			usleep(100000); // pause for 0.1 second

		}

		$offset = $offset + $u;
		
		//update_field('attendee_update_cron_offset', $offset, 'options');
		
		di_debug_log( $u . ' attendees updated. ' . $f . ' failed updates. Currently at offset ' . $offset . '.' );
		
		if ( $failed_arr ) {
			di_debug_log( 'Failed attendee updates: ' . $failed_arr );
		}
		
	} else {
		
		di_debug_log( 'No attendees to update. Currently at offset ' . $offset );
		
	}
	
}
add_action( 'di_force_attendee_update_for_zapier', 'cron_di_force_attendee_update_for_zapier_4ebe5b89', 10, 0 );
*/
/*
// Cron job to reset the attendee update offset field
function cron_di_reset_offset_for_attendee_update_cron_b0e2a20f() {
    
	update_field('attendee_update_cron_offset', '0', 'options');
	
}
//add_action( 'di_reset_offset_for_attendee_update_cron', 'cron_di_reset_offset_for_attendee_update_cron_b0e2a20f', 10, 0 );*/
/***** End Cron that forces attendee updates *****/



// Temporary fix for front end attendee updates (still in use because they haven't fixed the issue)
function di_trigger_update_on_front_end_attendee_update( $attendee_id, $data_to_save, $data, $order_id, $product_id, $event_id, $provider ){
	if ( !$attendee_id || $attendee_id == 0 ) return; // Not really a necessary check as it's already done by the plugin
	wp_update_post( array( 'ID' => $attendee_id ), true );
}
add_action( 'tribe_tickets_plus_after_my_tickets_attendee_update', 'di_trigger_update_on_front_end_attendee_update', 10, 7 );


/* Update the login duration for password protected posts to three weeks */
add_action( 'wp', 'post_pw_sess_expire' );
 function post_pw_sess_expire() {
    if ( isset( $_COOKIE['wp-postpass_' . COOKIEHASH] ) ){
		setcookie('wp-postpass_' . COOKIEHASH, $_COOKIE['wp-postpass_' . COOKIEHASH], time() + 86400 * 21, COOKIEPATH);
	}
}



function custom_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
	This event is password-protected. Enter your password below in ALL CAPS<br><br>
	<span style="color: #000;">Your unique agency password is: </span><span style="color: #6975FC; font-weight: 600;">CYAN4556</span>
	<br><br>
	<label for="' . $label . '">Password: </label>
	<input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" />
	<input type="submit" name="Submit" value="' . esc_attr__("Submit") . '" />
	</form>';
	return $output;
}
add_filter('the_password_form', 'custom_password_form');

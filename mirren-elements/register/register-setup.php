<?php


add_action( 'admin_post_registrant_submit', 'registrant_submit');
add_action( 'admin_post_nopriv_registrant_submit', 'registrant_submit');

function registrant_submit(){

	global $wpdb;

	$data = json_encode($_POST);

	echo $data;
	echo "<br /><br />";
	echo "Cart: ".$_POST['cart'];

	for ($i=0;$i<count($_POST['registrant-num']);$i++){
		$wpdb->insert("wp_attendee_data", array( 
			'attendee_data' => $data,
			'attendee_timestamp' => date("YmdHis"),
			'attendee_cart_id' => $_POST['cart'],
			'attendee_product' => sanitize_text_field($_POST['registrant-product'][$i]),
			'attendee_product_name' => sanitize_text_field($_POST['registrant-product-name'][$i]),
			'attendee_first_name' => sanitize_text_field($_POST['first-name'][$i]),
			'attendee_last_name' => sanitize_text_field($_POST['last-name'][$i])
		));
	}
	
	header('Location: '.get_site_url()."/checkout/");
    die();

}


//Add to Cart Functionality: 
	add_action('wp_enqueue_scripts', 'enqueue_add_to_cart_script');
	function enqueue_add_to_cart_script() {
		wp_enqueue_script('add-to-cart-js', get_stylesheet_directory_uri() . '/mirren-elements/register/add-to-cart.js', array('jquery'), '1.0', true);

		// Localize the script with the AJAX URL
		wp_localize_script('add-to-cart-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
	}


	// AJAX function to add a single product to to the cart
	add_action('wp_ajax_add_product_to_cart', 'add_product_to_cart');
	add_action('wp_ajax_nopriv_add_product_to_cart', 'add_product_to_cart');
	function add_product_to_cart() {
		$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

		if ($product_id > 0) {
			WC()->cart->add_to_cart($product_id);
			echo 'success'; // You can return any response you want
		} else {
			echo 'error';
		}

		wp_die();
	}


	// AJAX function to add multiple products to to the cart
	add_action('wp_ajax_add_product_to_cart_multi', 'add_product_to_cart_multi');
	add_action('wp_ajax_nopriv_add_product_to_cart_multi', 'add_product_to_cart_multi');
	function add_product_to_cart_multi() {
		
		global $wpdb;
		$data = json_encode($_POST);
	
		$productData = $_POST['product_data'];
		for ($i=0;$i<count($productData);$i++){
			if ($productData[$i]['qty'] > 0){
				WC()->cart->add_to_cart($productData[$i]['id'],$productData[$i]['qty']);
			}
			else{
				echo "Error";
			}
		}
		
		
	
		/*
		$wpdb->insert("wp_attendee_data", array( 
			'attendee_data' => $_POST['product_data'][0]['id']
		));
	*/
		
		/*
		$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

		if ($product_id > 0) {
			WC()->cart->add_to_cart($product_id);
			echo 'success'; // You can return any response you want
		} else {
			echo 'error';
		}
*/
		//wp_die();
	}


/* Apply Meta Data to Order */
add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');

function custom_checkout_field_update_order_meta($order_id){
	update_post_meta($order_id, 'cart_hash',$_COOKIE['woocommerce_cart_hash']);
}


/* Change the Page that the 'Proceed to Checkout button goes to (on the Cart page) */


/* This errantly changed the final confirmation page */
/*
add_filter( 'woocommerce_get_checkout_url', 'my_change_checkout_url', 30 );

function my_change_checkout_url( $url ) {
   $url = get_site_url()."/register-attendees/";
   return $url;
}
*/


/*
$registerPage = 939;

// For cart page: replacing proceed to checkout button
add_action( 'woocommerce_proceed_to_checkout', 'change_proceed_to_checkout', 1 );
function change_proceed_to_checkout() {
    remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
    add_action( 'woocommerce_proceed_to_checkout', 'custom_button_proceed_to_custom_page', 20 );
}

// For mini Cart widget: Replace checkout button
add_action( 'woocommerce_widget_shopping_cart_buttons', 'change_widget_shopping_cart_button_view_cart', 1 );
function change_widget_shopping_cart_button_view_cart() {
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'custom_button_to_custom_page', 20 );
}

// Cart page: Displays the replacement custom button linked to your custom page
function custom_button_proceed_to_custom_page() {
	global $registerPage;
	
    $button_name = esc_html__( 'Custom page steps', 'woocommerce' ); // <== button Name
    $button_link = get_permalink($registerPage); // <== Set here the page ID or use home_url() function
    ?>
    <a href="<?php echo $button_link;?>" class="checkout-button button alt wc-forward">
        <?php echo $button_name; ?>
    </a>
    <?php
}
// Mini cart:  Displays the replacement custom button linked to your custom page
function custom_button_to_custom_page() {
	global $registerPage;
	
    $button_name = esc_html__( 'Custom page Step', 'woocommerce' ); // <== button Name
    $button_link = get_permalink($registerPage ); // <== Set here the page ID or use home_url() function
    ?>
    <a href="<?php echo $button_link;?>" class="checkout button wc-forward">
        <?php echo $button_name; ?>
    </a>
    <?php
}
*/
?>
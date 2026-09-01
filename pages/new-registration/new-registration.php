<?php

/*

013f548e29056b2248a52a45b429f7f7   ($cart_item_key)
999fd7dbc7ab5bc9a5bbc5ca46d3d89c (hash)

http://localhost/00_Current/00_Clients/mirren/client-mirrenlive/cart/
WC()->cart->add_to_cart( $product_id );

938

*/

get_header(); 

//global $woocommerce;
//$woocommerce->cart->add_to_cart(938,1);
?>
<div class="p-t-150"></div>
<?php
/*
	$product_id = 938;
	
	$something = WC()->cart->add_to_cart( $product_id );
	echo "Product Added";
	
	echo "Something: ".$something;
*/
?>

<div class="p-t-100">

New Registration
<br />
<button class="add-to-cart-button" data-product-id="938">Add to Cart (Test Product One)</button><br />
<button class="add-to-cart-button" data-product-id="945">Add to Cart (Test Product Two)</button><br />

</div>


<?php

get_footer(); ?>
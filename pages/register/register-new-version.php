<?php

require_once(get_template_directory()."/functions/ergo-include-section.php");
 get_header(); ?>
 
 <div class="contain-1100 p-mobile-1150 p-t-100">

<div class="p-t-20 p-b-40">
	<h1>Register</h1>
</div>
 
<?php ergo_include_section("mirren-elements/register-list"); ?>

<?php /*
Product 938 (One):
<input type="text" value="0" class="product-qty" data-product-id="938" id="product-qty-938" /><br /><br />
Product 945 (Two):
<input type="text" value="0" class="product-qty" data-product-id="945" id="product-qty-945" /><br /><br />
*/
?>
<div class="">
<button class="add-to-cart-button-multi">Update Cart</button>
<div class="add-to-cart-button-message" style="display: none;">Adding your items to your cart...</div>
</div>

<br /><br /><br />

<?php /*
<button class="add-to-cart-button" data-product-id="938">Add to Cart (Test Product One)</button><br /><br />
<button class="add-to-cart-button" data-product-id="945">Add to Cart (Test Product Two)</button><br />
*/ ?>



 </div>

<?php

get_footer(); ?>
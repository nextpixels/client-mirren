<?php

if (isset($_COOKIE['woocommerce_cart_hash'])){  ?>

	<div class="register-attendees">
		<form action="<?php echo get_site_url(); ?>/wp-admin/admin-post.php" method="post" id="registration-submit">
			<input type="hidden" name="action" value="registrant_submit">
			<input type="hidden" name="cart" value="<?php echo $_COOKIE['woocommerce_cart_hash']; ?>">
			
		<?php
		
		$cartData = WC()->cart;
		$cartContents = $cartData->cart_contents;

		//echo "Cart Hash: ".$_COOKIE['woocommerce_cart_hash'];
		$attendeeCount = 1;
		foreach ($cartContents as $key => $value) {
			//echo "<pre>";
			//print_r($value);
			//echo "</pre>";
		  
			//echo "<br />Array Key: ".$key; 
			//echo "<br />Quantity".$cartContents[$key]['quantity'];
			//echo "<br /><br />";

		//Product Name:
			$product = wc_get_product($cartContents[$key]['product_id']); ?>
			
			<div class="register-attendees-product-tile">
				<h3 class="register-attendees-product-title"><?php echo $product->get_title(); ?></h3><?php
				
				for ($b=0;$b<$cartContents[$key]['quantity'];$b++){ ?>
					<div class="register-attendees-attendee-tile">
						<h4 class="register-attendees-attendee-title">Attendee <?php echo $attendeeCount; ?></h4>
						<input type="hidden" name="registrant-num[]" />
						<input type="hidden" name="registrant-product[]" value="<?php echo $cartContents[$key]['product_id']; ?>" />
						<input type="hidden" name="registrant-product-name[]" value="<?php echo $product->get_title(); ?>" />
						
						<div class="register-attendees-attendee-field-tile">
							<label for="first-name[]" style="margin-right: 10px;">First Name</label>
							<input type="text" name="first-name[]" />
						</div>
						
						<div class="register-attendees-attendee-field-tile">
							<label for="last-name[]" style="margin-right: 10px;">Last Name</label>
							<input type="text" name="last-name[]" />
						</div>
						
						<div class="clear"></div>
					</div><?php
					
					$attendeeCount++;
					
				} ?>
			</div><?php
		}

		?>
		<input type="submit" />
		</form>
	</div><?php
}
else{ ?>
	<p>We didn't find any items in your cart</p><?php	
}	?>
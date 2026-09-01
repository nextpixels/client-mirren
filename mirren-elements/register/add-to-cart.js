jQuery(document).ready(function($) {
    // Listen for clicks on the add-to-cart button
	
    $('.add-to-cart-button').on('click', function(e) {
        e.preventDefault();

        // Get the product ID from a data attribute or any other method you prefer
        var productId = $(this).data('product-id');

        // AJAX request to add the product to cart
        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                'action': 'add_product_to_cart',
                'product_id': productId,
            },
            success: function(response) {
                // If the product is successfully added to the cart
                alert('Product added to cart!');
            }
        });
    });
	
	 $('.add-to-cart-button-multi').on('click', function(e) {
        e.preventDefault();
		
		//Hide the button to keep user from clicking on it multiple times:
			hide('.add-to-cart-button-multi');
			show('.add-to-cart-button-message');
			
		//TODO: Should show a spinner or something instead:
			
		
		var productQtyInput = get_elements('.product-qty');
		console.log(productQtyInput);
		
		var productData = [];
		for (i=0;i<productQtyInput.length;i++){
			productData[i] = {
				'id': get_attr(productQtyInput[i],'data-product-id'),
				'qty': get_value(productQtyInput[i])
			};
		}
		
		console.log('Product Data');
		console.log(productData);
		
		var submitData = {
                'action': 'add_product_to_cart_multi',
                'product_data': productData,
            };
		
		console.log(submitData);
		
		$.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: submitData,
            success: function(response) {
				//if (typeof siteUrl === 'undefined') {
				//	var siteUrl = "";
				//}
				if (typeof siteUrl === 'undefined') {
					siteUrl = "";
				}
				window.location.href = siteUrl+"/cart/";
            },
			error: function(response){
				console.log(response);
			}
        });
		
	});
	
});
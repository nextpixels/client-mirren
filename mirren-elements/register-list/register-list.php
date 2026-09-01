<?php
	
	$virtual_only = get_field('virtual_only_event', 'option');

	if ($virtual_only) {
		$defaultTab = "virtual";
	} else {
		$defaultTab = "in-person";
	}
	
	require(get_stylesheet_directory()."/_settings.php");
	
	require_once(get_template_directory()."/functions/ergo-get-posts-from-args.php"); 
	
	/* Style: either "buy-now-buttons" or "quantity-selector"  */
		if ($registerStyle){
			$registerStyle_InPerson = $registerStyle;
			$registerStyle_Virtual = $registerStyle;
		}
		
		if (!$registerStyle_InPerson){
			$registerStyle_InPerson = "quantity-selector";
		}
		$registerStyle_Virtual = 'buy-now-buttons';
		if (!$registerStyle_Virtual){
			$registerStyle_Virtual = "quantity-selector";
		} 	?>
	
	<style><?php
	
		if ($registerStyle_InPerson == "buy-now-buttons"){ ?>
			#pricing-wrap.pricing-in-person{
				visibility: hidden;	
			}
			.tribe-events-ticket-prompt{
				display: none;
			}<?php
		}
		
	
		if ($registerStyle_Virtual == "buy-now-buttons"){ ?>
			@media(min-width: 900px){
				#pricing-wrap.pricing-virtual .register-row-quantity{
					visibility: hidden;	
					height: 0;
					overflow: hidden;
				}
				.tribe-events-ticket-prompt{
					display: none;
				}
			}<?php
		}
	
			?>
	</style><?php

	
	$args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	

	$products = ergo_get_posts_from_args($args);
	
	for ($b=0;$b<count($products);$b++){
	
		$products[$b]['properties'] = get_field('product_properties',$products[$b]['Id']);
		
		//Make the product type (virtual vs in-person) more easily used:
			$type = extract_type($products[$b]['Meta']['product_type']);
			$products[$b]['Type'] = $type;
	
	}
	
	$argsp = array(
		'post_type' => 'productproperites',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	
	$productProperties = ergo_get_posts_from_args($argsp);
	
	//Make the property type a little nicer and easier to access
		for ($i=0;$i<count($productProperties);$i++){
			
			$productProperties[$i]['Type'] = get_field('event_type',$productProperties[$i]['Id']);
			$productProperties[$i]['Meta']['popup_text'] = nl2br($productProperties[$i]['Meta']['popup_text']);
			//So we can do matching against the array content, make it all lower case:
				for ($b=0;$b<count($productProperties[$i]['Type']);$b++){
					$productProperties[$i]['Type'][$b] = strtolower($productProperties[$i]['Type'][$b]);
				}
			
		}
	
	

	function extract_type($string){
		$tmp = explode("\"",$string);		//Explode at the quotation marks -- the beginning of the actual value
		return strtolower($tmp[1]);
	}

	/**
	 * Return customer-facing pricing for the custom registration table.
	 *
	 * The main price uses the centralized sale_price -> normal_price -> native
	 * WooCommerce/Event Tickets fallback. When sale_price is selected and an
	 * ACF normal_price exists, the latter remains available as the crossed-out
	 * full price.
	 *
	 * @param array $product Product data from ergo_get_posts_from_args().
	 * @return array|false
	 */
	function di_get_registration_ticket_price_display( $product ) {
		if (
			! function_exists( 'di_get_ticket_pricing' ) ||
			empty( $product['Id'] )
		) {
			return false;
		}

		$pricing = di_get_ticket_pricing( absint( $product['Id'] ) );

		if ( ! $pricing ) {
			return false;
		}

		$meta = ! empty( $product['Meta'] ) && is_array( $product['Meta'] )
			? $product['Meta']
			: array();

		if (
			'sale_price' === $pricing['source'] &&
			! empty( $meta['sale_price'] )
		) {
			$main_html = $meta['sale_price'];
		} elseif (
			'normal_price' === $pricing['source'] &&
			! empty( $meta['normal_price'] )
		) {
			$main_html = $meta['normal_price'];
		} else {
			$main_html = wc_price( $pricing['display_price'] );
		}

		$original_html = '';

		if (
			'sale_price' === $pricing['source'] &&
			false !== $pricing['acf_normal_price']
		) {
			$original_html = ! empty( $meta['normal_price'] )
				? $meta['normal_price']
				: wc_price( $pricing['acf_normal_price'] );
		}

		return array(
			'main_html'      => $main_html,
			'main_data'      => $pricing['display_price'],
			'original_html'  => $original_html,
			'original_data'  => $pricing['acf_normal_price'],
		);
	}

	$bundle_args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'meta_query' => [
			'relation' => 'AND',
			[
				'key' => 'bundled_product',
				'value' => '1',
			],
			[
				'key' => 'parent_id',
				'value' => '0',
				'compare' => '>',
			]
		],
		//'meta_key' => 'bundled_product',
		//'meta_value' => '1'
	);

	$bundled_products = ergo_get_posts_from_args($bundle_args);
	
	if ($bundled_products) {
		for ($b=0;$b<count($bundled_products);$b++){
			$bundled_products[$b]['properties'] = get_field('product_properties',$bundled_products[$b]['Id']);
			//Make the product type (virtual vs in-person) more easily used:
			$type = extract_type($bundled_products[$b]['Meta']['product_type']);
			$bundled_products[$b]['Type'] = $type;
		}
	}

	//di_debug_log( $products );
	//di_debug_log( $bundled_products );
	?>
	
<script>
	var productProperties = <?php echo json_encode($productProperties); ?>;
</script>
	
	
<div id="register-detail" class="right-panel register-detail">
	<div class="p-b-15"><a href="#" id="register-detail-close" class="hide-click-off-link">Close</a></div>
	<div>
		<h2 id="registration-detail-title"></h2>
	</div>
	<div id="registration-detail-content"></div>
</div>


<?php
//Desktop Pricing Table:	?>
	<div class=""><?php
	
			if ($defaultTab == "virtual"){
				$styleVirtual = "display: block;";
				$styleInPerson = "display: none;";
				$tabClassVirtual = "current";
				$tabClassInPerson = "";
			}
			else{
				$styleVirtual = "display: none;";
				$styleInPerson = "display: block;";
				$tabClassVirtual = "";
				$tabClassInPerson = "current";
			}	?>

		<div class="register-table">
		
			<div class="option-navigation">	
				<?php if ( !$virtual_only ) : ?>
					<a id="tab-in-person" href="#" class="js-tab tab <?php echo $tabClassInPerson; ?> tab-in-person" style="display: inline-block; position: relative;" data-target="in-person">
						<div class="tab-andor-label">and/or</div>
						Join In-Person
					</a>
				<?php endif; ?>
				<a id="tab-virtual" href="#" class="js-tab tab <?php echo $tabClassVirtual; ?> tab-virtual" style="display: inline-block" data-target="virtual">
					Join Virtually
				</a>	
			</div>
		
			
		
			<div id="tab-content-virtual" class="tab-content tab-content-virtual" style="<?php echo $styleVirtual; ?>">
				<div class="hide-lessthan-900"><?php
					render_product_pricing_table_header($productProperties,$products,"virtual");
					render_product_properties_table($productProperties,$products,"virtual");
					render_product_pricing_table($productProperties,$products,"virtual","normal",""); 
					//render_product_pricing_table($productProperties,$products,"virtual","normal",""); 
					render_product_tab_buttons_row($products,"virtual");
					if ($registerStyle_Virtual == "buy-now-buttons"){
						render_product_buttons($productProperties,$products,"virtual",$bundled_products);
					}
					?>
				</div>
				<div class="hide-morethan-900">
					<div class="tab-content-mobile"><?php
						render_products_mobile($productProperties,$products,"virtual","",$registerStyle);

						
						?>
					</div>
					
				</div>
			</div>
		
			<?php if ( !$virtual_only ) : ?>
				<div id="tab-content-in-person" class="tab-content tab-content-in-person" style="<?php echo $styleInPerson; ?>">
					<div class="hide-lessthan-900"><?php
						render_product_pricing_table_header($productProperties,$products,"in-person");
						render_product_properties_table($productProperties,$products,"in-person");
						render_product_pricing_table($productProperties,$products,"in-person","group","Special Group Pricing (2+)","row-special-pricing");
						render_product_pricing_table($productProperties,$products,"in-person","normal","Single Pass");
						render_product_tab_buttons_row($products,"in-person");
						if ($registerStyle_InPerson == "buy-now-buttons"){					
							render_product_buttons($productProperties,$products,"in-person");
						} ?>
					</div>
					<div class="hide-morethan-900">
						<div class="tab-content-mobile"><?php
							render_products_mobile($productProperties,$products,"in-person","",$registerStyle);	?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			
		</div>

	</div>
	
		
	<div class="register-attendees-row-wrapper">
		<div class="register-attendees-row"></div>
	</div>
	<div class="add-more-logins-info-content">
		<?php echo get_field('add_more_logins_popup_text', 'options'); ?>
	</div>
	
	
	
	<?php /* Tribe Events Code */ ?>
				<div class="row justify-content-between align-items-end" style="display:none;">

					<div class="col-12 col-md-7">

						<?php /*
						<div class="tribe-events-single-event-description tribe-events-content" style="">
							<div class="p-l-15" style="color: #fff; font-weight:bolder;">Add Your Team Members <i class="fa fa-angle-right" aria-hidden="true" style="display: inline-block; margin-left: 5px; color: #fff;"></i></div>
						</div>
						*/ ?>
						
						
						<div style="position: relative;"><?php /*
							<div class="tribe-events-ticket-prompt tribe-events-ticket-prompt-row-1"><strong><span style="display: inline-block; padding-right: 30px; font-weight: bolder;">Select Number of Passes ></span> In Person</strong></div>
							<div class="tribe-events-ticket-prompt tribe-events-ticket-prompt-row-2"><strong>Virtual</strong></div> */ ?>
							<div class="tribe-events-ticket-prompt tribe-events-ticket-prompt-row-1"><?php echo get_field('row-1-intro'); ?></div>
							<div class="tribe-events-ticket-prompt tribe-events-ticket-prompt-row-2"><?php echo get_field('row-2-intro'); ?></div>
						</div>

					</div>

					<div class="col-12 col-md-4 textright" style="margin-bottom: 15px">
						<?php $home_id = get_option('page_on_front'); ?>

						<div class="tooltip-note">
							<span class="tooltip-pricing">
								<?php echo get_field('tooltip_text', $home_id); ?>
							</span>
						</div>
					</div>

				</div>
				

				
				<div id="pricing-wrap" class="<?php echo $virtual_only ? 'pricing-virtual' : 'pricing-in-person'; ?> <?php if ($registerStyle_Virtual === 'buy-now-buttons') { echo 'virtual-buy-now'; } ?>">
					<!-- Event meta -->
					<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
					
					<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
					
					<div class="group-discount-message hidden">Your group discount will be applied at checkout.</div>

				</div> 
				
	
	<?php /* End Tribe Events Code */ ?>
	
	
	<?php


function render_product_tab_buttons_row($products,$productType){ 
	//Disable on Live Site
	if ($_SERVER['SERVER_NAME'] == "localhost"){ 
		/*
		?>
		<div class="columns-flex" style="border: 1px solid red;">
		
			<div class="col col-fluid col-lead vertical-center pricing-lead">
				<div class="pricing-lead-label"></div>
			</div><?php
			
			for ($b=0;$b<count($products);$b++){  
					//print_r($products[$b]);
					if ($products[$b]['Type'] == $productType){
					?>
					<div class="col col-150 vertical-center horizontal-center register-col-<?php echo $b+1; ?>" style="border: 1px solid blue;">
						<div>
							<?php echo $products[$b]['Id']; ?>
							<input type="text" value="0" class="product-qty" data-product-id="<?php echo $products[$b]['Id']; ?>" id="product-qty-<?php echo $products[$b]['Id']; ?>" />
						</div>
					</div><?php
					}
			}	?>
		</div><?php
		*/
	}
	
	
	
}


function render_product_pricing_table_header($productProperties,$products,$productType,$class=""){ ?>
	<div class="columns-flex register-row row-pricing <?php echo $class; ?>">
		<div class="col col-fluid col-lead tab-content-header"></div><?php
		
		$tabNum = 1;
		for ($b=0;$b<count($products);$b++){ 
			//if ($products[$b]['Type'] == $productType){
			//if ($products[$b]['Type'] == $productType && $products[$b]['Meta']['bundled_product'] == 0){
			if ($products[$b]['Type'] == $productType && empty($products[$b]['Meta']['parent_id'])){
			?>	
				<div class="col col-150 vertical-center tab-content-header tab-content-header-col-<?php echo $tabNum; ?>">
					<?php 
					/* Temporary Titles - 8/6/2025 - Disable this ASAP and uncomment the code below */
					//$headingName[0] = "Entry Pass";
					//$headingName[1] = "Standard Pass";
					//$headingName[2] = "All Access";
					
					//echo $headingName[$b];
					
					
					if ($products[$b]['Meta']['display_name']){
						echo $products[$b]['Meta']['display_name'];
					}
					else{
						echo $products[$b]['Title']; 
					}
					 ?>
				</div><?php
				$tabNum++;
			}
		}	?>
	</div>
	<?php
}

function render_products_mobile($productProperties,$products,$productType,$selectedProduct,$registerStyle){

	$productTypeKey = 0;		//This is basically the column number of the product, relative to the current view (in person or virtual);
	$type_base = array_search( $productType, array_column( $products, 'Type' ) );
	for ($b=0;$b<count($products);$b++){ 
	
				//if ($products[$b]['Type'] == $productType){
				//if ($products[$b]['Type'] == $productType && $products[$b]['Meta']['bundled_product'] == 0){
				if ($products[$b]['Type'] == $productType && empty($products[$b]['Meta']['parent_id'])){
					
					$num_logins = '';
					if ( $products[$b]['Meta']['number_of_logins'] ) {
						$num_logins = $products[$b]['Meta']['number_of_logins'];
					}
					?>	
				<div class="register-tile-mobile p-15">
					<h3 class="p-b-15"><?php 
						if ($products[$b]['Meta']['display_name']){
							echo $products[$b]['Meta']['display_name'];
						}
						else{
							echo $products[$b]['Title']; 
						}	?>						
					</h3>
					
					
					<?php
					
					//Product Properties Listing
						for ($i=0;$i<count($productProperties);$i++){
							$productPropertyId = $productProperties[$i]['Id'];
							$productPropertiesList = $products[$b]['properties'];
							if (is_array($productPropertiesList) && in_array($productPropertyId,$productPropertiesList)){ ?>
								<div class="p-b-15">
								<?php 
								
								//If there is column data, break it apart and insert it...also add a colon to introduce the quantity:
								//print_r($productProperties[$i]['Meta']['column_data']); 
								$tmp = $productProperties[$i]['Meta']['column_data'];
								$hasColumnData = false;
								if ($tmp){
									$hasColumnData = true;
									$columnData = explode(";",$tmp);
								}
								?>
								
								
								<h4><?php 
									if ($hasColumnData){
										echo $productProperties[$i]['Title'].": ".$columnData[$productTypeKey];
									}
									else{
										echo $productProperties[$i]['Title']; 
									}
								
									if ($productProperties[$i]['Meta']['popup_text']){ ?> 
										<a href="#" class="register-details-link" data-id="<?php echo $i; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a><?php
									}
									if ($productProperties[$i]['Meta']['info_url']){ ?> 
										<a href="<?php echo $productProperties[$i]['Meta']['info_url']; ?>" target="_blank"><i class="fa fa-info-circle" aria-hidden="true"></i></a><?php
									}
								
								?></h4>
								<div class="register-tile-mobile-property-description"><?php
									echo $productProperties[$i]['Meta']['description']; ?>
								</div>
								
								
								
								</div><?php
							}	
						}
					
					//Pricing
						$standard_price = di_get_registration_ticket_price_display(
							$products[$b]
						);

						//Pricing Group ?>
							<div class="p-t-25"><?php
								if ($products[$b]['Meta']['group_pricing_sale_price']){ ?>
									<div class="p-b-25">
										<strong>Special Group Pricing(2+)</strong>
										<div>
											<?php echo $products[$b]['Meta']['group_pricing_sale_price']; ?>
											<div class="price-secondary" style="display: inline-block; padding-left: 8px;" data-logins="<?php echo $num_logins;?>" data-price="<?php echo $products[$b]['Meta']['group_pricing_normal_price'];?>">
												<strike>
													<?php
													/*if ( $num_logins ) {
														$logins_group_sale_price = str_replace('$', '', $products[$b]['Meta']['group_pricing_normal_price']) * $num_logins;
														echo '$' . $logins_group_sale_price;
													} else {*/
														echo $products[$b]['Meta']['group_pricing_normal_price'];
													//}
													?>
												</strike>
											</div>
										</div>
									</div><?php
								}
						//Standard Pricing 
								if ( $standard_price ) { ?>
									<div class="p-b-25">
										<strong>Single Pass</strong>
										<div>
											<?php 
											/*if ( $products[$type_base]['Meta']['sale_price'] !== $products[$b]['Meta']['sale_price'] ) {
												$entry_price = ltrim( $products[$type_base]['Meta']['sale_price'], '$' );
												$curr_prod_price = ltrim( $products[$b]['Meta']['sale_price'], '$' );
												$display_price = $curr_prod_price - $entry_price;
												if ( $products[$type_base]['Meta']['display_name'] ) {
													echo $products[$type_base]['Meta']['display_name'];
												} else {
													echo $products[$type_base]['Title'];
												}
												echo ' + $' . $display_price;
											} else {*/
												/*if ( $num_logins ) {
													$logins_sale_price = str_replace('$', '', $products[$b]['Meta']['sale_price']) * $num_logins;
													echo '$' . $logins_sale_price;
												} else {*/
													echo wp_kses_post( $standard_price['main_html'] );
												//}
											//} ?>
											<?php if ( '' !== $standard_price['original_html'] ) : ?>
											<div class="price-secondary" style="display: inline-block; padding-left: 8px;" data-logins="<?php echo esc_attr( $num_logins ); ?>" data-price="<?php echo esc_attr( $standard_price['original_data'] ); ?>">
												<strike>
													<?php
													/*if ( $num_logins ) {
														$logins_norm_price = str_replace('$', '', $products[$b]['Meta']['normal_price']) * $num_logins;
														echo '$' . $logins_norm_price;
													} else {*/
														echo wp_kses_post( $standard_price['original_html'] );
													//}
													?>
												</strike>
											</div>
											<?php endif; ?>
										</div>
									</div><?php
								} ?>
								
							</div><?php
							
							if ($registerStyle == "buy-now-buttons"){ ?>
								<div>
									<a href="#" class="buy-now btn btn-primary tribe-tickets__tickets-item-quantity-add" data-id="<?php echo $products[$b]['Id']; ?>" data-logins="<?php echo $num_logins;?>">Add Pass</a>
								</div><?php
							} ?>
							
				</div><?php
				
				$productTypeKey++;
			}
		}
}


function render_product_buttons( $productProperties, $products, $productType, $bundled_products ) {
	$virtual_pass_control_style = get_field(
		'virtual_pass_control_style',
		'option'
	);

	// Use quantity controls until the option has explicitly been saved.
	$virtual_pass_control_style = $virtual_pass_control_style ?: 'quantity';

	$use_virtual_quantity_inputs =
		'virtual' === $productType &&
		'quantity' === $virtual_pass_control_style;
?>

<div class="columns-flex register-row row-buttons">
	<div class="col col-fluid col-lead vertical-center pricing-lead register-row-quantity-prompt">
		<?php
		if ( 'virtual' === $productType ) {
			echo get_field(
				'register_row_quantity_prompt_virtual',
				'option'
			);
		} else {
			echo get_field(
				'register_row_quantity_prompt_in_person',
				'option'
			);
		}
		?>
	</div>

	<?php
	for ( $b = 0; $b < count( $products ); $b++ ) {
		/*
		 * Only output standalone products matching the current product
		 * type. Bundled products are handled separately.
		 */
		if (
			$products[ $b ]['Type'] !== $productType ||
			! empty( $products[ $b ]['Meta']['parent_id'] )
		) {
			continue;
		}
		
		$product_id = $products[ $b ]['Id'];
		$num_logins = '';
		
		if ( ! empty( $products[ $b ]['Meta']['number_of_logins'] ) ) {
			$num_logins = $products[ $b ]['Meta']['number_of_logins'];
		}

		$ticket_label = 'this pass';

		if ( ! empty( $products[ $b ]['Meta']['display_name'] ) ) {
			$ticket_label = $products[ $b ]['Meta']['display_name'];
		} elseif ( ! empty( $products[ $b ]['Title'] ) ) {
			$ticket_label = $products[ $b ]['Title'];
		}
	?>

	<div class="col col-150 vertical-center horizontal-center text-center register-col-<?php echo esc_attr( $b + 1 ); ?>">
		<div>
			<?php if ( $use_virtual_quantity_inputs ) : ?>
			<div
				 class="virtual-pass-quantity"
				 data-ticket-id="<?php echo esc_attr( $product_id ); ?>"
				 >
				<button
						type="button"
						class="virtual-pass-quantity__button virtual-pass-quantity__remove"
						aria-label="<?php echo esc_attr(
												sprintf(
													'Decrease quantity for %s',
													$ticket_label
												)
											); ?>"
						>−</button>

				<span
					  class="virtual-pass-quantity__value"
					  aria-live="polite"
					  >0</span>

				<button
						type="button"
						class="virtual-pass-quantity__button virtual-pass-quantity__add"
						aria-label="<?php echo esc_attr(
													sprintf(
														'Increase quantity for %s',
														$ticket_label
													)
												); ?>"
						>+</button>
			</div>
			<?php else : ?>
			<a
			   href="#"
			   class="buy-now btn btn-primary"
			   data-id="<?php echo esc_attr( $product_id ); ?>"
			   data-logins="<?php echo esc_attr( $num_logins ); ?>"
			   >Add Pass</a>
			<?php endif; ?>
		</div>
	</div>
	<?php
	}
	?>
</div>

<!--
 <div class="columns-flex register-row row-buttons">
  <div class="col col-fluid col-lead vertical-center pricing-lead register-row-quantity-prompt"></div>

  <?php
	for ( $b = 0; $b < count( $bundled_products ); $b++ ) {
		if (
			$bundled_products[ $b ]['Type'] === $productType &&
			$bundled_products[ $b ]['Meta']['bundled_product'] == 1
		) {
	?>
	<div class="col col-150 vertical-center horizontal-center register-col-<?php echo esc_attr( $b + 1 ); ?>">
	 <div>
	  <a
	   href="#"
	   class="buy-now btn btn-primary"
	   data-id="<?php echo esc_attr( $bundled_products[ $b ]['Id'] ); ?>"
	   data-qty="3"
	  >Add Pass</a>
	 </div>
	</div>
	<?php
		}
	}
  ?>
 </div>
 -->

<div style="position: relative;">
	<div
		 id="row-buttons-confirmation-virtual"
		 class="row-buttons-confirmation"
		 style="position: absolute; right: 0; top: 0; display: none; padding: 10px 16px;"
		 >
		This pass has been added to your order.
	</div>
</div>

<?php
}




function render_product_pricing_table($productProperties,$products,$productType,$pricingType="normal",$label="",$class=""){
	
	if ($pricingType == "group"){
		$salePrice = "group_pricing_sale_price";
		$normalPrice = "group_pricing_normal_price";
	}
	else{
		$salePrice = "sale_price";
		$normalPrice = "normal_price";
	}
	
	$type_base = array_search( $productType, array_column( $products, 'Type' ) );
	?>
	
	<div class="columns-flex register-row row-pricing <?php echo $class; ?>">
		<div class="col col-fluid col-lead vertical-center pricing-lead">
			<div class="pricing-lead-label"><?php echo $label; ?></div>
		</div><?php
		
		for ($b=0;$b<count($products);$b++){ 
		
			//if ($products[$b]['Type'] == $productType){
			//if ($products[$b]['Type'] == $productType && $products[$b]['Meta']['bundled_product'] == 0){
			if ($products[$b]['Type'] == $productType && empty($products[$b]['Meta']['parent_id'])){
				$num_logins = '';
				if ( $products[$b]['Meta']['number_of_logins'] ) {
					$num_logins = $products[$b]['Meta']['number_of_logins'];
				}

				$resolved_price = 'group' === $pricingType
					? false
					: di_get_registration_ticket_price_display( $products[$b] );

				$main_price_html = $resolved_price
					? $resolved_price['main_html']
					: $products[$b]['Meta'][$salePrice];

				$main_price_data = $resolved_price
					? $resolved_price['main_data']
					: $products[$b]['Meta'][$salePrice];

				$original_price_html = $resolved_price
					? $resolved_price['original_html']
					: $products[$b]['Meta'][$normalPrice];

				$original_price_data = $resolved_price
					? $resolved_price['original_data']
					: $products[$b]['Meta'][$normalPrice];
			?>	
				<div class="col col-150 vertical-center horizontal-center text-center register-col-<?php echo $b+1; ?>">
					<div>
					<div class="price-main" style="text-align: center;" data-logins="<?php echo esc_attr( $num_logins ); ?>" data-price="<?php echo esc_attr( $main_price_data ); ?>">
						<?php 
						// Not sure what this was for
						/*if ( $products[$type_base]['Meta']['sale_price'] !== $products[$b]['Meta'][$salePrice] ) {
							$entry_price = ltrim( $products[$type_base]['Meta'][$salePrice], '$' );
							$curr_prod_price = ltrim( $products[$b]['Meta'][$salePrice], '$' );
							$display_price = $curr_prod_price - $entry_price;
							if ( $products[$type_base]['Meta']['display_name'] ) {
								echo $products[$type_base]['Meta']['display_name'];
							} else {
								echo $products[$type_base]['Title'];
							}
							echo ' + $' . $display_price;
						} else {*/
							// Below is unrelated to whats hidden above
							// I initially thought I needed to do math here, but not necessary since it's a custom field and not the actual price
							/*if ( $num_logins ) {
								$logins_sale_price = str_replace('$', '', $products[$b]['Meta'][$salePrice]) * $num_logins;
								echo '$' . $logins_sale_price;
							} else {*/
								echo wp_kses_post( $main_price_html );
							//}
						//} ?>
						</div>
					<?php if ( 'group' === $pricingType || '' !== $original_price_html ) : ?>
					<div class="price-secondary" style="text-align: center;" data-logins="<?php echo esc_attr( $num_logins ); ?>" data-price="<?php echo esc_attr( $original_price_data ); ?>">
							<strike>Full Price: 
								<?php
								/*if ( $num_logins ) {
									$logins_norm_price = str_replace('$', '', $products[$b]['Meta'][$normalPrice]) * $num_logins;
									echo '$' . $logins_norm_price;
								} else {*/
									echo wp_kses_post( $original_price_html );
								//}
								?>
							</strike>
						</div>
					<?php endif; ?>
					</div>
				</div><?php
			}
		}	?>
	</div>
	
	<?php 
	
	//In Person   ?>
<?php
	
	
	//Virtual 
	
	?>
	
	<?php
}




function render_product_properties_table($productProperties,$products,$productType){
	
	
	
	for ($i=0;$i<count($productProperties);$i++){
			
			if(in_array($productType,$productProperties[$i]['Type'])){
			//if($productProperties[$i]['Type'] == $productType){	
			
				$columnData = null;
				//Column data is used for putting things like numbers or text into the column, instead of the usual checkmark
				if ($productProperties[$i]['Meta']['column_data']){
					$columnData = explode(";",$productProperties[$i]['Meta']['column_data']);
				}	?>
				<div class="columns-flex register-row">
					<div class="col col-fluid col-lead">
						<h4><?php echo $productProperties[$i]['Title'];
							if ($productProperties[$i]['Meta']['popup_text']){ ?> 
							<a href="#" class="register-details-link" data-id="<?php echo $i; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a><?php
							}
							if ($productProperties[$i]['Meta']['info_url']){ ?> 
								<a href="<?php echo $productProperties[$i]['Meta']['info_url']; ?>" target="_blank"><i class="fa fa-info-circle" aria-hidden="true"></i></a><?php
							}
							?>
						</h4>
						<div class="product-property-details">
							<?php echo $productProperties[$i]['Meta']['description']; ?> 
							<?php //echo $productProperties[$i]['Id']; ?>
						</div>
					</div><?php
					
					$tabNum = 1;

	

					for ($b=0;$b<count($products);$b++){ 
						//if ($products[$b]['Type'] == $productType){
						//if ($products[$b]['Type'] == $productType && $products[$b]['Meta']['bundled_product'] == 0){
						if ($products[$b]['Type'] == $productType && empty($products[$b]['Meta']['parent_id'])){
						?>
						
						<div class="col col-150 vertical-center horizontal-center text-center register-col-<?php echo $tabNum; ?>"><?php
							
								if ($columnData[$tabNum-1]){
									//If there is a column data value, display it:
									echo $columnData[$tabNum-1];
								}
								else{
									//If the product property is part of this product, draw a checkmark
									$productPropertyId = $productProperties[$i]['Id'];
									$productPropertiesList = $products[$b]['properties'];
									
									if (is_array($productPropertiesList) && in_array($productPropertyId,$productPropertiesList)){ ?>
										<i class='fa fa-check-circle' aria-hidden='true'></i><?php
									}
								}	?>
						</div><?php
						$tabNum++;
						}
					}	?>
				</div><?php
			}
	}
	
}

?>

<script>
	(function($){
		document.addEventListener( 'DOMContentLoaded', function(e) {

			add_event('.buy-now','click',function(e){
				e.preventDefault();

				var productId = get_attr(this,'data-id');
				var buttonTarget = this;

				if ( this.classList.contains('added') ) {

					this.classList.remove('added');
					this.innerHTML = 'Add Pass';

					//Simulate a click on the hidden remove quantity selector:
					var targetElement = document.getElementById('tribe-tickets__tickets-item-quantity-number--'+productId);
					var parentEl = get_parent_with_class(targetElement,'tribe-tickets__tickets-item-quantity');
					var removeQuantityElement = parentEl.querySelector('.tribe-tickets__tickets-item-quantity-remove');
					removeQuantityElement.click();

					//set_value('#tribe-tickets__tickets-item-quantity-number--'+productId,1);

					if ( document.querySelector('.tribe-tickets__tickets-footer-quantity-number').innerHTML == '0' ) {
						document.getElementById('tribe-tickets__tickets-buy').setAttribute("disabled", "disabled");
					}

					if ( productId == 178 ) {
						document.querySelector('.register-row-quantity').classList.remove('toggle-bundle-178');
						document.getElementById('tribe-tickets__tickets-item-quantity-number--4793').value = '0';
						document.getElementById('item-quantity-number--4793').innerHTML = '0';
					}
					if ( productId == 179 ) {
						document.querySelector('.register-row-quantity').classList.remove('toggle-bundle-179');
						document.getElementById('tribe-tickets__tickets-item-quantity-number--4798').value = '0';
						document.getElementById('item-quantity-number--4798').innerHTML = '0';
					}

				} else {

					this.classList.add('added');
					this.innerHTML = 'Added';

					//Simulate a click on the hidden add quantity selector:
					var targetElement = document.getElementById('tribe-tickets__tickets-item-quantity-number--'+productId);
					var parentEl = get_parent_with_class(targetElement,'tribe-tickets__tickets-item-quantity');
					var addQuantityElement = parentEl.querySelector('.tribe-tickets__tickets-item-quantity-add');
					addQuantityElement.click();

					//set_value('#tribe-tickets__tickets-item-quantity-number--'+productId,1);

					document.getElementById('tribe-tickets__tickets-buy').removeAttribute("disabled"); <?php

					//If both virtual and in-person are buy now buttons, just submit the order as soon as they click any of the buttons:
					if ($registerStyle_InPerson = "buy-now-buttons" && 	$registerStyle_Virtual != "buy-now-buttons"){ ?>
					document.getElementById('tribe-tickets__tickets-buy').click();<?php
					} ?>

					if ( productId == 178 ) {
						document.querySelector('.register-row-quantity').classList.add('toggle-bundle-178');
					}
					if ( productId == 179 ) {
						document.querySelector('.register-row-quantity').classList.add('toggle-bundle-179');
					}

				}

			});

			

		})
	})(jQuery);
</script>








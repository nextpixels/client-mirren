<?php
		
	function new_order_action($orderId) {
		
			global $wpdb;
			global $acKey;
			global $acUrl;
			
			//Thiis has the attendee information:
				$orderData 			= tribe_tickets_get_attendees($orderId);
				$orderDataJson 	= json_encode($orderData);
			
			//Get WooCommerce Meta Data (Company Name):
				$dataWoo = get_post_meta($orderId);
				$dataWooJson = json_encode($dataWoo);
				$company = $dataWoo['company_name'][0];
				
			//Get the WooCommerce Normal Data:
				$wooGeneral = wc_get_order($orderId);
				$wooGeneralData = $wooGeneral->get_data();
				$wooGeneralMeta = $wooGeneralData['meta_data'];
				
				
				
				//Get Meta Data (company name, group coordinator, etc...);
					$i=0;
					foreach ($wooGeneralData['meta_data'] as $value){
						$dataWooMeta[$i] = $value;
						$key = $dataWooMeta[$i]->key;
						$customFields[$key] =$dataWooMeta[$i]->value;
						$i++;
					}
					//$wooGeneralJson = json_encode($customFields);
					
				//Get Coupon Code Data
					$wooGeneralJson = json_encode($wooGeneral->get_coupon_codes());
					$couponCode = $wooGeneral->get_coupon_codes()[0];
				
				/*
					//Test Database Inserts
					$results = $wpdb->insert('wp_attendees',array(
							'attendee_date' => date('H:i:s'),
							'order_id' => $orderId,
							'order_data' => $orderDataJson,
							'order_attendee_name' => 'Order Json'
							)
						);
						
						$results = $wpdb->insert('wp_attendees',array(
							'attendee_date' => date('H:i:s'),
							'order_id' => $orderId,
							'order_data' => $dataWooJson,
							'order_attendee_name' => 'Woo Json'
							)
						);
					
						
						$results = $wpdb->insert('wp_attendees',array(
							'attendee_date' => date('H:i:s'),
							'order_id' => $orderId,
							'order_data' => json_encode($wooGeneralMeta),
							'order_attendee_name' => 'Woo General Json'
							)
						);
							
						
						$results = $wpdb->insert('wp_attendees',array(
							'attendee_date' => date('H:i:s'),
							'order_id' => $orderId,
							'order_data' => $wooGeneralJson,
							'order_attendee_name' => 'Coupon Codes'
							)
						);
					*/
			
			for ($i=0;$i<count($orderData);$i++){			
				include("new-order-sync-sheets.php");
			}
			
	}
	//add_action( 'tribe_tickets_plus_woo_before_generate_tickets', 'new_order_action' );
	
?>

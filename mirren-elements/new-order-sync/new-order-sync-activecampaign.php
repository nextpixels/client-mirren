<?php

	$acKey 		= "3f58b23e5b78033791cdb7157236c2a2517fb96650c3af4c9e148fe99813c3b5f8bc229c";
	$acUrl 		= "https://nextpixels1695081699.api-us1.com";


	//Active Campaign: Submit New User:
		$body = json_encode(array(
			"contact" => array(
				"email" => $orderData[$i]['holder_email'],
				"firstName" => $orderData[$i]['holder_name'],
				"lastName" => $orderData[$i]['attendee_meta']['last-name']['value'],
				"fieldValues" => array(
					array(
						"field" =>"1",
						"value" => $company
					),
					array(
						"field" => "2",
						"value" => $orderData[$i]['attendee_meta']['job-title']['value']
					)
				)
			)
		));
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://nextpixels1695081699.api-us1.com/api/3/contacts");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                                                                                                                                                       
			'Api-Token: '."3f58b23e5b78033791cdb7157236c2a2517fb96650c3af4c9e148fe99813c3b5f8bc229c"                                                                 
		));  

		$output = curl_exec($ch);
		curl_close($ch);		


				//Active Campaign: Submit New User
				
				//Active Campaign: Apply the user to the necessary list:
				//https://developers.activecampaign.com/reference/update-list-status-for-contact
				
				
				//Active Campaign: Add the user 
				//https://developers.activecampaign.com/reference/create-contact-tag
				
				
				//Active Campaign: Apply the user to the account:
				//1. Create an account if doesn't exist, otherwise get the account id.
				//https://developers.activecampaign.com/reference/create-an-account-1

?>
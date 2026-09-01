<?php

require_once(get_stylesheet_directory()."/_settings.php");

//Mirren:
$spreadsheetId = $syncSheets_SpreadsheetId;	//"19kfQl6739PvTKi5L_O7DiKPfpeK9Di50nEAArbkCGiE"; //MIrren - It is present in your URL
$get_range = $syncSheets_Sheet; //"Sheet1"; 
$path = '_wpeprivate/mirrensheet.php';


require_once("new-order-sync-sheets-functions.php");
require_once 'vendor/autoload.php';

	
// configure the Google Client
$client = new \Google_Client();
$client->setApplicationName('Google Sheets API');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig($path);

// configure the Sheets Service
$service = new \Google_Service_Sheets($client);

	//Assign Values:
		$registrationDateTime 	= sync_sheets_assign_value($orderData[$i]['purchase_time']);
		$orderNumber 					= sync_sheets_assign_value($orderData[$i]['order_id']);
		$companyName				= sync_sheets_assign_value($customFields['company_name']);
		$passType							= sync_sheets_assign_value($orderData[$i]['ticket_name']);
		
		//We're not collecting attendee info for MirrenLive, but data incorrectly gets applied to this field even though we aren't collecting it.
		if (stristr($passType,"virtual")){
			//$attendeeFirstName		= "-";
			$attendeeFirstName		= $dataWoo['_billing_first_name'][0];
		}
		else{
			$attendeeFirstName		= sync_sheets_assign_value($orderData[$i]['holder_name']);
		}
		
		if (isset($orderData[$i]['attendee_meta']) && isset($orderData[$i]['attendee_meta']['last-name'])){
			$attendeeLastName			= sync_sheets_assign_value($orderData[$i]['attendee_meta']['last-name']['value']);
		}
		else{
			//$attendeeLastName			= "-";
			$attendeeLastName			= $dataWoo['_billing_last_name'][0];
		}
		
		if (isset($orderData[$i]['attendee_meta']) && isset($orderData[$i]['attendee_meta']['title'])){
			$attendeeJobTitle				= sync_sheets_assign_value($orderData[$i]['attendee_meta']['title']['value']);
		}
		else{
			$attendeeJobTitle				= "-";
		}
		
			//We're not collecting attendee info for MirrenLive, but data incorrectly gets applied to this field even though we aren't collecting it.
		if (stristr($passType,"virtual")){
			$attendeeEmail					= sync_sheets_assign_value($orderData[$i]['holder_email']);
		}
		else{
			$attendeeEmail					= sync_sheets_assign_value($orderData[$i]['holder_email']);
		}
		
		
		$phoneNumber				= sync_sheets_assign_value($dataWoo['_billing_phone'][0]);
		$zipCode							= sync_sheets_assign_value($dataWoo['_billing_postcode'][0]);
		if (isset($dataWoo['_billing_first_name'][0]) && isset($dataWoo['_billing_last_name'][0])){
			$purchaserName				= $dataWoo['_billing_first_name'][0]." ".$dataWoo['_billing_last_name'][0];
		}
		else{
			$purchaserName				= "-";
		}
		
		$totalPaid							= sync_sheets_assign_value($dataWoo['_order_total'][0]);
		if ($i> 0){
			$totalPaid = 0;				//If this is an attendee of a larger order, don't include the total paid on their row
		}
		
		$totalDiscount					= sync_sheets_assign_value($dataWoo['_cart_discount'][0]);
		$promoCode						= sync_sheets_assign_value($couponCode);
		$coordinatorFirstName	= sync_sheets_assign_value($customFields['group_coordinator_first_name']);
		$coordinatorLastName 	= sync_sheets_assign_value($customFields['group_coordinator_last_name']);
		$coordinatorEmail			= sync_sheets_assign_value($customFields['group_coordinator_email']);
		$joinList							 	= sync_sheets_assign_value($customFields['join_list']);
		$orderStatus						= "No Value";
		$confirmationNumber		= sync_sheets_assign_value($dataWoo['_order_key'][0]);
		$purchaserEmail				= sync_sheets_assign_value($dataWoo['_billing_email'][0]);
		$coordinatorTitle				= sync_sheets_assign_value($customFields['group_coordinator_title']);
	

	$newRow = [
		$registrationDateTime,
		$orderNumber,
		$companyName,
		$attendeeFirstName,
		$attendeeLastName,
		$attendeeJobTitle,
		$attendeeEmail,
		$passType,
		$phoneNumber,
		$zipCode,
		$purchaserName,
		$totalPaid,
		$totalDiscount,
		$promoCode,
		$coordinatorFirstName,
		$coordinatorLastName,
		$coordinatorEmail,
		$orderStatus,
		$confirmationNumber,
		$purchaserEmail,
		$coordinatorTitle,
		$joinList
	];
	
	
	$rows = [$newRow]; // you can append several rows at once
	$valueRange = new \Google_Service_Sheets_ValueRange();
	$valueRange->setValues($rows);
	$range =  $syncSheets_Sheet;//'Sheet1'; // the service will detect the last row of this sheet
	$options = ['valueInputOption' => 'USER_ENTERED'];
	$service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $options); 
  
?>

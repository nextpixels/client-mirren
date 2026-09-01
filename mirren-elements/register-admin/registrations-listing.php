<?php
$current_user = wp_get_current_user();
if (!user_can( $current_user, 'administrator' )) {
	exit;
} 

if ( !defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}	?>



<h1>Registrations</h1>

<?php
//8576dd2563d5b368a1648db5141748b8

//Get the registrant Data:
// Get the global $wpdb object
global $wpdb;


//Get the cart hash/order id correspnance...this is how we match attendee data (the hash) with the cart id
$query = "SELECT * FROM wp_postmeta WHERE meta_key = 'cart_hash'";
$results = $wpdb->get_results($query);

for ($i=0;$i<count($results);$i++){
	$cartHash[$results[$i]->meta_value] = $results[$i]->post_id;
}
//echo "Cart Hash";
//print_r($cartHash);

//echo "<br /><br />";

//Get the attendees:
$query = "SELECT * FROM wp_attendee_data";
$attendees = $wpdb->get_results($query);
//echo "<br /><br />Attendees<br />";
//print_r($attendees);

for($i=0;$i<count($attendees);$i++){
	//print_r($attendees[$i]->attendee_cart_id);
	$orderId = $cartHash[$attendees[$i]->attendee_cart_id];
	//echo "<br />ORDER ID: ".$orderId."<br />";
	if ($orderId){
	$key = 0;
	if (is_array($attendeeData[$orderId])){
		$key = count($attendeeData[$orderId]);
	}
	//echo "Order Id: ".$orderId;
	$attendeeData[$orderId][$key] = $attendees[$i];
//	echo "<br /><br />";
	}
}

/*
?>
<pre><?php
print_r($attendeeData); ?>
</pre>

<?php
*/
echo "<br /><br />";

// Get Orders
$query = new WC_Order_Query( array(
    'limit' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
    'return' => 'ids',
) );
$orders = $query->get_orders();
echo "<br />Order Data";
//print_r($orders);

//Get individual order data:
for ($i=0;$i<count($orders);$i++){
	$tmpOrderData[$i] = wc_get_order($orders[$i]);	
	

	echo "<br /><br />-->";
	//print_r($tmpOrderData[$i]->data);
	
	echo "<br /><br />Id: ".$tmpOrderData[$i]->data['id'];
	echo "<br />Date: ".$tmpOrderData[$i]->data['date_created']->date;
	echo "<br />";
	print_r($tmpOrderData[$i]->data['date_created']);
	echo "<br />Billing First: ".$tmpOrderData[$i]->data['billing']['first_name'];
	echo "<br />Billing Last: ".$tmpOrderData[$i]->data['billing']['last_name'];
	echo "<br />Company: ".$tmpOrderData[$i]->data['billing']['company'];
	echo "<br />Total Paid: ".$tmpOrderData[$i]->data['total'];
	echo "<br />Total Discount: ".$tmpOrderData[$i]->data['discount_total'];
	echo "<br />Order Status: ".$tmpOrderData[$i]->data['status'];
	echo "<br />Purchaser Email: ".$tmpOrderData[$i]->data['billing']['email'];
	
	
	$key = $tmpOrderData[$i]->data['id'];
	$orderData[$key]['Id'] = $tmpOrderData[$i]->data['id'];
	$orderData[$key]['Date'] = $tmpOrderData[$i]->data['date_created']->date;
	$orderData[$key]['BillingFirst'] = $tmpOrderData[$i]->data['billing']['first_name'];
	$orderData[$key]['BillingLast'] = $tmpOrderData[$i]->data['billing']['last_name'];
	$orderData[$key]['Company'] = $tmpOrderData[$i]->data['billing']['company'];
	$orderData[$key]['Total'] = $tmpOrderData[$i]->data['total'];
	$orderData[$key]['Discount'] = $tmpOrderData[$i]->data['discount_total'];
	$orderData[$key]['Status'] = $tmpOrderData[$i]->data['status'];
	$orderData[$key]['BillingEmail'] = $tmpOrderData[$i]->data['billing']['email'];
	
	
	/*
	?>
	<pre><?php
	print_r($orderData); ?>
	</pre><?php
	*/
}



?>
<style>
	table{
		border-left: 1px solid #CCC;
		border-top: 1px solid #CCC;
	}
	td,th{
		border-right: 1px solid #CCC;
		border-bottom: 1px solid #CCC;
		padding: 5px 10px;
		text-align: left;
	}
</style>
<table cellspacing=0>
	<tr>
		<th>Registration Date</th>
		<th>Order</th>
		<th>Company Name</th>
		<th>Attendee First Name</th>
		<th>Attendee Last Name</th>
		<th>Job Title</th>
		<th>Email</th>
		<th>Pass Type</th>
		<th>Phone Number</th>
		<th>Zip Code</th>
		<th>Purchaser Name</th>
		<th>Total Paid</th>
		<th>Total Discount</th>
		<th>Promo Code</th>
		<th>Group Coordinator First Name</th>
		<th>Group Coordinator Last Name</th>
		<th>Group Coordinator Email</th>
		<th>Order Status</th>
		<th>Confirmation Number</th>
		<th>Purchaser Email</th>
		<th>Group Coordinator Title</th>
	</tr>
<?php
for ($i=0;$i<count($orders);$i++){
	
	for ($b=0;$b<count($attendeeData[$orders[$i]]);$b++){ ?>
		<tr>
			<td><?php echo $orderData[$orders[$i]]['Date']; ?></td>
			<td><?php echo $orders[$i]; ?></td>
			<td><em>company</em></td>
			<td><?php echo $attendeeData[$orders[$i]][$b]->attendee_first_name; ?></td>
			<td><?php echo $attendeeData[$orders[$i]][$b]->attendee_last_name; ?></td>
			<td><em>job title</em></td>
			<td><em>email</em></td>
			<td><?php echo $attendeeData[$orders[$i]][$b]->attendee_product_name; ?></td>
			<td><em>phone</em></td>
			<td><em>zip</em></td>
			<td><?php echo $orderData[$orders[$i]]['BillingFirst']; ?> <?php echo $orderData[$orders[$i]]['BillingLast']; ?></td>
			<td><?php echo $orderData[$orders[$i]]['Total']; ?></td>
			<td><?php echo $orderData[$orders[$i]]['Discount']; ?></td>
			<td><em>promo code</em></td>
			<td><em>coord first</em></td>
			<td><em>coord last</em></td>
			<td><em>coord email</em></td>
			<td><?php echo $orderData[$orders[$i]]['Status']; ?></td>
			<td><em>confirm number</em></td>
			<td><?php echo $orderData[$orders[$i]]['BillingEmail']; ?></td>
			<td><em>coord title</em></td>
		</tr><?php
	}
}

?>
</table>

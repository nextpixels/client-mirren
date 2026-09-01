<?php
   /**
    * Template Name: Reports
    *
    * @package		Twirling_Umbrellas_Theme
    * @author		Twirling Umbrellas Inc.
    * @copyright	2013-2019 Twirling Umbrellas Inc.
    * @link		https://www.twirlingumbrellas.ca
    * @since		1.0.0
    */
	
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	
$current_user = wp_get_current_user();
if (!user_can( $current_user, 'administrator' )) {
	exit;
}
	
   if ( !defined( 'ABSPATH' ) ) {
   	exit; // Exit if accessed directly
   }
   
   global $framework;
   
   get_header();
   
   the_post();
   
   ?>

<style>
    .page-main-dark th,
    .page-main-dark td,
    .page-main-dark div,
    .page-main-dark span {
        color: #000;
    }
</style>

<div id="page" style="padding-top: 100px;">
    <main id="reports-page" class="" role="main" itemprop="mainEntityOfPage">
        <?php
         // check if $_GET['id'] is set 
         if( isset( $_GET['id'] ) ):
             // get the report id
             $report_id = $_GET['id'];
             // get the report
             $report = get_post( $report_id );
			 

             ?>
        <table id="report-table">
            <thead>
                <tr>
                    <th>
                        Registration Date
                    </th>
                    <th class="small">
                        Order number
                    </th>
                    <th>
                        Ticket ID
                    </th>
                    <th>
                        Company Name
                    </th>
                    <th>
                        Attendee First Name
                    </th>
                    <th>
                        Attendee Last Name
                    </th>
                    <th>
                        Attendee Title
                    </th>
                    <th>
                        Attendee Email
                    </th>
                    <th>
                        Pass type
                    </th>
                    <th>
                        Comp?
                    </th>
                    <th>
                        Login?
                    </th>
                    <th>
                        Phone Number
                    </th>
                    <th class="small">
                        Zip Code
                    </th>
                    <th>
                        Purchaser Name
                    </th>
                    <th>
                        Total Paid
                    </th>
                    <th>
                        Total Discount
                    </th>
                    <th>
                        Promo Code
                    </th>
                    <th>
                        Group Coordinator First Name
                    </th>
                    <th>
                        Group Coordinator Last Name
                    </th>
                    <th>
                        Group Coordinator Email
                    </th>
                    <th class="small">
                        Order Status
                    </th>
                    <th>
                        Confirmation number
                    </th>
                    <th>
                        Purchaser Email
                    </th>
                    <th>
                        Group Coordinator Title
                    </th>
                    <th>
                        Join Mailing List
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                //   Build table from attendees

                $attendees = tribe_tickets_get_attendees($report_id);
                
                //di_debug_log($attendees);
                
                foreach ($attendees as $attendee) {
                    $attendee_meta = $attendee['attendee_meta'];
                    $registration_date = $attendee['purchase_time'];
                    $ticket_id = $attendee['ticket_id'];
                    $ticket_type = $attendee['ticket_name'];
                    $attendee_email = $attendee['holder_email'];
                    $attendee_holder_name = $attendee['holder_name'];
                
                    // Check if is a "bundled" ticket aka "Login"
                    $ticket_product_id = $attendee['product_id'];
                    if ($ticket_product_id == '4793' || $ticket_product_id == '4798') {
                        $bundle_login = 'Yes';
                    } else {
                        $bundle_login = 'No';
                    }

                    $attendee_last_name = '';
                    $attendee_job_title = '';
                    $attendee_company = '';
                
                    if ($attendee_meta) {
                
                        $attendee_last_name = $attendee_meta['last-name']['value'];
                        $attendee_job_title = $attendee_meta['title']['value'];
                        $attendee_company = $attendee_meta['company']['value'];
                        $attendee_comp = $attendee_meta['comp']['value'];
                        if (!$attendee_comp) {
                            $attendee_comp = 'No';
                        }
                
                        // If no attendee last name, try to format a first and last name from holder full name
                        if (!$attendee_last_name) {
                            if (str_contains($attendee_holder_name, ' ')) {
                                $attendee_firstlast = explode(' ', $attendee_holder_name);
                                $attendee_first_name = $attendee_firstlast[0];
                                $attendee_last_name = $attendee_firstlast[1];
                            }
                        } else {
                            $attendee_first_name = $attendee['holder_name'];
                        }
                    }
                
                    $attendee_security_code = $attendee['security_code'];
                    $woo_order_id = $attendee['order_id'];
                
                    // get woo commerce order
                    $order = wc_get_order($woo_order_id);
                    if ($order) {
                
                        //di_debug_log($order);
                
                        $order_data = $order->get_data();
                
                        $order_date = $order_data['date_created']->date('Y-m-d H:i:s');
                        $order_id = $order_data['id'];
                        $order_billing_first_name = $order_data['billing']['first_name'];
                        $order_billing_last_name = $order_data['billing']['last_name'];
                        $order_billing_company = $order_data['billing']['company'];
                        $order_billing_email = $order_data['billing']['email'];
                        $order_billing_phone = $order_data['billing']['phone'];
                        $order_billing_postcode = $order_data['billing']['postcode'];
                        $order_billing_city = $order_data['billing']['city'];
                        $order_billing_state = $order_data['billing']['state'];
                        $order_billing_country = $order_data['billing']['country'];
                        $order_billing_address_1 = $order_data['billing']['address_1'];
                
                        $order_total = $order_data['total'];
                
                        // get coupon used
                        $order_coupon_used = $order->get_used_coupons();
                        $order_coupon_used = implode(', ', $order_coupon_used);
                        $discount_total = $order_data['discount_total'];
                        $order_status = $order_data['status'];
                        $join_mailing_list = '';
                
                        // Calculate accurate line item cost, otherwise fall back to the overall order total and discount
                        $line_items = $order->get_items();
                        if ($line_items) {
                
                            foreach ($line_items as $item_key => $item_values) {
                                $item_data = $item_values->get_data();
                                //di_debug_log($item_data);
                
                                if ($item_data['product_id'] == $ticket_product_id) {
                                    $quantity = $item_data['quantity'];
                                    $subtotal = (int) $item_data['subtotal'];
                                    $order_total = (int) $item_data['total'] / $quantity;
                                    $discount_total = ($subtotal / $quantity) - $order_total;
                                }
                            }
                
                        }
                
                        // Fallback if no attendee name
                        if (!$attendee_meta) {
                            $attendee_first_name = $order_billing_first_name;
                            $attendee_last_name = $order_billing_last_name;
                            $attendee_job_title = "";
                        }
                
                
                        // get company_name from order WC_Meta_Data
                        $order_meta_data = $order->get_meta_data();
                        $company_name = '';
                        foreach ($order_meta_data as $meta_data) {
                            if ($meta_data->key == 'company_name') {
                                $company_name = $meta_data->value;
                            }
                
                            // get group coordinator fields
                            if ($meta_data->key == 'group_coordinator_first_name') {
                                $group_coordinator_first_name = $meta_data->value;
                            }
                            if ($meta_data->key == 'group_coordinator_last_name') {
                                $group_coordinator_last_name = $meta_data->value;
                            }
                            if ($meta_data->key == 'group_coordinator_title') {
                                $group_coordinator_title = $meta_data->value;
                            }
                            if ($meta_data->key == 'group_coordinator_email') {
                                $group_coordinator_email = $meta_data->value;
                            }
                
                
                        }
				   

					   
					   ?>
                <tr>
                    <td>
                        <?php echo $registration_date; ?>
                    </td>
                    <td data="<?php echo $order_id; ?>">
                        <a href="<?php echo get_site_url(); ?>/wp-admin/post.php?post=<?php echo $order_id; ?>&action=edit"
                            target="_blank">
                            <?php echo $order_id;  ?>
                        </a>
                    </td>
                    <td>
                        <?php echo $ticket_id; ?>
                    </td>
                    <td data="<?php echo ($attendee_company ? $attendee_company : $company_name); ?>"
                        data-search="<?php echo ($attendee_company ? $attendee_company : $company_name); ?>">
                        <!-- Company Name -->
                        <?php echo ($attendee_company ? $attendee_company : $company_name); ?>
                    </td>
                    <td data="<?php echo $attendee_first_name; ?>">
                        <!-- Attendee First Name -->
                        <?php echo $attendee_first_name; ?>
                    </td>
                    <td>
                        <!-- Attendee Last Name -->
                        <?php echo $attendee_last_name; ?>
                    </td>
                    <td>
                        <!-- Job Title -->
                        <?php echo $attendee_job_title; ?>
                    </td>
                    <td>
                        <!-- Email -->
                        <?php echo $attendee_email; ?>
                    </td>
                    <td data="<?php echo $ticket_type; ?>" data-search="<?php echo $ticket_type; ?>">
                        <!-- Pass Type -->
                        <?php echo $ticket_type; ?>
                    </td>
                    <td>
                        <!-- Comp? -->
                        <?php echo $attendee_comp; ?>
                    </td>
                    <td>
                        <!-- Login? -->
                        <?php echo $bundle_login; ?>
                    </td>
                    <td>
                        <!-- Phone Number -->
                        <?php echo $order_billing_phone; ?>
                    </td>
                    <td>
                        <!-- Zip Code -->
                        <?php echo $order_billing_postcode; ?>
                    </td>
                    <td>
                        <!-- Purchaser Name -->
                        <?php echo $order_billing_first_name . ' ' . $order_billing_last_name; ?>
                    </td>
                    <td>
                        <!-- Order Total -->
                        <?php echo $order_total; ?>
                    </td>
                    <td>
                        <!-- Total Discount -->
                        <?php echo $discount_total; ?>
                    </td>
                    <td>
                        <!-- Promo Code (if applicable) -->
                        <?php echo $order_coupon_used; ?>
                    </td>
                    <td>
                        <!-- Group Coordinator First Name -->
                        <?php echo $group_coordinator_first_name; ?>
                    </td>
                    <td>
                        <!-- Group Coordinator Last Name -->
                        <?php echo $group_coordinator_last_name; ?>
                    </td>
                    <td>
                        <!-- Group Coordinator Email -->
                        <?php echo $group_coordinator_email; ?>
                    </td>


                    <td>
                        <!-- order status -->
                        <?php echo $order_status; ?>
                    </td>
                    <td>
                        <?php echo $attendee_security_code; ?>
                    </td>
                    <td>
                        <!-- Purchaser Email -->
                        <?php echo $order_billing_email; ?>
                    </td>
                    <td>
                        <!-- Group Coordinator Title -->
                        <?php echo $group_coordinator_title; ?>
                    </td>
                    <td>
                        <!-- Join Mailing List -->
                        
                    </td>

                </tr>
                <?php 

				}
				
				$previous_order_id = $order_id;
				
			}
               ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="lgpadding">
            <div class="container textcenter">
                <p style="color: white;">Sorry, no reports found.</p>
            </div>
        </div>
        <?php endif; ?>
    </main>
    <!-- #content -->
</div>
<!-- #page -->
<style>
    div#wpadminbar {
        display: none;
    }

    html {
        margin-top: 0 !important;
    }

    .dt-buttons {
        padding: 10px;
    }

    body {
        background: #3f4685;
    }

    div.dts div.dataTables_scrollBody {
        background: #f7f7f7 !important;
    }

    button.dt-button.buttons-csv.buttons-html5 {
        background: #f7f7f7;
        border: none;
        font-weight: bold;
        border-radius: 50px;
    }

    button.dt-button.buttons-csv.buttons-html5:hover {
        background: #eee;
        border: none;
    }

    #reports-page div#report-table_info {
        padding: 5px 10px;
        font-size: 10px;
        color: white;
    }

    #reports-page .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #fff;
        border-radius: 50px;
        padding: 5px 15px !important;
        background-color: transparent;
        margin-left: 15px;
        background: white;
    }

    #reports-page div#report-table_filter label {
        display: flex;
        padding: 15px;
        color: #ffffff;
        align-items: center;
    }

    #reports-page {
        height: 100vh;
        overflow: hidden;
    }

    #page {
        margin: 0;
    }

    #header {
        display: none;
    }

    #footer {
        display: none;
    }

    #report-table {
        max-width: 100%;
        overflow-x: auto;
        font-size: 12px;
    }

    #report-table td {
        padding: 4px 5px;
    }

    #report-table td:nth-of-type(odd) {
        background: #3f468514;
    }

    #report-table td {
        border: none;
    }

    #report-table td a {
        font-weight: bold;
        color: #3f4685;
        text-decoration: none;
    }

    #report-table tr.even {
        background: #eee;
    }

    thead tr th {
        font-size: 12px;
        padding: 2px 2px;
        background: #fff;
        min-width: 80px;
    }

    thead tr th:not(.small) {
        min-width: 130px;
    }
</style>
<script>
    $(document).ready(function () {
        $('#report-table').DataTable({
            scrollX: '100vw',
            scrollY: 'calc(100vh - 150px)',
            scroller: true,
            buttons: [
                'csv'
            ],
            dom: 'Bfrtip',
            fixedHeader: true,
            delayRender: true,



            "order": [
                [0, "asc"]
            ],
            "pageLength": 100,
            "lengthMenu": [100, 200, 500],


        });
    });
</script>
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/date-1.1.2/fh-3.2.4/sc-2.0.7/sb-1.3.4/sp-2.0.2/datatables.min.css" />
<script type="text/javascript"
    src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/date-1.1.2/fh-3.2.4/sc-2.0.7/sb-1.3.4/sp-2.0.2/datatables.min.js">
</script>
<?php get_footer(); ?><?php

?>
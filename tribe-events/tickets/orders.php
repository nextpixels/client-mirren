<?php
/**
 * Edit Event Tickets.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe/tickets/orders.php
 *
 * @link    https://evnt.is/1amp Help article for RSVP & Ticket template files.
 *
 * @since   4.7.4
 * @since   4.10.2 Only show Update button if ticket has meta.
 * @since   4.10.8 Show Update button if current user has either RSVP or Ticket with meta. Do not use the now-deprecated third parameter of `get_description_rsvp_ticket()`.
 * @since   4.10.9 Use function for text.
 * @since   4.11.3 Correct getting `$event_id` when using The Events Calendar's "Default Page Template" display template. `$event_id` now relies on the `WP_Query` queried object ID instead of the global `$post` object.
 * @since   4.11.3 Reformat a bit of the code around the button - no functional changes.
 * @since   4.12.1 Account for empty post type object, such as if post type got disabled.
 * @since   4.12.3 Account for inactive ticket providers.
 * @since   5.0.3 Add filter to control the re-sending emails option on email alteration.
 * @since   5.9.1 Corrected template override filepath
 *
 * @version 5.9.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Event Tickets Plus would set this from its own injected template to let us know about editable values.
global $tribe_my_tickets_have_meta;

$rsvp      = Tribe__Tickets__RSVP::get_instance();
$view      = Tribe__Tickets__Tickets_View::instance();
$event_id  = get_queried_object_id();
$event     = get_post( $event_id );
$post_type = get_post_type_object( $event->post_type );
$user_id   = get_current_user_id();
$provider  = Tribe__Tickets__Tickets::get_event_ticket_provider_object( $event_id );

/** @var Tribe__Tickets__Editor__Template $template */
$template = tribe( 'tickets.editor.template' );

$event_has_tickets = $event_has_rsvp = false;
$provider_class    = '';

if ( $provider ) {
	$event_has_tickets = ! empty( $provider->get_tickets( $event_id ) );
	$event_has_rsvp    = ! empty( $rsvp->get_tickets( $event ) );
	$provider_class    = $provider->class_name;
}

$user_has_tickets           = $view->has_ticket_attendees( $event_id, $user_id );
$user_has_rsvp              = $rsvp->get_attendees_count_going_for_user( $event_id, $user_id );
$tribe_my_tickets_have_meta = false;

/**
 * Use this filter to hide the Attendees List Optout
 *
 * @since 4.9
 *
 * @param bool
 */
$hide_attendee_list_optout = apply_filters( 'tribe_tickets_plus_hide_attendees_list_optout', false, $event_id );

/**
 * This filter allows the admin to control the re-send email option when an attendee's email is updated.
 *
 * @since 5.0.3
 * @since 5.1.0 Updated the parameters to match what is used in Event Tickets Plus.
 *
 * @param bool         $allow_resending_email Whether to allow email resending.
 * @param WP_Post|null $ticket                The ticket post object if available, otherwise null.
 * @param array|null   $attendee              The attendee information if available, otherwise null.
 */
$allow_resending_email = (int) apply_filters( 'tribe_tickets_my_tickets_allow_email_resend_on_attendee_email_update', true, null, null );

/**
 * Display a notice if the user doesn't have tickets
 */
if (
	(
		$event_has_tickets
		|| $event_has_rsvp
	)
	&& ! $user_has_tickets
	&& ! $user_has_rsvp
) {

	if ( $event_has_tickets ) {
		$no_ticket_message = sprintf(
			_x( "You don't have %s for this event", 'notice if user does not have tickets', 'event-tickets' ),
			tribe_get_ticket_label_plural_lowercase( 'notice_user_does_not_have_tickets' )
		);
	} else {
		$no_ticket_message = sprintf(
			_x( "You don't have %s for this event", 'notice if user does not have rsvps', 'event-tickets' ),
			tribe_get_rsvp_label_plural_lowercase( 'notice_user_does_not_have_rsvps' )
		);
	}

	Tribe__Notices::set_notice(
		'ticket-no-results',
		esc_html( $no_ticket_message )
	);
}

$post_type_singular = $post_type ? $post_type->labels->singular_name : _x( 'Post', 'fallback post type singular name', 'event-tickets' );

$is_event_page = is_singular( 'tribe_events' ) || is_singular( 'tribe_event_series' );
?>
<div id="tribe-events-content" class="tribe-events-single manage-passes-cont">
	<p class="tribe-back">
		<a href="<?php echo esc_url( get_permalink( $event_id ) ); ?>">
			<?php
			// Translators: %s: post type label.
			printf( '&laquo; ' . esc_html__( 'View %s', 'event-tickets' ), $post_type_singular );
			?>
		</a>
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>">
			View Order Receipts
		</a>
	</p>

	<?php if ( $is_event_page ) : ?>
		<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

		<div class="tribe-events-schedule tribe-clearfix" style="padding-bottom: 0;">
			<?php /*echo tribe_events_event_schedule_details( $event_id, '<h3><strong>', '</strong></h3>' ); ?>
			<?php if ( tribe_get_cost() ) : ?>
				<span class="tribe-events-cost"><?php echo tribe_get_cost( null, true ) ?></span>
			<?php endif;*/ ?>
			<!--<h3>
				Manage My Passes
			</h3>-->
		</div>
	<?php endif; ?>
	
	<!-- Notices -->
	<?php tribe_the_notices() ?>
	
	<?php
	// 1) Base/additional tickets (parent_id <= 0)
	$ticket_args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'meta_query' => [
			'relation' => 'AND',
			[
				'key' => '_tribe_wooticket_for_event',
				'value' => $event_id,
			],
			[
				'key' => 'parent_id',
				'value' => '0',
				'compare' => '<=',
			]
		],
		'fields'	=> 'ids',
	);
	$base_ticket_ids = get_posts( $ticket_args );
	if ( ! is_array( $base_ticket_ids ) ) {
		$base_ticket_ids = [];
	}

	if ($base_ticket_ids) {
		//echo '<pre>';
		//print_r($base_ticket_ids);
		//echo '</pre>';
	}
	
	// 2) Bundle tickets (parent_id > 0)
	$bundle_ticket_args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'meta_query' => [
			'relation' => 'AND',
			[
				'key' => '_tribe_wooticket_for_event',
				'value' => $event_id,
			],
			[
				'key' => 'parent_id',
				'value' => '0',
				'compare' => '>',
			]
		],
		'fields'	=> 'ids',
	);
	$bundle_ticket_ids_arr = get_posts($bundle_ticket_args);
	if ( ! is_array( $bundle_ticket_ids_arr ) ) {
		$bundle_ticket_ids_arr = [];
	}
	
	// Map: bundle_ticket_id => parent/base ticket product_id required
	$parent_ids = [];
	foreach ( $bundle_ticket_ids_arr as $bundle_ticket_id ) {
		$parent_ids[ (int) $bundle_ticket_id ] = (int) get_field( 'parent_id', $bundle_ticket_id );
	}
	
	// 3) Purchased ticket product IDs
	$orders = $view->get_event_attendees_by_order( $event_id, $user_id );
	//echo '<pre>';
	//print_r($orders);
	//echo '</pre>';
	
	$purchased_product_ids = [];
	if ( ! empty( $orders ) && is_array( $orders ) ) {
		foreach ( $orders as $order_id => $tickets ) {
			if ( empty( $tickets ) || ! is_array( $tickets ) ) {
				continue;
			}
			foreach ( $tickets as $ticket ) {
				if ( isset( $ticket['product_id'] ) ) {
					$purchased_product_ids[ (int) $ticket['product_id'] ] = true;
				}
			}
		}
	}
	
	// 4) Eligible bundles (only those whose parent ticket was purchased)
	$available_bundles = [];
	foreach ( $parent_ids as $bundle_ticket_id => $parent_ticket_id ) {
		if ( $parent_ticket_id && isset( $purchased_product_ids[ $parent_ticket_id ] ) ) {
			$available_bundles[] = (int) $bundle_ticket_id;
		}
	}
	
	$available_bundles = array_values( array_unique( $available_bundles ) );

	// 5) One combined ticket list for a single shortcode
	$all_ticket_ids = array_map('intval', array_merge( $base_ticket_ids, $available_bundles ));
	$all_ticket_ids = array_values( array_unique( $all_ticket_ids ) );
	
	if ( ! empty( $all_ticket_ids ) ) {
		echo '<div class="add-more-bundles">';
		echo '<div class="heading-toggle">';
		the_field( 'purchase_more_tickets', 'options' );
		echo '<h3 class="heading-toggle-icon-inactive">+</h3>';
		echo '<h3 class="heading-toggle-icon-active">-</h3>';
		echo '</div>';

		$all_ticket_ids_csv = implode( ',', $all_ticket_ids );

		echo '<div class="form-toggle">';
		echo do_shortcode('[tribe_tickets post_id="' . $event_id . '" ticket_id="' . esc_attr( $all_ticket_ids_csv ) . '"]');
		echo '</div>';

		echo '</div>';
	}
	
	// Old logic - standard and all access bundles
	/*
	if ( $purchased_v_standard === true || $purchased_v_access === true ) {
		echo '<div class="add-more-bundles">';
		the_field( 'add_more_ticket_bundles', 'options' );
		if ( $purchased_v_standard === true && $purchased_v_access === true ) {
			// Both
			echo do_shortcode( '[tribe_tickets_protected_content post_id="'. $event_id .'" ticket_ids="178,179"][tribe_tickets post_id="'. $event_id .'" ticket_id="4793,4798"][/tribe_tickets_protected_content]' );
		} elseif ( $purchased_v_access === true ) {
			// All Access
			echo do_shortcode( '[tribe_tickets_protected_content post_id="'. $event_id .'" ticket_ids="179"][tribe_tickets post_id="'. $event_id .'" ticket_id="4798"][/tribe_tickets_protected_content]' );
		} elseif ( $purchased_v_standard === true ) {
			// Standard
			echo do_shortcode( '[tribe_tickets_protected_content post_id="'. $event_id .'" ticket_ids="178"][tribe_tickets post_id="'. $event_id .'" ticket_id="4793"][/tribe_tickets_protected_content]' );
		}
		echo '</div>';
	}*/
	// Old logic - virtual all access only
	/*if ( $purchased_v_access === true ) {
	//if ( $has_orders ) {
		echo '<div class="add-more-bundles">';
		the_field( 'add_more_ticket_bundles', 'options' );
		// All Access
		//echo do_shortcode( '[tribe_tickets_protected_content post_id="95" ticket_ids="179"][tribe_tickets post_id="95" ticket_id="4798"][/tribe_tickets_protected_content]' );
		echo do_shortcode( '[tribe_tickets_protected_content post_id="95"][tribe_tickets post_id="95" ticket_id="4798"][/tribe_tickets_protected_content]' );
		echo '</div>';
	}*/
	?>

	<div
		class="event-tickets tribe-tickets__tickets-page-wrapper tribe-common"
		data-post-id="<?php echo esc_attr( $event_id ); ?>"
		data-provider="<?php echo esc_attr( $provider ); ?>"
		data-attendee-resend-email="<?php echo esc_attr( $allow_resending_email ); ?>"
	>

		<?php
		if ( ($event_has_tickets || $event_has_rsvp) && ($user_has_tickets || $user_has_rsvp) ) :
		?>
			<h3 class="tec-tickets__my-tickets-list-title" style="margin-top: 10px; margin-bottom: 30px;">Manage Attendees</h3>

			<form method="post" autocomplete="off" class="tribe-tickets__form">

				<?php $template->template( 'tickets/orders-rsvp' ); ?>

				<?php
				if ( ! class_exists( 'Tribe__Tickets_Plus__Commerce__PayPal__Meta' ) && Tribe__Tickets__Commerce__PayPal__Main::class === $provider_class ) {
					$template->template( 'tickets/orders-pp-tickets' );
				}
				?>

				<?php
				if ( ! class_exists( 'Tribe__Tickets_Plus__Meta' ) && \TEC\Tickets\Commerce\Module::class === $provider_class ) {
					$template->template( 'tickets/orders-tc-tickets' );
				}
				?>

				<?php
				/**
				 * Fires before the process tickets submission button is rendered
				 */
				do_action( 'tribe_tickets_orders_before_submit' );
				?>

				<?php if (
					// Current user has RSVP (with or without meta) so needs to be able to edit status
					$view->has_rsvp_attendees( $event_id, get_current_user_id() )
					|| (
						// Current user has tickets with meta so needs to be able to edit meta
						$view->has_ticket_attendees( $event_id, get_current_user_id() )
						&& $tribe_my_tickets_have_meta
					)
					|| ! $hide_attendee_list_optout
				) : ?>
					<div class="tribe-submit-tickets-form edit-attendees" style="margin-bottom: 20px;">
						<button
							type="submit"
							name="process-tickets"
							value="1"
							class="button alt tribe-common-c-btn tribe-common-c-btn--small"
						>
							<?php //echo sprintf( esc_html__( 'Update %s', 'event-tickets' ), $view->get_description_rsvp_ticket( $event_id, get_current_user_id() ) ); ?>
							<?php echo 'Save Updates'; ?>
						</button>
					</div>
				<?php endif;
				// unset our global since we don't need it any more
				unset( $tribe_my_tickets_have_meta );
				?>
			</form>
		<?php endif; ?>

	</div>

</div>

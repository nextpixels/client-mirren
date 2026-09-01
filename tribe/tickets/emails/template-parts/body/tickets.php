<?php
/**
 * Event Tickets Emails: Main template > Body > Tickets.
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/tickets/emails/template-parts/body/tickets.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/tickets-emails-tpl Help article for Tickets Emails template files.
 * If you are looking for Event related templates, see in The Events Calendar plugin.
 *
 * @version 5.5.9
 *
 * @since 5.5.9
 *
 * @var Tribe__Template                    $this             Current template object.
 * @var \TEC\Tickets\Emails\Email_Abstract $email            The email object.
 * @var bool                               $preview          Whether the email is in preview mode or not.
 * @var bool                               $is_tec_active    Whether `The Events Calendar` is active or not.
 * @var array                              $tickets          The list of tickets.
 * @var WP_Post|null                       $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( empty( $tickets ) ) {
	return;
}
$i = 0;

//$post = get_post( $event );

//$this->template( 'template-parts/body/tickets-total' );

//di_debug_log($tickets);


// Ticket Name(s) Wording
$ticket_wording = '';

$ticket_counts = array();

foreach ( (array) $tickets as $t ) {
	$product_id_raw = isset( $t['product_id'] ) ? $t['product_id'] : 0;
	$product_id     = (int) $product_id_raw;

	$ticket_name_raw = isset( $t['ticket_name'] ) ? (string) $t['ticket_name'] : '';
	$display_name    = trim( $ticket_name_raw );

	// If this is a bundled product, try to resolve to the parent product title via ACF.
	if ( $product_id > 0 && function_exists( 'get_field' ) ) {
		$is_bundled = (bool) get_field( 'bundled_product', $product_id );

		if ( $is_bundled ) {
			$parent_id_raw = get_field( 'parent_id', $product_id );
			$parent_id     = (int) $parent_id_raw;

			if ( $parent_id > 0 ) {
				$parent_post = get_post( $parent_id );

				if ( $parent_post && ! is_wp_error( $parent_post ) ) {
					$parent_title = trim( get_the_title( $parent_id ) );

					if ( '' !== $parent_title ) {
						$display_name = $parent_title;
					}
				}
			}
		}
	}

	if ( '' === $display_name ) {
		$display_name = 'Single Pass';
	}

	if ( ! isset( $ticket_counts[ $display_name ] ) ) {
		$ticket_counts[ $display_name ] = 0;
	}

	$ticket_counts[ $display_name ]++;
}

// If there's more than one ticket total, show "Name xN, Other xM".
if ( count( (array) $tickets ) > 1 ) {
	$parts = array();

	foreach ( $ticket_counts as $name => $qty ) {
		$parts[] = esc_html( $name ) . ' x' . (int) $qty;
	}

	$ticket_wording = implode( ', ', $parts );
} else {
	// Single ticket: keep "a/an ..." and apply resolved name.
	$single_name = (string) array_key_first( $ticket_counts );

	/*$first_char = strtolower( substr( $single_name, 0, 1 ) );
	$an_a       = in_array( $first_char, array( 'a', 'e', 'i', 'o', 'u' ), true ) ? 'an' : 'a';

	$ticket_wording = $an_a . ' ' . esc_html( $single_name );*/
	
	$ticket_wording = $single_name;
}

// Body Wording
$attendee_in_person = false;
$attendee_virtual = false;
$comp_ticket = false;

foreach ( $tickets as $ticket ) {
	//di_debug_log($ticket);
	if ( has_term( 'in-person', 'product_cat', $ticket['product_id'] ) ) {
		$attendee_in_person = true;
	}
	if ( has_term( 'virtual', 'product_cat', $ticket['product_id'] ) ) {
		$attendee_virtual = true;
	}
	/*if ( $ticket['attendee_meta']['comp']['value'] ) {
		if ( $ticket['attendee_meta']['comp']['value'] == 'Yes' ) {
			$comp_ticket = true;
		}
	}*/
	$attendee_meta = isset( $ticket['attendee_meta'] ) && is_array( $ticket['attendee_meta'] )
		? $ticket['attendee_meta']
		: [];
	$comp_value = $attendee_meta['comp']['value'] ?? '';
	if ( $comp_value === 'Yes' ) {
        $comp_ticket = true;
    }
}

$attendee_in_person_wording = get_field( 'ticket_email_in-person', 'options' );
$attendee_virtual_wording = get_field( 'ticket_email_virtual', 'options' );
$attendee_both_wording = get_field( 'ticket_email_both', 'options' );

if ( $comp_ticket === true ) {
	
	$comp_update_wording = get_field( 'updates_to_your_pass_comp', 'options' );
	
	$attendee_in_person_wording = str_replace( '{inserts_update_wording_below}', $comp_update_wording, $attendee_in_person_wording );
	$attendee_virtual_wording = str_replace( '{inserts_update_wording_below}', $comp_update_wording, $attendee_virtual_wording );
	$attendee_both_wording = str_replace( '{inserts_update_wording_below}', $comp_update_wording, $attendee_both_wording );
	
} else {
	
	$not_comp_update_wording = get_field( 'updates_to_your_pass_not_comp', 'options' );
	
	$attendee_in_person_wording = str_replace( '{inserts_update_wording_below}', $not_comp_update_wording, $attendee_in_person_wording );
	$attendee_in_person_wording = str_replace( '{insert purchaser name}', $tickets[0]['purchaser_name'], $attendee_in_person_wording );
	$attendee_in_person_wording = str_replace( '{insert purchaser email}', $tickets[0]['purchaser_email'], $attendee_in_person_wording );

	$attendee_virtual_wording = str_replace( '{inserts_update_wording_below}', $not_comp_update_wording, $attendee_virtual_wording );
	$attendee_virtual_wording = str_replace( '{insert purchaser name}', $tickets[0]['purchaser_name'], $attendee_virtual_wording );
	$attendee_virtual_wording = str_replace( '{insert purchaser email}', $tickets[0]['purchaser_email'], $attendee_virtual_wording );

	$attendee_both_wording = str_replace( '{inserts_update_wording_below}', $not_comp_update_wording, $attendee_both_wording );
	$attendee_both_wording = str_replace( '{insert purchaser name}', $tickets[0]['purchaser_name'], $attendee_both_wording );
	$attendee_both_wording = str_replace( '{insert purchaser email}', $tickets[0]['purchaser_email'], $attendee_both_wording );
	
}

$intro_text_wording = get_field('ticket_email_intro', 'options');

$event_name_link = sprintf(
	'<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
	esc_url( get_permalink( $post ) ),
	esc_html( $post->post_title )
);

$intro_processed = str_replace(
	array( '{event_name_link}', '{ticket_name}' ),
	array( $event_name_link, esc_html( $ticket_wording ) ),
	$intro_text_wording
);

?>

<tr>
	<td>
		<p>
			Hi <?php echo esc_html( $tickets[0]['holder_name'] ); ?>,
		</p>
		<?php
		echo $intro_processed;

		if ( $attendee_in_person === true && $attendee_virtual === true ) {
			echo $attendee_both_wording;
		} else if ( $attendee_in_person === true && $attendee_virtual === false ) {
			echo $attendee_in_person_wording;
		} else if ( $attendee_virtual === true && $attendee_in_person === false ) {
			echo $attendee_virtual_wording;
		}

		?>
	</td>
</tr>
<tr>
	<td style="padding: 10px;"></td>
</tr>

<?php 
/*
<tr>
	<td style="padding:0;">
		<table class="tec-tickets__email-table-content-tickets" role="presentation">
		<?php foreach ( $tickets as $ticket ) : ?>
			<?php $i++; ?>
			<tr>
				<td class="tec-tickets__email-table-content-ticket">
					<table class="tec-tickets__email-table-content-ticket-table">
						<tr>
							<?php $this->template( 'template-parts/body/ticket/holder-name', [ 'ticket' => $ticket ] ); ?>
							<?php $this->template( 'template-parts/body/ticket/ticket-name', [ 'ticket' => $ticket ] ); ?>
						</tr>
						<tr>
							<?php $this->template( 'template-parts/body/ticket/security-code', [ 'ticket' => $ticket ] ); ?>
						</tr>
					</table>
					<?php $this->template( 'template-parts/body/ticket/number-from-total', [ 'i' => $i ] ); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	</td>
</tr>
*/
?>

<?php

include_once( get_template_directory() . '/functions/ergo-embed-styles-scripts.php' );
require_once( get_template_directory() . '/functions/ergo-include-section.php' );
// Don't need since $session returns the post object
//require_once( get_template_directory() . "/functions/ergo-get-posts-from-args.php" );

ergo_embed_styles_scripts( __DIR__ );

$session                           = get_field( 'session' );
$strapline                         = get_field( 'strapline' );
$text                              = get_field( 'text' );
$attendance_type                   = get_field( 'attendance_type' );
$session_full                      = get_field( 'session_full' );
$zapier_google_sheet_tab           = get_field( 'zapier_google_sheet_tab' );
$zapier_calendar_event_search_term = get_field( 'zapier_calendar_event_search_term' );

if ( empty( $session ) || empty( $session->ID ) ) {
	return;
}

$session_id = (int) $session->ID;

// Don't need since $session returns the post object
/*$args = array(
	'post_type'      => 'sessions',
	'post_status'    => 'publish',
	'posts_per_page' => 1,
	'post__in'       => array( $session_id ),
	'orderby'        => 'post__in',
);

$postData = ergo_get_posts_from_args( $args );

if ( empty( $postData[0] ) ) {
	return;
}*/

/*
 * Normalize attendance type values from the block.
 */
$attendance_type = is_array( $attendance_type ) ? $attendance_type : array_filter( array( $attendance_type ) );
$attendance_type = array_map( 'sanitize_key', $attendance_type );
$attendance_type = array_filter( $attendance_type );

/*
 * Session post data.
 */
$session_title       = get_the_title( $session_id );
$session_description = get_field( 'session_description', $session_id );
$session_timestamp_raw = get_field( 'session_timestamp', $session_id, false );
$session_speakers_raw  = get_field( 'session_speakers', $session_id );

/*
 * Normalize speakers into a comma-separated string.
 */
$session_speakers_lines = preg_split(
	'/\r\n|\r|\n/',
	wp_strip_all_tags( (string) $session_speakers_raw )
);

$session_speakers_lines = array_filter( array_map( 'trim', $session_speakers_lines ) );
$session_speakers       = implode( ', ', $session_speakers_lines );

/*
 * Parse session datetime.
 * Current observed format is Y-m-d H:i:s, but support YmdHis as fallback.
 * Do not include timezone in any displayed values.
 */
$session_dt = false;

if ( ! empty( $session_timestamp_raw ) ) {
	$formats = array(
		'Y-m-d H:i:s',
		'YmdHis',
	);

	foreach ( $formats as $format ) {
		$parsed = DateTime::createFromFormat( $format, $session_timestamp_raw );

		if ( $parsed instanceof DateTime ) {
			$session_dt = $parsed;
			break;
		}
	}
}

$session_date_display = $session_dt ? $session_dt->format( 'F j, Y' ) : '';
$session_time_display = $session_dt ? $session_dt->format( 'g:i A' ) : '';
$session_iso          = '';

$is_session_full = ( 'yes' === strtolower( trim( (string) $session_full ) ) );

?>

<div class="think-tank-tile session-tile">
	<?php if ( ! empty( $strapline ) ) : ?>
		<div class="strapline"><?php echo esc_html( $strapline ); ?></div>
	<?php endif; ?>

	<h3><?php echo esc_html( $session_title ); ?></h3>

	<?php
	ergo_include_section(
		'ergo/acf-blocks/text-accordion',
		array(
			'title'    => 'Session Description',
			'text'     => wpautop( (string) $session_description ),
			'caretUrl' => get_stylesheet_directory_uri() . '/elements-acf/text-accordion/caret-dark.svg',
		)
	);
	?>

	<?php if ( ! empty( $text ) ) : ?>
		<div class="session-tile__text">
			<?php echo wp_kses_post( $text ); ?>
		</div>
	<?php endif; ?>

	<div class="session-tile__actions">
		<?php if ( $is_session_full ) : ?>
			<span class="session-tile__full">Session is Full</span>
		<?php else : ?>
			<button
				type="button"
				class="session-rsvp-button"
				data-session-id="<?php echo esc_attr( $session_id ); ?>"
				data-session-title="<?php echo esc_attr( $session_title ); ?>"
				data-session-speakers="<?php echo esc_attr( $session_speakers ); ?>"
				data-session-date="<?php echo esc_attr( $session_date_display ); ?>"
				data-session-time="<?php echo esc_attr( $session_time_display ); ?>"
				data-session-timestamp="<?php echo esc_attr( (string) $session_timestamp_raw ); ?>"
				data-google-sheet-tab="<?php echo esc_attr( (string) $zapier_google_sheet_tab ); ?>"
				data-calendar-search-term="<?php echo esc_attr( (string) $zapier_calendar_event_search_term ); ?>"
				data-attendance-type="<?php echo esc_attr( implode( ',', $attendance_type ) ); ?>"
				aria-haspopup="dialog"
			>
				RSVP Now &raquo;
			</button>
		<?php endif; ?>
	</div>
</div>
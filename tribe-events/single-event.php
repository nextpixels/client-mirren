<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

/**
 * Allows filtering of the single event template title classes.
 *
 * @since 5.8.0
 *
 * @param array  $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @since 5.8.0
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 */
$before = apply_filters( 'tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id );

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 */
$after = apply_filters( 'tribe_events_single_event_title_html_after', '</h1>', $event_id );

/**
 * Allows filtering of the single event template title HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display. Return an empty string to not display the title.
 * @param string $event_id The ID of the displayed event.
 */
$title = apply_filters( 'tribe_events_single_event_title_html', the_title( $before, $after, false ), $event_id );
/*
ergo_include_section("elements/hero-cta-right",array(
		"Title" => "Register",
		"Text" => "",
		"Class" => "home-hero",
		"Image_Mobile" => "/pages/register/hero-register.jpg",
		"Image" => "/pages/register/hero-register.jpg",
		"HideCTABox" => true
));
*/

$view      = Tribe__Tickets__Tickets_View::instance();

$user_id   = get_current_user_id();

$manage_attendees_url = function_exists( 'di_get_active_mirren_event_tickets_url' )
	? di_get_active_mirren_event_tickets_url()
	: '';

$has_orders = false;
$purchased_v_standard = false;
$purchased_v_access = false;
if ( $user_id && $user_id !== 0 ) {
	$orders = $view->get_event_attendees_by_order( $event_id, $user_id );
	if ( !empty( $orders ) ) {
		$has_orders = true;
		foreach ( $orders as $order_id => $tickets ) {
			foreach ( $tickets as $ticket ) {
				if ( $ticket['product_id'] == '178' ) {
					$purchased_v_standard = true;
				}
				if ( $ticket['product_id'] == '179' ) {
					$purchased_v_access = true;
				}
			}
		}
	}
}
?>



<div id="tribe-events-content" class="tribe-events-single p-t-75">

	<div class="container mdpadding">


		<?php while ( have_posts() ) :  the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<!-- Event featured image, but exclude link -->
				<?php echo tribe_event_featured_image( $event_id, 'full', false ); ?>

				<!-- Event content -->
				<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
				
					<div class="p-b-25" style="padding-bottom: 0;">
					
					<?php
					$ctaTitle 					=  get_field('hero_cta_title', 'options');
					$ctaText 					=  get_field('hero_cta_text', 'options'); 
					
					if ($ctaTitle || $ctaText ){ ?>
						<div class="p-b-20">
							<div class="registration-highlight-box">
								<h3><?php echo $ctaTitle; ?></h3>
								<?php
								if (!empty($ctaText)){
									echo "<p>".$ctaText."</p>";
								}
								?>
								<?php
								if ( $manage_attendees_url ) {
									$manage_attendees_button = sprintf(
										'<div style="margin-top: 10px; margin-right: 12px; display: inline-block"><a href="%1$s" class="button">%2$s</a></div>',
										esc_url( $manage_attendees_url ),
										get_field( 'manage_attendees_button_text', 'options' )
									);

									echo do_shortcode( '[tribe_tickets_protected_content]' . $manage_attendees_button . '[/tribe_tickets_protected_content]' );
								}
								?>
								<?php
								if ( $manage_attendees_url && ( $purchased_v_standard === true || $purchased_v_access === true ) ) {
								//if ( $purchased_v_access === true ) {
								//if ( $has_orders === true ) {
									echo '<div style="margin-top: 20px; display: inline-block"><a href="' . esc_url( $manage_attendees_url ) . '" class="button">' . get_field( 'purchase_more_bundles_button_text', 'options' ) . '</a></div>';
								}
								?>
							</div>
						</div><?php
					}	?>
					
					<?php the_content(); ?>
					
					
					</div><?php
					ergo_include_section("mirren-elements/register-list");	?>

					<div class="columns-flex collapse-800 register-terms" style="padding-right: 20px;">
						<div class="col col-fluid"></div>
						<div class="col col-600">
							<div class="text-right" style="line-height: .9;">
								<small>
								Registration is for agencies, clients and search consultants only.<br />
								By registering, you agree to our <a class="small" href="<?php echo get_site_url(); ?>/privacy-policy/">Terms &amp; Conditions</a>.
								</small>
							</div>
						</div>
					</div>

			</div> <!-- #post-x -->
			
			<div class="p-t-75" style="text-align: center;"></div>
			<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
		<?php endwhile; ?>

	</div>


</div><!-- #tribe-events-content -->

<script>

	$('.workshops-popup-close').click(function (){
		$('.workshops-popup').addClass('closed');
		$('.benefit-workshop').addClass('closed');
	});

	$('.workshops-popup-bg').click(function (){
		$('.workshops-popup').addClass('closed');
		$('.benefit-workshop').addClass('closed');
	});

	$('.workshop-attached').click(function (){
		var workshopnum = $(this).attr("data-workshop");

		$('.benefit-workshop[data-number="' + workshopnum +'"]').removeClass('closed');
	});

	$("#tribe-tickets__tickets-item-quantity-number--15805").change(function(){

		if( ( parseInt($("#tribe-tickets__tickets-item-quantity-number--15805").val()) + parseInt($("#tribe-tickets__tickets-item-quantity-number--15806").val()) ) > 3 ){
			$(".group-discount-message").removeClass('hidden');
		} else {
			$(".group-discount-message").addClass('hidden');
		}

    });

	$("#tribe-tickets__tickets-item-quantity-number--15806").change(function(){
		if( ( parseInt($("#tribe-tickets__tickets-item-quantity-number--15805").val()) + parseInt($("#tribe-tickets__tickets-item-quantity-number--15806").val()) ) > 3 ){
			$(".group-discount-message").removeClass('hidden');
		} else {
			$(".group-discount-message").addClass('hidden');
		}

    });

</script>
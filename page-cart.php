<?php
/**
 * This template is loaded to display single page posts.
 *
 * @package		Twirling_Umbrellas_Theme
 * @author		Twirling Umbrellas Inc.
 * @copyright	2013-2019 Twirling Umbrellas Inc.
 * @link		https://www.twirlingumbrellas.ca
 * @since		1.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $framework;

get_header();

the_post();

?>

<script>
$(document).ready(function () {
    //Handler for .ready() called.


    // $('html, body').animate({
    //     scrollTop: $('#thecart').offset().top - ( cartheight / 2 )
    // }, 'slow');

    document.getElementById('thecart').scrollIntoView({ behavior: 'smooth', block: 'end' });

});
</script>


<div id="page" class="contain-1100 p-mobile-1150 p-t-100">

	<main id="content" class="smmargin smpadding" role="main" itemprop="mainEntityOfPage">

		<div class="container">

            <h1 class="p-b-25">Your Order Summary</h1>

            <div id="pricing-wrap">
				
				<div class="p-b-15">
					<a href="<?php echo get_field('hero_cta_button_href', 'options'); ?>">< Back</a>
				</div>
				<?php
				//ergo_include_section("pages/register/register-list");
			?>
				
                <?php $home_id = get_option('page_on_front'); ?>

                <?php if( get_field( 'enable_section_pricing', $home_id ) ):

                    $e = 7;

                    $pricing_section_content			= get_field('pricing_section_content', $home_id);
                    $pricing_section_content_extra		= get_field('pricing_section_content_extra', $home_id);

                    ?>

                    <div id="homepage-pricing">

                        <div class="mdmargin">

                            <div id="pricing-table">

                                <div class="inner-wrap">

                                    <div class="pricing-table-head row">
                                        <div class="col-6"></div>
                                        <!--<div class="col-2">Entry</div> -->
                                        <div class="col-3">Standard</div>
                                        <div class="col-3">All Access</div>
                                    </div>

                                    <?php if( have_rows('benefits', $home_id) ): ?>
                                        <?php while( have_rows('benefits', $home_id) ): the_row(); 
                                            $benefit_info 	= get_sub_field('benefit_info');
                                            $tier_1 		= get_sub_field('tier_1');
                                            $tier_2 		= get_sub_field('tier_2');
                                            $tier_3 		= get_sub_field('tier_3');

                                            $workshop_attached = get_sub_field('workshop_attached');
                                            ?>
                                            <div class="benefits-row row">
                                                <div class="col-6">
                                                    <?php echo $benefit_info; ?>
                                                    <?php if( $workshop_attached ): ?>
                                                        <div class="workshop-attached" data-workshop="<?php echo $workshop_attached[0]; ?>">
                                                            <img src="/wp-content/uploads/question_icon.svg">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                               <!-- <div class="col-2"><?php if( $tier_1 ): ?> <img src="/wp-content/uploads/check_icon.svg"> <?php endif; ?></div> -->
                                                <div class="col-3"><?php if( $tier_2 ): ?> <img src="/wp-content/uploads/check_icon.svg"> <?php endif; ?></div>
                                                <div class="col-3"><?php if( $tier_3 ): ?> <img src="/wp-content/uploads/check_icon.svg"> <?php endif; ?></div>
                                            </div>

                                            <?php if( $workshop_attached ): ?>
                                                <div class="benefit-workshop closed" data-number="<?php echo $workshop_attached[0]; ?>">

                                                    <div class="workshops-popup-bg"></div>

                                                    <div class="workshop-popup container">

                                                        <span class="workshops-popup-close"></span>

                                                        <div class="row justify-content-between">
                                                            <div class="col-12 col-lg-5">
                                                                <div class="workshop-info">
                                                                    <span class="workshop-cat"><?php echo get_field('workshop_category', $workshop_attached[0]); ?></span>

                                                                    <h2 class="workshop-title"><?php echo get_the_title($workshop_attached[0]); ?></h2>

                                                                    <hr>

                                                                    <div class="bottom-wrap">
                                                                        <span class="workshop-date">
                                                                            <img src="/wp-content/uploads/calendar_icon.svg">
                                                                            <?php echo get_field('workshop_date', $workshop_attached[0]); ?>
                                                                        </span>
                                                                        <span class="workshop-time">
                                                                            <img src="/wp-content/uploads/clock_icon.png">
                                                                            <?php echo get_field('workshop_start_time', $workshop_attached[0]); ?> - <?php echo get_field('workshop_end_time', $workshop_attached[0]); ?> ET
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-lg-6">
                                                                <?php echo get_field('workshop_full_description', $workshop_attached[0]); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>

                                    <div class="special-pricing-row special-10 row">
                                        <div class="col-6">
                                            <strong>Special Group Pricing (10+)</strong>
                                        </div>
                                        <div class="col-3">
                                            <?php if( get_field('tier_2_pricing', $home_id) ):

                                                $tier_2 = get_field('tier_2_pricing', $home_id);

                                                if ( $tier_2['10_group_pricing_sale_price'] && $tier_2['10_group_pricing_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_2['10_group_pricing_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_2['10_group_pricing_regular_price'] . '</span></span>';
                                                } else if ( $tier_2['10_group_pricing_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_2['10_group_pricing_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div>
                                        <div class="col-3">
                                            <?php if( get_field('tier_3_pricing', $home_id) ):

                                                $tier_3 = get_field('tier_3_pricing', $home_id);

                                                if ( $tier_3['10_group_pricing_sale_price'] && $tier_3['10_group_pricing_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_3['10_group_pricing_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_3['10_group_pricing_regular_price'] . '</span></span>';
                                                } else if ( $tier_3['10_group_pricing_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_3['10_group_pricing_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div>
                                    </div>

                                    <div class="special-pricing-row special-4 row">
                                        <div class="col-6">
                                            <strong>Special Group Pricing (4+)</strong>
                                        </div>
                                       <!-- <div class="col-2">
                                            <?php if( get_field('tier_1_pricing', $home_id) ):

                                                $tier_1 = get_field('tier_1_pricing', $home_id);

                                                if ( $tier_1['special_group_pricing_sale_price'] && $tier_1['special_group_pricing_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_1['special_group_pricing_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_1['special_group_pricing_regular_price'] . '</span></span>';
                                                } else if ( $tier_1['special_group_pricing_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_1['special_group_pricing_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?> 
                                        </div> -->
                                        <div class="col-3">
                                            <?php if( get_field('tier_2_pricing', $home_id) ):

                                                $tier_2 = get_field('tier_2_pricing', $home_id);

                                                if ( $tier_2['special_group_pricing_sale_price'] && $tier_2['special_group_pricing_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_2['special_group_pricing_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_2['special_group_pricing_regular_price'] . '</span></span>';
                                                } else if ( $tier_2['special_group_pricing_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_2['special_group_pricing_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div>
                                        <div class="col-3">
                                            <?php if( get_field('tier_3_pricing', $home_id) ):

                                                $tier_3 = get_field('tier_3_pricing', $home_id);

                                                if ( $tier_3['special_group_pricing_sale_price'] && $tier_3['special_group_pricing_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_3['special_group_pricing_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_3['special_group_pricing_regular_price'] . '</span></span>';
                                                } else if ( $tier_3['special_group_pricing_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_3['special_group_pricing_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div>
                                    </div>

                                    <div class="single-pricing-row row">
                                        <div class="col-6"><strong>Single Pass</strong></div>
                                    <!--    <div class="col-2">
                                            <?php if( get_field('tier_1_pricing', $home_id) ):

                                                $tier_1 = get_field('tier_1_pricing', $home_id);

                                                if ( $tier_1['single_pass_price_sale_price'] && $tier_1['single_pass_price_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_1['single_pass_price_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_1['single_pass_price_regular_price'] . '</span></span>';
                                                } else if ( $tier_1['single_pass_price_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_1['single_pass_price_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div> -->
                                        <div class="col-3">
                                            <?php if( get_field('tier_2_pricing', $home_id) ):

                                                $tier_2 = get_field('tier_2_pricing', $home_id);

                                                if ( $tier_2['single_pass_price_sale_price'] && $tier_2['single_pass_price_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_2['single_pass_price_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_2['single_pass_price_regular_price'] . '</span></span>';
                                                } else if ( $tier_2['single_pass_price_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_2['single_pass_price_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div>
                                        <div class="col-3">
                                            <?php if( get_field('tier_3_pricing', $home_id) ):

                                                $tier_3 = get_field('tier_3_pricing', $home_id);

                                                if ( $tier_3['single_pass_price_sale_price'] && $tier_3['single_pass_price_regular_price'] ){
                                                    echo '<span class="sale-price bigprice">$' . $tier_3['single_pass_price_sale_price'] . '</span>';
                                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_3['single_pass_price_regular_price'] . '</span></span>';
                                                } else if ( $tier_3['single_pass_price_regular_price'] ){
                                                    echo '<span class="regular-price bigprice">$' . $tier_3['single_pass_price_regular_price'] . '</span>';
                                                } else {
                                                    // do nothing
                                                }

                                            endif; ?>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div id="pricing-table-mobile">

                     <!--   <?php if( get_field('tier_1_pricing', $home_id) ):

                            $tier_1_m = get_field('tier_1_pricing', $home_id);

                            ?>

                            <div class="pricing-box-mobile tier-1">

                                <div class="pricing-box-head">
                                    Entry
                                </div>

                                <div class="pricing-box-benefits">
                                <?php if( have_rows('benefits', $home_id) ): ?>
                                    <?php while( have_rows('benefits', $home_id) ): the_row();
                                        $benefit_info 	= get_sub_field('benefit_info');
                                        $tier_1 		= get_sub_field('tier_1');
                                        $tier_2 		= get_sub_field('tier_2');
                                        $tier_3 		= get_sub_field('tier_3');

                                        $workshop_attached = get_sub_field('workshop_attached');
                                        ?>

                                        <?php if( $tier_1 ): ?>
                                        <div class="benefits-row row">
                                            <div class="col-12">
                                                <img src="/wp-content/uploads/check_icon.svg">

                                                <div class="inner">
                                                    <?php echo $benefit_info; ?>
                                                    <?php if( $workshop_attached ): ?>
                                                        <div class="workshop-attached" data-workshop="<?php echo $workshop_attached[0]; ?>">
                                                            <img src="/wp-content/uploads/question_icon.svg">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                </div>

                                <?php if ( $tier_1_m['special_group_pricing_sale_price'] && $tier_1_m['special_group_pricing_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Special Group Pricing (4+)</div><div class="right"><span class="sale-price bigprice">$' . $tier_1_m['special_group_pricing_sale_price'] . '</span>';
                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_1_m['special_group_pricing_regular_price'] . '</span></span></div></div>';
                                } else if ( $tier_1_m['special_group_pricing_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Special Group Pricing (4+)</div><div class="right"><span class="regular-price bigprice">$' . $tier_1_m['special_group_pricing_regular_price'] . '</span></div></div>';
                                } else {
                                    // do nothing
                                } ?>

                                <?php if ( $tier_1_m['single_pass_price_sale_price'] && $tier_1_m['single_pass_price_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Single Pass</div><div class="right"><span class="sale-price bigprice">$' . $tier_1_m['single_pass_price_sale_price'] . '</span>';
                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_1_m['single_pass_price_regular_price'] . '</span></span></div></div>';
                                } else if ( $tier_1_m['single_pass_price_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Single Pass</div><div class="right"><span class="regular-price bigprice">$' . $tier_1_m['single_pass_price_regular_price'] . '</span></div></div>';
                                } else {
                                    // do nothing
                                } ?>

                            </div>

                        <?php endif; ?> -->

                        <?php if( get_field('tier_2_pricing', $home_id) ):

                            $tier_2_m = get_field('tier_2_pricing', $home_id);

                            ?>

                            <div class="pricing-box-mobile tier-2">

                                <div class="pricing-box-head">
                                    Standard
                                </div>

                                <div class="pricing-box-benefits">
                                <?php if( have_rows('benefits', $home_id) ): ?>
                                    <?php while( have_rows('benefits', $home_id) ): the_row();
                                        $benefit_info 	= get_sub_field('benefit_info');
                                        $tier_1 		= get_sub_field('tier_1');
                                        $tier_2 		= get_sub_field('tier_2');
                                        $tier_3 		= get_sub_field('tier_3');

                                        $workshop_attached = get_sub_field('workshop_attached');
                                        ?>

                                        <?php if( $tier_2  ): ?>
                                        <div class="benefits-row row">
                                            <div class="col-12">
                                                <img src="/wp-content/uploads/check_icon.svg">

                                                <div class="inner">
                                                    <?php echo $benefit_info; ?>
                                                    <?php if( $workshop_attached ): ?>
                                                        <div class="workshop-attached" data-workshop="<?php echo $workshop_attached[0]; ?>">
                                                            <img src="/wp-content/uploads/question_icon.svg">
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                </div>

                                <?php if ( $tier_2_m['10_group_pricing_sale_price'] && $tier_2_m['10_group_pricing_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Special Group Pricing (10+)</div><div class="right"><span class="sale-price bigprice">$' . $tier_2_m['10_group_pricing_sale_price'] . '</span>';
                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_2_m['10_group_pricing_regular_price'] . '</span></span></div></div>';
                                } else if ( $tier_2_m['10_group_pricing_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Special Group Pricing (10+)</div><div class="right"><span class="regular-price bigprice">$' . $tier_2_m['10_group_pricing_regular_price'] . '</span></div></div>';
                                } else {
                                    // do nothing
                                } ?>

                                <?php if ( $tier_2_m['special_group_pricing_sale_price'] && $tier_2_m['special_group_pricing_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Special Group Pricing (4+)</div><div class="right"><span class="sale-price bigprice">$' . $tier_2_m['special_group_pricing_sale_price'] . '</span>';
                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_2_m['special_group_pricing_regular_price'] . '</span></span></div></div>';
                                } else if ( $tier_2_m['special_group_pricing_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Special Group Pricing (4+)</div><div class="right"><span class="regular-price bigprice">$' . $tier_2_m['special_group_pricing_regular_price'] . '</span></div></div>';
                                } else {
                                    // do nothing
                                } ?>

                                <?php if ( $tier_2_m['single_pass_price_sale_price'] && $tier_2_m['single_pass_price_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Single Pass</div><div class="right"><span class="sale-price bigprice">$' . $tier_2_m['single_pass_price_sale_price'] . '</span>';
                                    echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_2_m['single_pass_price_regular_price'] . '</span></span></div></div>';
                                } else if ( $tier_2_m['single_pass_price_regular_price'] ){
                                    echo '<div class="sale-pricing"><div class="left">Single Pass</div><div class="right"><span class="regular-price bigprice">$' . $tier_2_m['single_pass_price_regular_price'] . '</span></div></div>';
                                } else {
                                    // do nothing
                                } ?>

                            </div>

                            <?php endif; ?>

                            <?php if( get_field('tier_3_pricing', $home_id) ):

                                $tier_3_m = get_field('tier_3_pricing', $home_id);

                                ?>

                                <div class="pricing-box-mobile tier-2">

                                    <div class="pricing-box-head">
                                        All Access
                                    </div>

                                    <div class="pricing-box-benefits">
                                    <?php if( have_rows('benefits', $home_id) ): ?>
                                        <?php while( have_rows('benefits', $home_id) ): the_row();
                                            $benefit_info 	= get_sub_field('benefit_info');
                                            $tier_1 		= get_sub_field('tier_1');
                                            $tier_2 		= get_sub_field('tier_2');
                                            $tier_3 		= get_sub_field('tier_3');

                                            $workshop_attached = get_sub_field('workshop_attached');
                                            ?>

                                            <?php if( $tier_3  ): ?>
                                            <div class="benefits-row row">
                                                <div class="col-12">
                                                    <img src="/wp-content/uploads/check_icon.svg">

                                                    <div class="inner">
                                                        <?php echo $benefit_info; ?>
                                                        <?php if( $workshop_attached ): ?>
                                                            <div class="workshop-attached" data-workshop="<?php echo $workshop_attached[0]; ?>">
                                                                <img src="/wp-content/uploads/question_icon.svg">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php endif; ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                    </div>

                                    <?php if ( $tier_3_m['10_group_pricing_sale_price'] && $tier_3_m['10_group_pricing_regular_price'] ){
                                        echo '<div class="sale-pricing"><div class="left">Special Group Pricing (10+)</div><div class="right"><span class="sale-price bigprice">$' . $tier_3_m['10_group_pricing_sale_price'] . '</span>';
                                        echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_3_m['10_group_pricing_regular_price'] . '</span></span></div></div>';
                                    } else if ( $tier_3_m['10_group_pricing_regular_price'] ){
                                        echo '<div class="sale-pricing"><div class="left">Special Group Pricing (10+)</div><div class="right"><span class="regular-price bigprice">$' . $tier_3_m['10_group_pricing_regular_price'] . '</span></div></div>';
                                    } else {
                                        // do nothing
                                    } ?>

                                    <?php if ( $tier_3_m['special_group_pricing_sale_price'] && $tier_3_m['special_group_pricing_regular_price'] ){
                                        echo '<div class="sale-pricing"><div class="left">Special Group Pricing (4+)</div><div class="right"><span class="sale-price bigprice">$' . $tier_3_m['special_group_pricing_sale_price'] . '</span>';
                                        echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_3_m['special_group_pricing_regular_price'] . '</span></span></div></div>';
                                    } else if ( $tier_3_m['special_group_pricing_regular_price'] ){
                                        echo '<div class="sale-pricing"><div class="left">Special Group Pricing (4+)</div><div class="right"><span class="regular-price bigprice">$' . $tier_3_m['special_group_pricing_regular_price'] . '</span></div></div>';
                                    } else {
                                        // do nothing
                                    } ?>

                                    <?php if ( $tier_3_m['single_pass_price_sale_price'] && $tier_3_m['single_pass_price_regular_price'] ){
                                        echo '<div class="sale-pricing"><div class="left">Single Pass</div><div class="right"><span class="sale-price bigprice">$' . $tier_3_m['single_pass_price_sale_price'] . '</span>';
                                        echo '<span class="regular-price">Full Price <span class="strikeout">$' . $tier_3_m['single_pass_price_regular_price'] . '</span></span></div></div>';
                                    } else if ( $tier_3_m['single_pass_price_regular_price'] ){
                                        echo '<div class="sale-pricing"><div class="left">Single Pass</div><div class="right"><span class="regular-price bigprice">$' . $tier_3_m['single_pass_price_regular_price'] . '</span></div></div>';
                                    } else {
                                        // do nothing
                                    } ?>

                                </div>

                            <?php endif; ?>

                            </div>

                        </div>

                    </div>


                    <?php endif; ?>

                <!-- Event meta -->
                <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>

                <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>


            </div>

            <div id="thecart">

			    <?php the_content(); ?>

            </div>

		</div>

	</main><!-- #content -->

</div><!-- #page -->

<?php get_footer(); ?>

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
</script>
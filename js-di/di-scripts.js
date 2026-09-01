(function($){
	$(window).ready(function(){
		// Registration page
		if ($('.register-table').length) {
			const registerSettings = window.di_js_obj || {};

			/**
			 * WordPress-localized boolean values arrive as strings.
			 */
			function settingIsEnabled(value) {
				return String(value) === '1';
			}

			function getQuantityPrompt() {
				return $('#tribe-tickets__tickets-form .register-row-quantity-prompt');
			}

			function showInPersonPrompt() {
				const prompt = registerSettings.register_row_quantity_prompt_in_person || '';

				getQuantityPrompt().text(prompt);
			}

			function showBundlePrompt() {
				const title =
					  registerSettings.register_row_bundle_prompt_title || '';

				const subtext =
					  registerSettings.register_row_bundle_prompt_subtext || '';

				const $promptTitle = $('<div>', {
					class: 'register-row-quantity-prompt-title'
				}).text(title);

				if (
					settingIsEnabled(
						registerSettings.register_row_bundle_prompt_show_info
					)
				) {
					const $infoLink = $('<a>', {
						href: '#',
						class: 'add-more-logins-info',
						'aria-label': 'More information'
					}).css('margin-left', '8px');

					$('<i>', {
						class: 'fa fa-info-circle',
						'aria-hidden': 'true'
					}).appendTo($infoLink);

					$promptTitle.append($infoLink);
				}

				if (subtext) {
					$('<div>', {
						class: 'register-row-quantity-prompt-subtext'
					})
						.text(subtext)
						.appendTo($promptTitle);
				}

				getQuantityPrompt()
					.empty()
					.append($promptTitle);
			}

			/*
			 * Delegated handlers continue working if the tab markup is
			 * replaced or re-rendered after page load.
			 */
			$(document).on(
				'click',
				'#tab-in-person, .tab-in-person',
				function() {
					showInPersonPrompt();
				}
			);

			$(document).on(
				'click',
				'#tab-virtual, .tab-virtual',
				function() {
					showBundlePrompt();
				}
			);

			$(document).on('click', '.add-more-logins-info', function(e) {
				e.preventDefault();

				const popupContent = $('.add-more-logins-info-content').html();

				$('#register-detail').show();
				hide_if_clicked_off('register-detail');

				$('#registration-detail-title').text(
					registerSettings.register_row_bundle_prompt_title || ''
				);

				$('#registration-detail-content').html(popupContent);
			});

			/*
			 * A virtual-only event has no tab click to initialize the prompt,
			 * so output the virtual/bundle prompt immediately.
			 */
			if (settingIsEnabled(registerSettings.virtual_only)) {
				showBundlePrompt();
			}
		}
		
		if ($('#tribe-tickets__tickets-form').length) {
			const ticketSettings = window.di_js_obj || {};

			const quantityInputSelector =
				  '#tribe-tickets__tickets-form ' +
				  'input.tribe-tickets__tickets-item-quantity-number-input';

			const nativeQuantityButtonSelector =
				  '#tribe-tickets__tickets-form ' +
				  '.tribe-tickets__tickets-item-quantity button';

			const $footerQuantity = $(
				'.tribe-tickets__tickets-footer-quantity-number'
			);

			const ticketCartCount =
				  parseInt(ticketSettings.ticket_cart_count, 10) || 0;

			let ticketFooterSyncTimeout;

			/**
			 * Return the native Event Tickets quantity input for a ticket.
			 *
			 * Its step is rendered by PHP from the product's
			 * bundled_quantity ACF field.
			 */
			function getTicketQuantityInput(ticketId) {
				return $(
					'#tribe-tickets__tickets-item-quantity-number--' +
					ticketId
				).first();
			}

			/**
			 * Move each add-on after the product identified by parent_id.
			 */
			function positionBundledTicketRows() {
				const lastRowByParent = {};

				$(
					'#tribe-tickets__tickets-form ' +
					'.tribe-tickets__tickets-item[data-parent-id]'
				).each(function() {
					const $addon = $(this);
					const parentId = $addon.attr('data-parent-id');
					const $parent = $(
						'#tribe-block-tickets-item-' + parentId
					);

					if (!parentId || !$parent.length) {
						return;
					}

					const $anchor =
						  lastRowByParent[parentId] || $parent;

					$addon.insertAfter($anchor);

					lastRowByParent[parentId] = $addon;
				});
			}

			/**
			 * Return the raw number of attendee tickets currently selected.
			 *
			 * Grouping by ticket ID prevents duplicated responsive markup
			 * from counting the same ticket more than once.
			 */
			function getSelectedTicketQuantity() {
				const quantities = {};

				$(quantityInputSelector).each(function() {
					const $input = $(this);

					const ticketId =
						  $input
					.closest('.tribe-tickets__tickets-item')
					.attr('data-ticket-id') ||
						  $input.attr('id');

					if (!ticketId) {
						return;
					}

					const quantity =
						  parseInt($input.val(), 10) || 0;

					quantities[ticketId] = Math.max(
						quantities[ticketId] || 0,
						quantity
					);
				});

				return Object.keys(quantities).reduce(
					function(total, ticketId) {
						return total + quantities[ticketId];
					},
					0
				);
			}

			/**
			 * Display:
			 *
			 * existing cart quantity + current raw form quantities
			 */
			function syncTicketFooterQuantity() {
				const totalQuantity =
					  ticketCartCount + getSelectedTicketQuantity();

				const disabled = totalQuantity <= 0;

				$footerQuantity
					.attr('data-cart-count', ticketCartCount)
					.text(totalQuantity);

				$('#tribe-tickets__tickets-buy')
					.prop('disabled', disabled)
					.attr(
					'aria-disabled',
					disabled ? 'true' : 'false'
				);
			}

			/**
			 * Run after Event Tickets finishes its own footer update.
			 */
			function queueTicketFooterQuantitySync() {
				window.requestAnimationFrame(
					syncTicketFooterQuantity
				);

				window.clearTimeout(ticketFooterSyncTimeout);

				ticketFooterSyncTimeout = window.setTimeout(
					syncTicketFooterQuantity,
					150
				);
			}

			/**
			 * Synchronize a proxy quantity control with its native input.
			 */
			function syncVirtualPassQuantity(ticketId) {
				const $input = getTicketQuantityInput(ticketId);

				const $proxies = $(
					'.virtual-pass-quantity[data-ticket-id="' +
					ticketId +
					'"]'
				);

				if (!$input.length || !$proxies.length) {
					return;
				}

				const quantity =
					  parseInt($input.val(), 10) || 0;

				const step =
					  parseInt($input.attr('step'), 10) || 1;

				const minimum =
					  parseInt($input.attr('min'), 10) || 0;

				const maximum =
					  parseInt($input.attr('max'), 10);

				const displayedQuantity = quantity / step;

				const reachedMaximum =
					  !isNaN(maximum) &&
					  quantity + step > maximum;

				$proxies
					.find('.virtual-pass-quantity__value')
					.text(displayedQuantity);

				$proxies
					.find('.virtual-pass-quantity__remove')
					.prop('disabled', quantity <= minimum);

				$proxies
					.find('.virtual-pass-quantity__add')
					.prop('disabled', reachedMaximum);
			}

			/**
			 * Synchronize the visual package quantity inside a bundled row.
			 */
			function syncBundledPackageQuantity($input) {
				const $quantityWrapper =
					  $input.closest('.qty-bundled');

				if (!$quantityWrapper.length) {
					return;
				}

				const quantity =
					  parseInt($input.val(), 10) || 0;

				const step =
					  parseInt($input.attr('step'), 10) || 1;

				$quantityWrapper
					.find('.qty-bundled-input')
					.text(quantity / step);
			}

			/**
			 * Show or hide every add-on belonging to a parent ticket.
			 */
			function syncTicketAddons(parentId) {
				const $parentInput =
					  getTicketQuantityInput(parentId);

				const $addons = $(
					'#tribe-tickets__tickets-form ' +
					'.tribe-tickets__tickets-item' +
					'[data-parent-id="' + parentId + '"]'
				);

				if (!$parentInput.length || !$addons.length) {
					return;
				}

				const parentQuantity =
					  parseInt($parentInput.val(), 10) || 0;

				const $quantityRows =
					  $('.register-row-quantity');

				if (parentQuantity > 0) {
					$quantityRows
						.addClass('toggle-bundle')
						.addClass(
						'toggle-bundle-' + parentId
					);

					$addons
						.removeClass('hide')
						.addClass('show visible');

					return;
				}

				$quantityRows.removeClass(
					'toggle-bundle-' + parentId
				);

				$addons.each(function() {
					const $addon = $(this);

					const $addonInput = $addon
					.find(
						'input.' +
						'tribe-tickets__tickets-item-' +
						'quantity-number-input'
					)
					.first();

					const addonQuantity =
						  parseInt($addonInput.val(), 10) || 0;

					$addon
						.removeClass('show visible')
						.addClass('hide');

					$addon
						.find('.qty-bundled-input')
						.text('0');

					if (addonQuantity > 0) {
						$addonInput
							.val(0)
							.trigger('change');
					}
				});
			}

			/**
			 * Keep the generic bundle class accurate when multiple
			 * parent tickets can reveal add-ons.
			 */
			function syncBundleContainerClass() {
				let hasActiveAddon = false;

				const checkedParents = {};

				$(
					'#tribe-tickets__tickets-form ' +
					'.tribe-tickets__tickets-item[data-parent-id]'
				).each(function() {
					const parentId =
						  $(this).attr('data-parent-id');

					if (
						!parentId ||
						checkedParents[parentId]
					) {
						return;
					}

					checkedParents[parentId] = true;

					const parentQuantity =
						  parseInt(
							  getTicketQuantityInput(
								  parentId
							  ).val(),
							  10
						  ) || 0;

					if (parentQuantity > 0) {
						hasActiveAddon = true;

						return false;
					}
				});

				$('.register-row-quantity').toggleClass(
					'toggle-bundle',
					hasActiveAddon
				);
			}

			/**
			 * Delegate proxy clicks to the corresponding native
			 * Event Tickets quantity button.
			 */
			$(document)
				.off(
				'click.mirrenVirtualPassQuantity',
				'.virtual-pass-quantity__button'
			)
				.on(
				'click.mirrenVirtualPassQuantity',
				'.virtual-pass-quantity__button',
				function(e) {
					e.preventDefault();

					const $button = $(this);

					const ticketId = $button
					.closest(
						'.virtual-pass-quantity'
					)
					.attr('data-ticket-id');

					const $ticket = $(
						'#tribe-block-tickets-item-' +
						ticketId
					);

					const nativeButtonSelector =
						  $button.hasClass(
							  'virtual-pass-quantity__add'
						  )
					? '.tribe-tickets__tickets-item-quantity-add'
					: '.tribe-tickets__tickets-item-quantity-remove';

					const nativeButton = $ticket
					.find(nativeButtonSelector)
					.get(0);

					if (
						!nativeButton ||
						nativeButton.disabled
					) {
						return;
					}

					nativeButton.click();

					window.setTimeout(function() {
						syncVirtualPassQuantity(
							ticketId
						);

						syncTicketAddons(ticketId);
						syncBundleContainerClass();
						queueTicketFooterQuantitySync();
					}, 0);
				}
			);

			/**
			 * Synchronize custom output whenever a native input changes.
			 */
			$(document)
				.off(
				'input.mirrenTicketQuantities ' +
				'change.mirrenTicketQuantities',
				quantityInputSelector
			)
				.on(
				'input.mirrenTicketQuantities ' +
				'change.mirrenTicketQuantities',
				quantityInputSelector,
				function() {
					const $input = $(this);

					const ticketId = $input
					.closest(
						'.tribe-tickets__tickets-item'
					)
					.attr('data-ticket-id');

					if (ticketId) {
						syncVirtualPassQuantity(
							ticketId
						);

						syncTicketAddons(ticketId);
					}

					syncBundledPackageQuantity(
						$input
					);

					syncBundleContainerClass();
					queueTicketFooterQuantitySync();
				}
			);

			/**
			 * Some Event Tickets versions change the native input
			 * without emitting a change event.
			 */
			$(document)
				.off(
				'click.mirrenNativeTicketQuantity',
				nativeQuantityButtonSelector
			)
				.on(
				'click.mirrenNativeTicketQuantity',
				nativeQuantityButtonSelector,
				function() {
					const ticketId = $(this)
					.closest(
						'.tribe-tickets__tickets-item'
					)
					.attr('data-ticket-id');

					window.setTimeout(function() {
						const $input =
							  getTicketQuantityInput(
								  ticketId
							  );

						syncVirtualPassQuantity(
							ticketId
						);

						syncBundledPackageQuantity(
							$input
						);

						syncTicketAddons(ticketId);
						syncBundleContainerClass();
						queueTicketFooterQuantitySync();
					}, 100);
				}
			);

			/**
			 * Initialize row positioning and custom displays.
			 */
			positionBundledTicketRows();

			$(quantityInputSelector).each(function() {
				const $input = $(this);

				const ticketId = $input
				.closest(
					'.tribe-tickets__tickets-item'
				)
				.attr('data-ticket-id');

				if (ticketId) {
					syncVirtualPassQuantity(ticketId);
					syncTicketAddons(ticketId);
				}

				syncBundledPackageQuantity($input);
			});

			syncBundleContainerClass();
			syncTicketFooterQuantity();

			/*
			 * Event Tickets may initialize after this script and restore the disabled
			 * state. Resynchronize once its initial page-load processing has finished.
			 */
			queueTicketFooterQuantitySync();

			if (ticketCartCount > 0) {
				const enableNextButtonFromCart = function() {
					syncTicketFooterQuantity();
				};

				if (document.readyState === 'complete') {
					enableNextButtonFromCart();
				} else {
					$(window)
						.off('load.mirrenTicketCartCount')
						.one(
						'load.mirrenTicketCartCount',
						enableNextButtonFromCart
					);
				}

				window.setTimeout(enableNextButtonFromCart, 500);
			}
		}
		
		// Cart
		if ( $('body.woocommerce-cart').length ) {
			const cartQuantitySelector =
				'.woocommerce-cart-form .product-quantity .quantity';

			/**
			 * Return the customer-facing input for a cart quantity control.
			 * Bundled rows use a proxy input while standard rows use WooCommerce's
			 * native quantity input.
			 */
			function getCartQuantityDisplayInput($quantity) {
				const $bundledInput = $quantity
					.find('input.bundled.qty')
					.first();

				if ($bundledInput.length) {
					return $bundledInput;
				}

				return $quantity
					.find('input.qty')
					.not('.bundled-qty, .multi-qty')
					.first();
			}

			/**
			 * Keep the plus and minus disabled states aligned with the input limits.
			 */
			function syncCartQuantityButtonStates($input) {
				if (!$input.length) {
					return;
				}

				const $quantity = $input.closest('.quantity');
				const value = parseFloat($input.val()) || 0;
				const step = parseFloat($input.attr('step')) || 1;
				const minimum = parseFloat($input.attr('min'));
				const maximum = parseFloat($input.attr('max'));

				$quantity
					.find('.di-cart-quantity__minus')
					.prop(
						'disabled',
						!isNaN(minimum) && value - step < minimum
					);

				$quantity
					.find('.di-cart-quantity__plus')
					.prop(
						'disabled',
						!isNaN(maximum) && value + step > maximum
					);
			}

			/**
			 * Convert the raw bundled ticket quantity to the displayed bundle count
			 * and retain the existing per-bundle price display.
			 */
			function syncBundledCartRow($displayInput) {
				const $quantity = $displayInput.closest('.quantity');
				const $nativeInput = $quantity
					.find('input.bundled-qty')
					.first();

				if (!$nativeInput.length) {
					return;
				}

				const rawQuantity = parseFloat($nativeInput.val()) || 0;
				const divisor = parseFloat($nativeInput.attr('step')) || 1;
				const nativeMinimum = parseFloat($nativeInput.attr('min'));
				const nativeMaximum = parseFloat($nativeInput.attr('max'));

				$displayInput
					.attr('step', 1)
					.attr(
						'min',
						isNaN(nativeMinimum)
							? 0
							: Math.ceil(nativeMinimum / divisor)
					)
					.val(rawQuantity / divisor);

				if (isNaN(nativeMaximum) || nativeMaximum < 0) {
					$displayInput.removeAttr('max');
				} else {
					$displayInput.attr(
						'max',
						Math.floor(nativeMaximum / divisor)
					);
				}

			}

			/**
			 * Add accessible controls to each editable cart quantity.
			 */
			function initializeCartQuantityControls() {
				$(cartQuantitySelector).each(function() {
					const $quantity = $(this);
					const $input = getCartQuantityDisplayInput($quantity);

					if (!$input.length) {
						return;
					}

					if (!$quantity.find('.di-cart-quantity__minus').length) {
						$('<button>', {
							type: 'button',
							class:
								'di-cart-quantity__button ' +
								'di-cart-quantity__minus',
							'aria-label': 'Decrease quantity',
							text: '\u2212'
						}).insertBefore($input);
					}

					if (!$quantity.find('.di-cart-quantity__plus').length) {
						$('<button>', {
							type: 'button',
							class:
								'di-cart-quantity__button ' +
								'di-cart-quantity__plus',
							'aria-label': 'Increase quantity',
							text: '+'
						}).insertAfter($input);
					}

					syncCartQuantityButtonStates($input);
				});
			}

			function initializeBundledCartRows() {
				$('.woocommerce-cart-form input.bundled.qty').each(
					function() {
						syncBundledCartRow($(this));
					}
				);
			}

			$(document)
				.off(
					'click.mirrenCartQuantity',
					'.di-cart-quantity__button'
				)
				.on(
					'click.mirrenCartQuantity',
					'.di-cart-quantity__button',
					function() {
						const $button = $(this);
						const $input = getCartQuantityDisplayInput(
							$button.closest('.quantity')
						);

						if (!$input.length || $button.prop('disabled')) {
							return;
						}

						const currentValue = parseFloat($input.val()) || 0;
						const step = parseFloat($input.attr('step')) || 1;
						const minimum = parseFloat($input.attr('min'));
						const maximum = parseFloat($input.attr('max'));

						let nextValue = $button.hasClass(
							'di-cart-quantity__plus'
						)
							? currentValue + step
							: currentValue - step;

						if (!isNaN(minimum)) {
							nextValue = Math.max(minimum, nextValue);
						}

						if (!isNaN(maximum)) {
							nextValue = Math.min(maximum, nextValue);
						}

						$input.val(nextValue).trigger('change');
						syncCartQuantityButtonStates($input);
					}
				);

			$(document)
				.off(
					'change.mirrenBundledCartQuantity',
					'.woocommerce-cart-form input.bundled.qty'
				)
				.on(
					'change.mirrenBundledCartQuantity',
					'.woocommerce-cart-form input.bundled.qty',
					function() {
						const $displayInput = $(this);
						const $nativeInput = $displayInput
							.closest('.quantity')
							.find('input.bundled-qty')
							.first();

						const displayedQuantity =
							parseFloat($displayInput.val()) || 0;

						const divisor =
							parseFloat($nativeInput.attr('step')) || 1;

						$nativeInput
							.val(displayedQuantity * divisor)
							.trigger('change');

						syncCartQuantityButtonStates($displayInput);
					}
				);

			$(document)
				.off(
					'input.mirrenCartQuantityState ' +
					'change.mirrenCartQuantityState',
					'.woocommerce-cart-form .product-quantity input.qty'
				)
				.on(
					'input.mirrenCartQuantityState ' +
					'change.mirrenCartQuantityState',
					'.woocommerce-cart-form .product-quantity input.qty',
					function() {
						const $input = getCartQuantityDisplayInput(
							$(this).closest('.quantity')
						);

						syncCartQuantityButtonStates($input);
					}
				);

			$(document)
				.off(
					'click.mirrenCartUpdate',
					'.button[name="update_cart"]:not([disabled])'
				)
				.on(
					'click.mirrenCartUpdate',
					'.button[name="update_cart"]:not([disabled])',
					function() {
						$('.woocommerce-cart-form input.bundled.qty')
							.closest('.cart_item')
							.find('.product-price, .product-subtotal')
							.css('opacity', '0');
					}
				);

			$(document)
				.off('updated_cart_totals.mirrenCart')
				.on('updated_cart_totals.mirrenCart', function() {
					initializeBundledCartRows();
					initializeCartQuantityControls();
				});

			initializeBundledCartRows();
			initializeCartQuantityControls();
		}

		// Add your attendees pre-checkout page
		if ( $('body.page-tribe-attendee-registration').length ) {
			//$('input[type=radio][name=attendees_known]').change(function() {
			$('.attendees-toggle input').on('change',function() {
				if (this.value == 'yes') {
					$('.tribe-tickets__attendee-tickets-form, .tribe-tickets__iac-email-disclaimer').show();
				}
				else if (this.value == 'no') {
					$('.tribe-tickets__attendee-tickets-form, .tribe-tickets__iac-email-disclaimer').hide();
					$('.tribe-tickets__attendee-tickets-item').each(function(){
						$(this).find('input[id*="name"], input[id*="email"]').each(function(){
							$(this).prop('required', false);
							$(this).val('');
						});
					});
					$('#tribe-tickets__notice__attendee-registration').hide();
				}
			});
			$('.parent-company input').on('input',function(){
				let val = $(this).val();
				$('.tribe-tickets__form-field-input-wrapper:not(.parent-company) input[id*="company"]').each(function(){
					$(this).val(val);
				})
			});
			$(document).ajaxComplete(function(){
				let company_check = $('.tribe-tickets__form-field-input-wrapper:not(.parent-company) input[id*="company"]').eq(0).val();
				if ( company_check ) {
					$('.parent-company input').val(company_check);
				}
				$('input[id*="last-name"]').each(function(){
					let lnameWrap = $(this).closest('.tribe-tickets__form-field');
					let fname = $(this).closest('.tribe-tickets__form').find('input[id*="iac-name"]').closest('.tribe-tickets__form-field');
					$(lnameWrap).insertAfter(fname);
				});
				$('.tribe-tickets__form-field-input-wrapper:not(.parent-company) input[id*="company"]').each(function(){
					$(this).attr('readonly', true);
				});
				$('.tribe-tickets__attendee-tickets-item').each(function(){
					let hasInput = false;
					$(this).find('input[id*="name"], input[id*="email"]').each(function(){
						if ($(this).val()) {
							hasInput = true;
						}
					});
					if (hasInput) {
						$(this).find('input[id*="name"], input[id*="email"]').each(function(){
							$(this).prop('required', true);
						});
					} else {
						$(this).find('input[id*="name"], input[id*="email"]').each(function(){
							$(this).prop('required', false);
						});
					}
				});
				$('.tribe-tickets__form-field-input-wrapper input').on('input change paste',function(){
					let val = $(this).val();
					val = val.replace(',', '');
					$(this).val(val);
					// Make fields required if they start to fill out an attendee
					let attendeeWrap = $(this).closest('.tribe-tickets__attendee-tickets-item');
					let hasInput = false;
					$(attendeeWrap).find('input[id*="name"], input[id*="email"]').each(function(){
						if ($(this).val()) {
							hasInput = true;
						}
					});
					if (hasInput) {
						$(attendeeWrap).find('input[id*="name"], input[id*="email"]').each(function(){
							$(this).prop('required', true);
						});
					} else {
						$(attendeeWrap).find('input[id*="name"], input[id*="email"]').each(function(){
							$(this).prop('required', false);
						});
					}
				});
			});
		}
		
		// Checkout
		if ( $('body.woocommerce-checkout').length ) {
			/*$('body').on('updated_checkout',function(){
				$('#order_review .cart_item').each(function(){
					let name = $(this).find('.product-name').text(),
						qty;
					if ( name.toLowerCase().indexOf('bundle') >= 0 ) {
						qty = $(this).find('.product-quantity').text();
						qty = parseFloat( qty.substring(2,qty.length) );
						if (qty >= 3) {
							qty = qty / 3;
							$(this).find('.product-quantity').text('× ' + qty);
							console.log(qty);
						}
					}
				})
			});*/
			$('#billing_postcode_field label').html('Zip/Postal Code <abbr class="required" title="required">*</abbr>');
			$('#billing_country').on('change',function(){
				setTimeout(function(){
					$('#billing_postcode_field label').html('Zip/Postal Code <abbr class="required" title="required">*</abbr>');
				}, 10);
			});
			$( document ).on( 'update_checkout', function(){
				$('#billing_postcode_field label').html('Zip/Postal Code <abbr class="required" title="required">*</abbr>');
			});
			$( document ).on( 'updated_checkout', function(){
				$('#billing_postcode_field label').html('Zip/Postal Code <abbr class="required" title="required">*</abbr>');
			});
			$('#company_zip').on('input',function(){
				let val = $(this).val();
				$('#billing_postcode').val(val);
			});
			$('#createaccount').on('change',function(){
				let ischecked = $(this).prop('checked');
				if ( ischecked ) {
					//console.log('yes');
					$('.create-account-notice').removeClass('woocommerce-error').addClass('woocommerce-info');
				} else {
					//console.log('no');
					$('.create-account-notice').removeClass('woocommerce-info').addClass('woocommerce-error');
				}
			})
		}
		
		// Edit attendees page
		if ( $('.tribe-tickets-list').length ) {
			
			const params = new URLSearchParams(window.location.search);
			if (params.get('tribe_updated') === '1') {
				$('<div style="font-style: italic; font-weight: 700; margin-top: 30px;">Your passes have been updated.</div>').insertBefore($('.event-tickets.tribe-tickets__tickets-page-wrapper'));
			}
			
			$('.add-more-bundles .heading-toggle').on('click',function(){
				let wrap = $(this).closest('.add-more-bundles');
				wrap.toggleClass('toggle-active');
				wrap.find('.form-toggle').slideToggle(400);
			});
			
			$('.tribe-submit-tickets-form.edit-attendees').clone().prependTo('form.tribe-tickets__form:not(#tribe-tickets__tickets-form)');
			
			$('.attendee-meta.toggle').on('click',function(){
				if ( $(this).hasClass('on') ) {
					$(this).closest('.tribe-event-tickets-plus-meta').find('.tribe-tickets__form-field:not(.tribe-tickets-meta-radio) input').each(function(){
						$(this).prop('required', false);
					});
				} else {
					$(this).closest('.tribe-event-tickets-plus-meta').find('.tribe-tickets__form-field:not(.tribe-tickets-meta-radio) input').each(function(){
						$(this).prop('required', true);
					})
				}
			});
			
			$('.tribe-tickets__form-field:has(input[id*="iac-name"]) label').each(function(){
				$(this).text('First Name');
			});
			$('.tribe-tickets__form-field:has(input[id*="last-name"])').each(function(){
				$(this).insertAfter($(this).closest('.attendee-meta-row').find('.tribe-tickets__form-field:has(input[id*="iac-name"])'));
			});
			
			let company_check = $('.tribe-tickets__form-field input[id*="company"]').eq(0).val();
			if ( company_check ) {
				$('.parent-company input').val(company_check);
			}
			
			$('.tribe-event-tickets-plus-meta .tribe-tickets__form-field input[id*="company"]').each(function(){
				$(this).attr('readonly', true);
			})
			$('.attendee-meta.toggle').on('click',function(){
				$('.edit-attendees-company').show();
			})
			
			$('.parent-company input').on('input',function(){
				let val = $(this).val();
				$('.tribe-event-tickets-plus-meta .tribe-tickets__form-field input[id*="company"]').each(function(){
					$(this).val(val);
				})
			});
			$('.tribe-tickets__form-field input').on('input change paste',function(){
				let val = $(this).val();
				val = val.replace(',', '');
				$(this).val(val);
			});
		}
	})
})(jQuery);

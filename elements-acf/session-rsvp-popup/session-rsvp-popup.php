<?php
$image_id = get_field( 'session_rsvp_image' );
$header   = get_field( 'session_rsvp_header' );
$form_id  = get_field( 'session_rsvp_form_id' );

$image = '';
if ( $image_id && is_numeric( $image_id ) ) {
	$image = wp_get_attachment_image( (int) $image_id, 'full' );
}
?>

<div class="session-rsvp-form-modal" aria-hidden="true">
	<div class="session-rsvp-form-overlay"></div>

	<div class="session-rsvp-form-wrap" role="dialog" aria-modal="true" aria-label="Session RSVP form">
		<button type="button" class="session-rsvp-form-close" aria-label="Close RSVP form">
			<span aria-hidden="true">&times;</span>
		</button>

		<?php if ( $image ) : ?>
			<div class="session-rsvp-form-image">
				<?php echo $image; ?>
			</div>
		<?php endif; ?>

		<?php if ( $header ) : ?>
			<h3 class="session-rsvp-form-header"><?php echo esc_html( $header ); ?></h3>
		<?php endif; ?>

		<div class="session-rsvp-form-session-title"></div>
		<div class="session-rsvp-form-datetime"></div>
		<div class="session-rsvp-form-speaker"></div>

		<?php if ( $form_id ) : ?>
			<div class="session-rsvp-form-gravity">
				<?php
				echo do_shortcode(
					sprintf(
						'[gravityform id="%d" title="false" description="false" ajax="true"]',
						(int) $form_id
					)
				);
				?>
			</div>
		<?php else : ?>
			<p>Please enter a form ID to display.</p>
		<?php endif; ?>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const modal = document.querySelector('.session-rsvp-form-modal');
	if (!modal) return;

	const overlay = modal.querySelector('.session-rsvp-form-overlay');
	const wrap = modal.querySelector('.session-rsvp-form-wrap');
	const closeButton = modal.querySelector('.session-rsvp-form-close');
	const formContainer = modal.querySelector('.session-rsvp-form-gravity');
	const titleEl = modal.querySelector('.session-rsvp-form-session-title');
	const datetimeEl = modal.querySelector('.session-rsvp-form-datetime');
	const speakerEl = modal.querySelector('.session-rsvp-form-speaker');

	if (!formContainer) return;

	const originalFormHtml = formContainer.innerHTML;
	let lastTrigger = null;

	function setModalOpenState(isOpen) {
		modal.classList.toggle('is-open', isOpen);
		modal.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
		document.body.classList.toggle('session-rsvp-modal-open', isOpen);
	}

	function clearSummary() {
		if (titleEl) titleEl.textContent = '';
		if (datetimeEl) datetimeEl.textContent = '';
		if (speakerEl) speakerEl.textContent = '';
	}
	
	function rerunInlineScripts(container) {
		const scripts = container.querySelectorAll('script');

		scripts.forEach(function (oldScript) {
			const newScript = document.createElement('script');

			Array.from(oldScript.attributes).forEach(function (attr) {
				newScript.setAttribute(attr.name, attr.value);
			});

			newScript.text = oldScript.text || oldScript.textContent || '';

			oldScript.parentNode.replaceChild(newScript, oldScript);
		});
	}

	function resetModal() {
		formContainer.innerHTML = originalFormHtml;
		clearSummary();
		rerunInlineScripts(formContainer);
	}

	function openModal(trigger) {
		lastTrigger = trigger || null;
		resetModal();
		setModalOpenState(true);

		requestAnimationFrame(function () {
			if (!trigger) return;
			populateSummary(trigger);
			populateHiddenFields(trigger);
			configureAttendanceField(trigger);
		});
	}

	function closeModal() {
		setModalOpenState(false);
		resetModal();

		if (lastTrigger && typeof lastTrigger.focus === 'function') {
			lastTrigger.focus();
		}
	}

	function setFieldValue(selector, value) {
		const input = modal.querySelector(selector);
		if (!input) return;

		if (
			value === undefined ||
			value === null ||
			(typeof value === 'string' && value.trim() === '')
		) {
			return;
		}

		input.value = value;
		input.dispatchEvent(new Event('input', { bubbles: true }));
		input.dispatchEvent(new Event('change', { bubbles: true }));
	}

	function populateHiddenFields(button) {
		setFieldValue('.gf-session-id input', button.dataset.sessionId);
		setFieldValue('.gf-session-title input', button.dataset.sessionTitle);
		setFieldValue('.gf-session-speakers input', button.dataset.sessionSpeakers);
		setFieldValue('.gf-session-date input', button.dataset.sessionDate);
		setFieldValue('.gf-session-time input', button.dataset.sessionTime);
		setFieldValue('.gf-session-timestamp input', button.dataset.sessionTimestamp);
		setFieldValue('.gf-google-sheet-tab input', button.dataset.googleSheetTab);
		setFieldValue('.gf-calendar-search-term input', button.dataset.calendarSearchTerm);
	}

	function populateSummary(button) {
		const title = button.dataset.sessionTitle || '';
		const date = button.dataset.sessionDate || '';
		const time = button.dataset.sessionTime || '';
		const speakers = button.dataset.sessionSpeakers || '';

		if (titleEl) {
			titleEl.textContent = title;
		}

		if (datetimeEl) {
			datetimeEl.textContent = [date, time].filter(Boolean).join(' | ');
		}

		if (speakerEl) {
			speakerEl.textContent = speakers ? 'Speaker: ' + speakers : '';
		}
	}

	function configureAttendanceField(button) {
		const allowedRaw = button.dataset.attendanceType || '';
		const allowed = allowedRaw
			.split(',')
			.map(function (value) {
				return value.trim().toLowerCase();
			})
			.filter(Boolean);

		const field = modal.querySelector('.gf-attendance-type');
		if (!field) return;

		const legend = field.querySelector('legend');
		const choices = field.querySelectorAll('input[type="radio"]');

		let allowedCount = 0;
		let firstAllowedInput = null;

		choices.forEach(function (input) {
			const value = String(input.value || '').trim().toLowerCase();
			const choice = input.closest('.gchoice') || input.parentElement;
			const isAllowed = allowed.length
				? allowed.includes(value)
				: ['in-person', 'virtual'].includes(value);

			input.checked = false;
			input.disabled = !isAllowed;

			if (choice) {
				choice.style.display = isAllowed ? '' : 'none';
			}

			if (isAllowed) {
				allowedCount++;
				if (!firstAllowedInput) {
					firstAllowedInput = input;
				}
			}
		});

		if (legend) {
			if (allowedCount === 1 && firstAllowedInput) {
				legend.innerHTML =
					(firstAllowedInput.value === 'in-person'
						? 'Confirmed Attending In-Person'
						: 'Confirmed Attending Virtually') +
					'<span class="gfield_required"><span class="gfield_required gfield_required_text">(Required)</span></span>';
			} else {
				legend.innerHTML =
					'Attendance Type<span class="gfield_required"><span class="gfield_required gfield_required_text">(Required)</span></span>';
			}
		}

		if (allowedCount === 1 && firstAllowedInput) {
			firstAllowedInput.checked = true;
			firstAllowedInput.dispatchEvent(new Event('change', { bubbles: true }));
		}
	}

	document.addEventListener('click', function (e) {
		const trigger = e.target.closest('.session-rsvp-button');
		if (!trigger) return;

		e.preventDefault();
		openModal(trigger);
	});

	if (overlay) {
		overlay.addEventListener('click', closeModal);
	}

	if (closeButton) {
		closeButton.addEventListener('click', closeModal);
	}

	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && modal.classList.contains('is-open')) {
			closeModal();
		}
	});

	if (wrap) {
		wrap.addEventListener('click', function (e) {
			e.stopPropagation();
		});
	}
});
</script>
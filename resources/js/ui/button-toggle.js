import $ from 'jquery';

/**
 * Syncs data-state on all button-toggle-item labels inside a toggle so the
 * selected and disabled states match the underlying radio inputs.
 *
 * @param {jQuery} $toggle - The .button-toggle container
 */
function syncButtonToggleState($toggle) {
  $toggle.find('.button-toggle-item').each(function () {
    const $item = $(this);
    const $input = $item.find('.button-toggle-item__input')[0];

    if (!$input) {
      return;
    }

    if ($input.disabled) {
      $item.attr('data-state', 'disabled');
    } else if ($input.checked) {
      $item.attr('data-state', 'selected');
    } else {
      $item.removeAttr('data-state');
    }
  });
}

function initButtonToggle() {
  $('.button-toggle').each(function () {
    syncButtonToggleState($(this));
  });

  $(document).on('change', '.button-toggle input[type="radio"]', function () {
    syncButtonToggleState($(this).closest('.button-toggle'));
  });
}

export default initButtonToggle;

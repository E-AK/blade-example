export default function initSelect() {
  $(document).on('click', '.select-body', function (e) {
    e.stopPropagation();

    if ($(this).hasClass('disabled')) {
      return;
    }

    const $wrapper = $(this).closest('.select-wrapper');
    const $input = $wrapper.find('.select-input');

    if ($(e.target).closest('.select-input').length && $wrapper.hasClass('open')) {
      return;
    }

    if ($wrapper.hasClass('open')) {
      $wrapper.removeClass('open state-selected');
      $input.prop('readonly', true);
    } else {
      $('.select-wrapper').not($wrapper).removeClass('open state-selected');
      $('.select-wrapper .select-input').not($input).prop('readonly', true);
      if ($input.length) {
        $input.prop('readonly', false);
        $input.trigger('focus');
      } else {
        $wrapper.addClass('open state-selected');
      }
    }
  });

  $(document).on('focus', '.select-input', function () {
    const $wrapper = $(this).closest('.select-wrapper');
    if ($wrapper.find('.select-body').hasClass('disabled')) {
      return;
    }
    $('.select-wrapper').not($wrapper).removeClass('open state-selected');
    $('.select-wrapper .select-input').not($(this)).prop('readonly', true);
    $(this).prop('readonly', false);
    $wrapper.addClass('open state-selected');
    $(this).trigger('input');
  });

  $(document).on('click', function () {
    $('.select-wrapper').removeClass('open state-selected');
    $('.select-input').prop('readonly', true);
  });

  $(document).on('input', '.select-input', function () {
    const $wrapper = $(this).closest('.select-wrapper');
    const query = $(this).val().toLowerCase();
    $wrapper.find('.select-item').each(function () {
      const text = $(this).text().toLowerCase();
      $(this).toggleClass('select-item--hidden', query !== '' && !text.includes(query));
    });
  });

  $(document).on('click', '.select-item', function (e) {
    e.stopPropagation();

    const $item = $(this);
    const $wrapper = $item.closest('.select-wrapper');
    const text = $item.text().trim();
    const value = $item.data('value');

    const $input = $wrapper.find('.select-input');
    const $displayText = $wrapper.find('.select-text');
    const $hiddenInput = $wrapper.find('input[name][type="hidden"].select-value');

    if ($input.length) {
      $input.val(text).prop('readonly', true);
    }
    if ($displayText.length) {
      $displayText.text(text);
    }
    if ($hiddenInput.length) {
      $hiddenInput.val(value !== undefined ? value : text);
    }

    const $body = $wrapper.find('.select-body');
    $body.removeClass('select-empty input-empty').addClass('state-filled');

    $wrapper.removeClass('open state-selected');
    $wrapper[0].dispatchEvent(new CustomEvent('select-change', { detail: { value, text }, bubbles: true }));
  });
}

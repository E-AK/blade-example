export default function initSelect() {
  $(document).on('click', '.select', function (e) {
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
    if ($wrapper.find('.select').hasClass('disabled')) {
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
    const $select = $wrapper.find('.select');
    const text = $item.text();
    const value = $item.data('value');

    $wrapper.find('.select-input').val(text);
    $select.find('.select-text').text(text);
    $wrapper.find('.select-input').prop('readonly', true);
    $wrapper.removeClass('open state-selected');
  });
}

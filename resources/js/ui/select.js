export default function initSelect() {
  $(document).on('click', '.select', function (e) {
    e.stopPropagation();

    if ($(this).hasClass('state-disabled')) {
      return;
    }

    const $wrapper = $(this).closest('.select-wrapper');
    const $dropdown = $wrapper.find('.select-dropdown');

    $('.select-wrapper .select-dropdown').not($dropdown).hide();
    $('.select-wrapper .select').not(this).removeClass('state-selected');

    $dropdown.toggle();
    $(this).toggleClass('state-selected');
  });

  $(document).on('click', function () {
    $('.select-dropdown').hide();
    $('.select').removeClass('state-selected');
  });

  $(document).on('click', '.select-item', function (e) {
    e.stopPropagation();

    const $item = $(this);
    const $wrapper = $item.closest('.select-wrapper');
    const $select = $wrapper.find('.select');

    $select.find('.select-text').text($item.text());
    $wrapper.find('.select-dropdown').hide();
    $select.removeClass('state-selected');
  });
}

export default function initSearch() {
  $(document).on('input', '.search-input', function () {
    const $box = $(this).closest('.search-box');
    const $clear = $box.find('.search-clear');

    $clear.toggleClass('d-none', $(this).val().length === 0);
  });

  $(document).on('click', '.search-clear', function () {
    const $box = $(this).closest('.search-box');
    const $input = $box.find('.search-input');

    $input.val('').trigger('input').focus();
  });
}

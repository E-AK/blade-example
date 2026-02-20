export default function initSearch() {
  $(document).on('input', '.search-input', function () {
    const $body = $(this).closest('.search-body');
    const $clear = $body.find('.search-clear');

    $clear.toggleClass('d-none', $(this).val().length === 0);
  });

  $(document).on('click', '.search-clear', function () {
    const $body = $(this).closest('.search-body');
    const $input = $body.find('.search-input');

    $input.val('').trigger('input').focus();
  });
}

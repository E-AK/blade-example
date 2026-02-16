export default function initSidebar() {
  const $layout = $('.app-layout');
  const $toggleBtn = $('.sidebar-toggle-btn');

  $toggleBtn.on('click', function () {
    $layout.toggleClass('is-collapsed');
  });

  $('.sidebar-item.has-submenu').each(function () {
    const $item = $(this);
    const $dropdown = $item.find('.sidebar-submenu-dropdown');

    $item.on('mouseenter', function () {
      $dropdown.css('display', 'flex');

      const rect = $dropdown[0].getBoundingClientRect();
      const overflowBottom = rect.bottom > window.innerHeight;

      $dropdown.toggleClass('open-up', overflowBottom);
    });

    $item.on('mouseleave', function () {
      $dropdown.css('display', '');
      $dropdown.removeClass('open-up');
    });
  });
}

/**
 * Глобальная делегация кликов: элементы с [data-dispatch] вызывают CustomEvent.
 * Позволяет не использовать inline onclick в Blade.
 */
export function initDataDispatch() {
  document.addEventListener('click', (e) => {
    const el = e.target.closest('[data-dispatch]');
    if (el && el.dataset.dispatch) {
      if (el.tagName === 'A') {
        e.preventDefault();
      }
      window.dispatchEvent(new CustomEvent(el.dataset.dispatch));
    }
  });
}

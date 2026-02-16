import $ from 'jquery';
import * as bootstrap from 'bootstrap';

const STATE_ICON_SVG = {
  success:
    '<svg width="20" height="20" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.33333 16.6667C12.9357 16.6667 16.6667 12.9357 16.6667 8.33333C16.6667 6.95164 16.3304 5.64849 15.7353 4.50125C15.6106 4.26096 15.29 4.22186 15.0986 4.41328L8.67851 10.8333C8.02764 11.4842 6.97236 11.4842 6.32149 10.8333L3.99408 8.50592C3.66864 8.18049 3.66864 7.65285 3.99408 7.32741C4.31951 7.00197 4.84715 7.00197 5.17259 7.32741L7.5 9.65482L14.1845 2.97506C14.3425 2.81712 14.3486 2.56179 14.1897 2.40476C12.6846 0.917902 10.6161 0 8.33333 0C3.73096 0 0 3.73096 0 8.33333C0 12.9357 3.73096 16.6667 8.33333 16.6667Z" fill="currentColor"/></svg>',
  error:
    '<svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM8 9.6C8.44183 9.6 8.8 9.24183 8.8 8.8V4.80001C8.8 4.35818 8.44183 4.00001 8 4.00001C7.55817 4.00001 7.2 4.35818 7.2 4.80001V8.8C7.2 9.24183 7.55817 9.6 8 9.6ZM8 12.8C8.44183 12.8 8.8 12.4418 8.8 12C8.8 11.5582 8.44183 11.2 8 11.2C7.55817 11.2 7.2 11.5582 7.2 12C7.2 12.4418 7.55817 12.8 8 12.8Z" fill="currentColor"/></svg>',
  attention:
    '<svg width="20" height="20" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.8743 1.26634C6.81289 -0.422111 9.18708 -0.422112 10.1257 1.26633L15.6754 11.2499C16.605 12.922 15.4271 15 13.5498 15H2.45024C0.572923 15 -0.604955 12.922 0.324554 11.2499L5.8743 1.26634ZM7.99995 9.14746C8.45037 9.14746 8.8155 8.77314 8.8155 8.31139V4.13102C8.8155 3.66927 8.45037 3.29494 7.99995 3.29494C7.54954 3.29494 7.18441 3.66927 7.18441 4.13102V8.31139C7.18441 8.77314 7.54954 9.14746 7.99995 9.14746ZM7.99995 12.4918C8.45037 12.4918 8.8155 12.1174 8.8155 11.6557C8.8155 11.1939 8.45037 10.8196 7.99995 10.8196C7.54954 10.8196 7.18441 11.1939 7.18441 11.6557C7.18441 12.1174 7.54954 12.4918 7.99995 12.4918Z" fill="currentColor"/></svg>',
  info: '<svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM8 7.2C8.44183 7.2 8.8 7.55817 8.8 8V12.0007C8.8 12.4425 8.44183 12.8007 8 12.8007C7.55817 12.8007 7.2 12.4425 7.2 12.0007V8C7.2 7.55817 7.55817 7.2 8 7.2ZM8 5.6C8.44183 5.6 8.8 5.24183 8.8 4.8C8.8 4.35817 8.44183 4 8 4C7.55817 4 7.2 4.35817 7.2 4.8C7.2 5.24183 7.55817 5.6 8 5.6Z" fill="currentColor"/></svg>',
};

const CLOSE_ICON_SVG =
  '<svg width="20" height="20" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.13338 0.8L0.800049 9.13333M0.800049 0.8L9.13338 9.13333" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';

const CONTAINER_ID = 'toast-container-custom';
const DEFAULT_DELAY = 50000;

function ensureContainer() {
  let $container = $(`#${CONTAINER_ID}`);
  if ($container.length === 0) {
    $container = $('<div>', { id: CONTAINER_ID, class: 'toast-container-custom' });
    $('body').append($container);
  }
  return $container;
}

function createToast(message, options = {}) {
  const state = options.state || 'info';
  const title = options.title || null;
  const delay = options.delay !== undefined ? options.delay : DEFAULT_DELAY;

  const iconSvg = STATE_ICON_SVG[state] || STATE_ICON_SVG.info;
  const titleHtml = title ? `<span class="toast-custom__title">${escapeHtml(title)}</span>` : '';
  const textHtml = `<span class="toast-custom__text">${escapeHtml(message)}</span>`;

  const html = `
    <div class="toast toast-custom toast-custom--${state}" role="alert" data-bs-autohide="true" data-bs-delay="${delay}">
      <div class="toast-custom__inner">
        <span class="toast-custom__icon" aria-hidden="true">
          ${iconSvg}
        </span>
        <div class="toast-custom__content">
          ${titleHtml}
          ${textHtml}
        </div>
        <button type="button" class="toast-custom__close btn-close-custom" aria-label="Close" data-bs-dismiss="toast">
          ${CLOSE_ICON_SVG}
        </button>
      </div>
    </div>
  `;

  return html;
}

function escapeHtml(text) {
  const div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

function show(message, options = {}) {
  const $container = ensureContainer();
  const html = createToast(message, options);
  const $toast = $(html);
  $container.append($toast);

  const toastEl = $toast[0];
  const bsToast = new bootstrap.Toast(toastEl, {
    delay: options.delay !== undefined ? options.delay : DEFAULT_DELAY,
  });

  $(toastEl).on('hidden.bs.toast', function () {
    $(this).remove();
  });

  bsToast.show();
  return toastEl;
}

const Toast = {
  show,
  success: (message, options = {}) => show(message, { ...options, state: 'success' }),
  error: (message, options = {}) => show(message, { ...options, state: 'error' }),
  attention: (message, options = {}) => show(message, { ...options, state: 'attention' }),
  info: (message, options = {}) => show(message, { ...options, state: 'info' }),
};

export default function initToast() {
  window.Toast = Toast;

  $(document).on('click', '.toast-demo', function () {
    const $btn = $(this);
    const state = $btn.data('state') || 'info';
    const message = $btn.data('message') || '';
    const title = $btn.data('title') || null;
    Toast.show(message, { state, title });
  });
}

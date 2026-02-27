/**
 * Custom scrollbar overlay: hides native scrollbar and shows track/thumb.
 * Reacts correctly to display:none and content changes (ResizeObserver).
 * Wraps content in an inner scrollable div so the track stays fixed on the right.
 */

const TRACK_SIZE = 4;
const MIN_THUMB = 24;

function createVertical(scrollEl, trackContainer) {
  const track = document.createElement('div');
  track.className = 'custom-scrollbar-v';
  const thumb = document.createElement('div');
  thumb.className = 'custom-scrollbar-v__thumb';
  track.appendChild(thumb);

  function update() {
    const { scrollHeight, clientHeight, scrollTop } = scrollEl;
    const maxScroll = scrollHeight - clientHeight;
    if (maxScroll <= 0) {
      track.classList.add('is-hidden');
      return;
    }
    track.classList.remove('is-hidden');
    const trackHeight = clientHeight;
    const thumbHeight = Math.max(MIN_THUMB, (clientHeight / scrollHeight) * trackHeight);
    const thumbMaxTop = trackHeight - thumbHeight;
    const thumbTop = maxScroll > 0 ? (scrollTop / maxScroll) * thumbMaxTop : 0;
    thumb.style.height = `${thumbHeight}px`;
    thumb.style.transform = `translateY(${thumbTop}px)`;
  }

  thumb.addEventListener('mousedown', (e) => {
    e.preventDefault();
    const dragStartY = e.clientY;
    const dragStartScrollTop = scrollEl.scrollTop;
    thumb.classList.add('is-dragging');
    const { scrollHeight, clientHeight } = scrollEl;
    const maxScroll = scrollHeight - clientHeight;
    const trackHeight = scrollEl.clientHeight;
    const thumbHeight = thumb.offsetHeight;
    const thumbMaxTop = trackHeight - thumbHeight;
    const rate = maxScroll / (thumbMaxTop || 1);

    function onMove(e) {
      const dy = e.clientY - dragStartY;
      scrollEl.scrollTop = Math.max(0, Math.min(maxScroll, dragStartScrollTop + dy * rate));
    }
    function onUp() {
      thumb.classList.remove('is-dragging');
      document.removeEventListener('mousemove', onMove);
      document.removeEventListener('mouseup', onUp);
    }
    document.addEventListener('mousemove', onMove);
    document.addEventListener('mouseup', onUp);
  });

  track.addEventListener('click', (e) => {
    if (e.target === thumb) return;
    const rect = track.getBoundingClientRect();
    const y = e.clientY - rect.top;
    const { scrollHeight, clientHeight } = scrollEl;
    const maxScroll = scrollHeight - clientHeight;
    const thumbHeight = thumb.offsetHeight;
    const trackHeight = rect.height;
    const thumbMaxTop = trackHeight - thumbHeight;
    const ratio = thumbMaxTop > 0 ? (y - thumbHeight / 2) / thumbMaxTop : 0;
    scrollEl.scrollTop = Math.max(0, Math.min(maxScroll, ratio * maxScroll));
  });

  scrollEl.addEventListener('scroll', update);
  const ro = new ResizeObserver(update);
  ro.observe(scrollEl);
  update();
  trackContainer.appendChild(track);
  return { track, update };
}

function createHorizontal(scrollEl, trackContainer) {
  const track = document.createElement('div');
  track.className = 'custom-scrollbar-h';
  const thumb = document.createElement('div');
  thumb.className = 'custom-scrollbar-h__thumb';
  track.appendChild(thumb);

  function update() {
    const { scrollWidth, clientWidth, scrollLeft } = scrollEl;
    const maxScroll = scrollWidth - clientWidth;
    if (maxScroll <= 0) {
      track.classList.add('is-hidden');
      return;
    }
    track.classList.remove('is-hidden');
    const trackWidth = clientWidth;
    const thumbWidth = Math.max(MIN_THUMB, (clientWidth / scrollWidth) * trackWidth);
    const thumbMaxLeft = trackWidth - thumbWidth;
    const thumbLeft = maxScroll > 0 ? (scrollLeft / maxScroll) * thumbMaxLeft : 0;
    thumb.style.width = `${thumbWidth}px`;
    thumb.style.transform = `translateX(${thumbLeft}px)`;
  }

  thumb.addEventListener('mousedown', (e) => {
    e.preventDefault();
    const dragStartX = e.clientX;
    const dragStartScrollLeft = scrollEl.scrollLeft;
    thumb.classList.add('is-dragging');
    const { scrollWidth, clientWidth } = scrollEl;
    const maxScroll = scrollWidth - clientWidth;
    const trackWidth = scrollEl.clientWidth;
    const thumbWidth = thumb.offsetWidth;
    const thumbMaxLeft = trackWidth - thumbWidth;
    const rate = maxScroll / (thumbMaxLeft || 1);

    function onMove(e) {
      const dx = e.clientX - dragStartX;
      scrollEl.scrollLeft = Math.max(0, Math.min(maxScroll, dragStartScrollLeft + dx * rate));
    }
    function onUp() {
      thumb.classList.remove('is-dragging');
      document.removeEventListener('mousemove', onMove);
      document.removeEventListener('mouseup', onUp);
    }
    document.addEventListener('mousemove', onMove);
    document.addEventListener('mouseup', onUp);
  });

  track.addEventListener('click', (e) => {
    if (e.target === thumb) return;
    const rect = track.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const { scrollWidth, clientWidth } = scrollEl;
    const maxScroll = scrollWidth - clientWidth;
    const thumbWidth = thumb.offsetWidth;
    const trackWidth = rect.width;
    const thumbMaxLeft = trackWidth - thumbWidth;
    const ratio = thumbMaxLeft > 0 ? (x - thumbWidth / 2) / thumbMaxLeft : 0;
    scrollEl.scrollLeft = Math.max(0, Math.min(maxScroll, ratio * maxScroll));
  });

  scrollEl.addEventListener('scroll', update);
  const ro = new ResizeObserver(update);
  ro.observe(scrollEl);
  update();
  trackContainer.appendChild(track);
  return { track, update };
}

function initCustomScroll(container) {
  if (!container || container.dataset.customScrollInit === '1') return;

  let scrollEl = container;
  let trackContainer = container;

  if (!container.classList.contains('custom-scroll-inner')) {
    container.dataset.customScrollInit = '1';
    container.classList.add('custom-scroll-host');
    const inner = document.createElement('div');
    inner.className = 'custom-scroll-inner';
    while (container.firstChild) {
      inner.appendChild(container.firstChild);
    }
    container.appendChild(inner);
    scrollEl = inner;
    trackContainer = container;
  }

  const needVertical = scrollEl.scrollHeight > scrollEl.clientHeight;
  const needHorizontal = scrollEl.scrollWidth > scrollEl.clientWidth;

  if (needVertical) {
    createVertical(scrollEl, trackContainer);
  }
  if (needHorizontal) {
    createHorizontal(scrollEl, trackContainer);
  }

  const ro = new ResizeObserver(() => {
    const hasV = trackContainer.querySelector('.custom-scrollbar-v');
    const hasH = trackContainer.querySelector('.custom-scrollbar-h');
    if (!hasV && scrollEl.scrollHeight > scrollEl.clientHeight) {
      createVertical(scrollEl, trackContainer);
    }
    if (!hasH && scrollEl.scrollWidth > scrollEl.clientWidth) {
      createHorizontal(scrollEl, trackContainer);
    }
    scrollEl.dispatchEvent(new Event('scroll', { bubbles: true }));
  });
  ro.observe(scrollEl);
}

function initAll(selector = '[data-custom-scroll]') {
  document.querySelectorAll(selector).forEach((el) => initCustomScroll(el));
}

export { initCustomScroll, initAll };
export default initAll;


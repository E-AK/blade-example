function getValue($tag) {
  return $tag.data('value');
}

function getOption($wrapper, value) {
  return $wrapper.find('.multiselect-item').filter(function () {
    return $(this).data('value') === value;
  });
}

function updateInput($wrapper) {
  const values = $wrapper
    .find('.multiselect-tag')
    .map(function () {
      return $(this).data('value');
    })
    .get();

  $wrapper.find('.multiselect-input').val(values.join(','));
}

function updateClasses($wrapper) {
  const count = $wrapper.find('.multiselect-tag').length;
  const $search = $wrapper.find('.multiselect-search');

  $wrapper.find('.multiselect').toggleClass('multiselect--filled', count >= 2);
  $search.attr(
    'placeholder',
    count >= 1 ? $search.data('search-placeholder') : $search.data('placeholder')
  );
}

function removeTag($wrapper, value) {
  $wrapper
    .find('.multiselect-tag')
    .filter(function () {
      return $(this).data('value') === value;
    })
    .remove();

  getOption($wrapper, value).attr('aria-selected', 'false');

  updateInput($wrapper);
  updateClasses($wrapper);
}

function filterDropdown($wrapper, query) {
  const q = (query || '').trim().toLowerCase();

  $wrapper.find('.multiselect-item').each(function () {
    const label = ($(this).data('label') || $(this).text()).trim().toLowerCase();
    const match = !q || label.includes(q);
    $(this).toggleClass('multiselect-item--hidden', !match);
  });
}

export default function initMultiselect() {
  $(document).on('click', '.multiselect-search', function (e) {
    e.stopPropagation();
  });

  $(document).on('click', '.multiselect', function (e) {
    e.stopPropagation();

    if ($(this).hasClass('disabled')) {
      return;
    }

    const $wrapper = $(this).closest('.multiselect-wrapper');
    const $dropdown = $wrapper.find('.multiselect-dropdown');

    $('.multiselect-dropdown').not($dropdown).hide();
    $('.multiselect-wrapper').not($wrapper).removeClass('open state-selected');

    const isOpening = !$wrapper.hasClass('open');
    $dropdown.toggle();
    $wrapper.toggleClass('open state-selected');

    if (isOpening) {
      $wrapper.find('.multiselect-search').val('').trigger('input').trigger('focus');
    }
  });

  $(document).on('click', '.multiselect-dropdown', function (e) {
    e.stopPropagation();
  });

  $(document).on('input', '.multiselect-search', function () {
    const $wrapper = $(this).closest('.multiselect-wrapper');
    filterDropdown($wrapper, $(this).val());
  });

  $(document).on('click', function () {
    $('.multiselect-dropdown').hide();
    $('.multiselect-wrapper').removeClass('open state-selected');
  });

  $(document).on('click', '.multiselect-item', function (e) {
    e.stopPropagation();

    const $item = $(this);
    const value = $item.data('value');
    const label = $item.text().trim();

    const $wrapper = $item.closest('.multiselect-wrapper');
    const $content = $wrapper.find('.multiselect-content');

    if ($item.attr('aria-selected') === 'true') {
      removeTag($wrapper, value);
      return;
    }

    const template = $wrapper.find('.multiselect-tag-template')[0];
    const fragment = template.content.cloneNode(true);
    const $tag = $(fragment.firstElementChild);

    $tag.attr('data-value', value);
    $tag.find('.tag-text').text(label);

    const $search = $content.find('.multiselect-search');

    $search.length ? $search.before($tag) : $content.append($tag);

    $item.attr('aria-selected', 'true');

    updateInput($wrapper);
    updateClasses($wrapper);
  });

  $(document).on('click', '.multiselect-tag .tag-icon-right', function (e) {
    e.stopPropagation();

    const $tag = $(this).closest('.multiselect-tag');
    const $wrapper = $tag.closest('.multiselect-wrapper');

    if ($wrapper.find('.multiselect').hasClass('disabled')) {
      return;
    }

    removeTag($wrapper, getValue($tag));
  });
}

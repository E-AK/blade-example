import $ from 'jquery';
import debounce from '../utils/debounce';
import 'datatables.net-bs5';
import sidebarIconUrl from '../../svg/actions_sidebar.svg?url';

export class Table {
  constructor(element) {
    this.$root = $(element);
    this.$table = this.$root.children('table').first();
    this.initTable();
    this.initSearch();
    this.initFilters();
  }

  initTable() {
    if (!this.$table || this.$table.length === 0 || !this.$table.data('options')) {
      return;
    }
    const options = this.$table.data('options');

    // Strip callback options that were JSON-serialized as strings (cannot be functions in JSON).
    // DataTables expects functions and calls .apply() on them, causing "val.apply is not a function".
    const callbackKeys = [
      'rowCallback',
      'drawCallback',
      'initComplete',
      'createdRow',
      'headerCallback',
      'footerCallback',
      'formatNumber',
      'search',
    ];
    callbackKeys.forEach((key) => {
      if (Object.prototype.hasOwnProperty.call(options, key) && typeof options[key] !== 'function') {
        delete options[key];
      }
    });

    options.ajax.data = function (data) {
      for (let i = 0; i < data.columns.length; i++) {
        // Clean up query params unused by laravel-datatables
        if (!data.columns[i].search.value) {
          delete data.columns[i].search;
        }
        if (data.columns[i].searchable === true) {
          delete data.columns[i].searchable;
        }
        if (data.columns[i].orderable === true) {
          delete data.columns[i].orderable;
        }
        if (data.columns[i].data === data.columns[i].name) {
          delete data.columns[i].name;
        }
      }
      delete data.search.regex;
    };

    this.instance = this.$table.DataTable(options);

    // Wrap only the table in scroll container so pagination/length stay outside
    if (!this.$table.parent().hasClass('data-table__scroll')) {
      this.$table.wrap('<div class="data-table__scroll"></div>');
    }

    this.instance.on('draw.dt', () => {
      this.truncateUserTags();
      this.injectViewUrlAttributes();
      this.injectSidebarTriggers();
      this.togglePagingVisibility();
      const tbody = this.$table.find('tbody')[0];
      if (tbody && window.Alpine) {
        requestAnimationFrame(() => {
          window.Alpine.initTree(tbody);
        });
      }
    });

    $(window).on(
      'resize',
      debounce(() => this.truncateUserTags(), 150)
    );
  }

  /**
   * Hide pagination and per-page control when the table has 10 or fewer records; show them otherwise.
   */
  togglePagingVisibility() {
    if (!this.instance) {
      return;
    }
    const info = this.instance.page.info();
    const hide = info.recordsTotal <= 10;
    const $container = $(this.instance.table().container());

    let $paging =
      $container.find('[data-dt-id="paging"]').length > 0
        ? $container.find('[data-dt-id="paging"]')
        : $container.find('.dt-paging');
    if (!$paging.length) {
      $paging = $container.find('.pagination').parent();
    }
    if ($paging.length) {
      $paging[hide ? 'hide' : 'show']();
    }

    let $length =
      $container.find('[data-dt-id="pageLength"]').length > 0
        ? $container.find('[data-dt-id="pageLength"]')
        : $container.find('.dt-length');
    if ($length.length) {
      $length[hide ? 'hide' : 'show']();
    }
  }

  initSearch() {
    const $searchInput = this.$root.find('.search-box input');
    if (!$searchInput || $searchInput.length === 0) {
      return;
    }
    const performSearch = (value) => {
      if (this.instance) {
        this.instance.search(value).draw();
      }
    };

    const debouncedSearch = debounce(performSearch, 300);

    $searchInput.on('input', (event) => {
      debouncedSearch(event.target.value);
    });
  }

  initFilters() {
    const $filterElements = this.$root.find('.data-table-filter');
    if (!$filterElements || $filterElements.length === 0) {
      return;
    }
    $filterElements.each((_, element) => {
      const $element = $(element);
      const columnName = $element.data('column');
      if (!columnName) {
        return;
      }
      const columnIndex = this.instance.column(`${columnName}:name`).index();
      $element.on('change', (event) => {
        if (this.instance) {
          this.instance.column(columnIndex).search(event.target.value).draw();
        }
      });
    });
  }

  injectViewUrlAttributes() {
    const dt = this.instance;
    if (!dt) {
      return;
    }
    dt.rows().every(function () {
      const row = this.node();
      const data = this.data();
      if (data && data.view_url) {
        $(row).attr('data-view-url', data.view_url);
      }
    });
  }

  injectSidebarTriggers() {
    if (!this.$table.data('sidebar')) {
      return;
    }
    const $tbody = this.$table.find('tbody');
    if (!$tbody.length) {
      return;
    }
    $tbody.find('tr').each(function () {
      $(this).find('td').each(function () {
        const $td = $(this);
        if ($td.hasClass('column-actions') || $td.find('.table-sidebar-open-trigger').length > 0) {
          return;
        }
        const iconStyle =
          'mask:url(' +
          sidebarIconUrl +
          ') center/contain no-repeat;' +
          '-webkit-mask:url(' +
          sidebarIconUrl +
          ') center/contain no-repeat;';
        const label = $td.closest('table').data('sidebar-label') || 'Открыть';
        const $trigger = $(
          '<span class="table-sidebar-open-trigger" role="button" tabindex="0">' +
            '<span class="table-sidebar-open-trigger__icon" style="' +
            iconStyle +
            '" aria-hidden="true"></span>' +
            '<span>' + label + '</span>' +
            '</span>'
        );
        $td.append($trigger);
      });
    });
  }

  truncateUserTags() {
    const self = this;
    const dt = this.instance;
    if (!dt) {
      return;
    }

    const $tbody = $(dt.table().body());
    const $rows = $tbody.find('tr');

    dt.rows().every(function () {
      const rowNode = this.node();
      const $td = $(rowNode).find('td.users-column');
      if ($td.length === 0) {
        return;
      }

      const $container = $td.find('.users-tags-container').first();
      if (!$container.length) {
        return;
      }

      const $tags = $container.children(':not(.more-tag)');
      $tags.show();
      $container.find('.more-tag').remove();

      const totalTags = parseInt($container.data('total-tags'), 10) || $tags.length;
      if (totalTags === 0) {
        return;
      }

      const containerWidth = $container.width();

      let gap = 0;
      if ($tags.length > 1) {
        const $first = $tags.eq(0);
        const $second = $tags.eq(1);
        gap = $second.position().left - ($first.position().left + $first.outerWidth(true));
      }

      let currentWidth = 0;
      let visibleCount = 0;

      for (let i = 0; i < $tags.length; i++) {
        const $tag = $tags.eq(i);
        const tagWidth = $tag.outerWidth(true);
        if (i > 0) {
          currentWidth += gap;
        }
        if (currentWidth + tagWidth <= containerWidth) {
          currentWidth += tagWidth;
          visibleCount++;
        } else {
          $tag.hide();
          for (let j = i + 1; j < $tags.length; j++) {
            $tags.eq(j).hide();
          }
          break;
        }
      }

      if (visibleCount === totalTags) {
        return;
      }

      const tagsToShow = Math.max(0, visibleCount - 1);
      const hiddenCount = totalTags - tagsToShow;

      for (let i = 0; i < $tags.length; i++) {
        if (i < tagsToShow) {
          $tags.eq(i).show();
        } else {
          $tags.eq(i).hide();
        }
      }

      const $moreBadge = $('<span>', {
        class: 'tag tag-sm more-tag',
        text: '+' + hiddenCount,
      });

      if (tagsToShow === 0) {
        $container.prepend($moreBadge);
      } else {
        $tags.eq(tagsToShow - 1).after($moreBadge);
      }
    });
  }
}

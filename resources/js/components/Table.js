import $ from 'jquery';
import debounce from '../utils/debounce';
import 'datatables.net-bs5';
import sidebarIconUrl from '../../svg/actions_sidebar.svg?url';
import arrowSwooshIconUrl from '../../svg/arrow_swoosh.svg?url';

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

    const self = this;
    // Normalize ajax to an object (Yajra may pass a string URL)
    if (typeof options.ajax === 'string') {
      options.ajax = { url: options.ajax };
    }
    if (options.ajax && typeof options.ajax === 'object') {
      const existingData = options.ajax.data;
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
        const deletedOnly = self.$root.parent().data('deletedOnly');
        if (deletedOnly !== undefined && deletedOnly !== null) {
          data.deleted_only = deletedOnly ? 1 : 0;
        }
        const folder = self.$root.parent().attr('data-folder');
        if (folder !== undefined && folder !== null && folder !== '') {
          data.folder = folder;
        }
        const passwordFilter = self.$root.parent().attr('data-password-filter');
        if (passwordFilter !== undefined && passwordFilter !== null && passwordFilter !== '') {
          data.password_filter = passwordFilter;
        }
        const accessType = self.$root.attr('data-access-type');
        if (accessType !== undefined && accessType !== null && accessType !== '') {
          data.access_type = accessType;
        }
        if (typeof existingData === 'function') {
          existingData(data);
        }
      };
    }

    this.instance = this.$table.DataTable(options);

    // Wrap only the table in scroll container so pagination/length stay outside
    if (!this.$table.parent().hasClass('data-table__scroll')) {
      this.$table.wrap('<div class="data-table__scroll"></div>');
    }

    this.instance.on('draw.dt', () => {
      if (this.isPasswordManagerTable()) {
        this.$table.addClass('password-manager-table');
        const store = window.Alpine && window.Alpine.store && window.Alpine.store('passwordManager');
        if (store && store.searchApplied) {
          const info = this.instance.page.info();
          store.searchDescription = `По запросу найдено ${info.recordsDisplay} элементов`;
          store.searchApplied = false;
        }
      }
      this.applyAccessTableColumnVisibility();
      this.truncateUserTags();
      this.injectViewUrlAttributes();
      this.injectSidebarTriggers();
      this.injectPasswordManagerRowData();
      this.bindPasswordManagerRowClick();
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
    const $searchInput = this.$root.find('.search-box input, .search-input');
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

  /**
   * For password-manager table: set data-entry on each row with entry_data JSON for sidebar edit.
   */
  injectPasswordManagerRowData() {
    if (!this.isPasswordManagerTable() || !this.instance) {
      return;
    }
    const dt = this.instance;
    dt.rows().every(function () {
      const row = this.node();
      const data = this.data();
      const entryData = data && (data.entry_data !== undefined ? data.entry_data : data[6]);
      if (entryData) {
        $(row).attr('data-entry', typeof entryData === 'string' ? entryData : JSON.stringify(entryData));
      }
    });
  }

  isPasswordManagerTable() {
    return (
      this.$table.hasClass('password-manager-table') ||
      this.$table.hasClass('password-manager-access-table') ||
      (this.$root.parent().attr && this.$root.parent().attr('id') === 'password-manager-table') ||
      (this.$root.attr && this.$root.attr('id') === 'password-manager-access-table')
    );
  }

  /**
   * For access table: show/hide columns by tab (sent: name, employee, email; received: name, login, password).
   * Column indices: 0=id, 1=name, 2=employee, 3=email, 4=login, 5=password, 6=entry_data.
   */
  applyAccessTableColumnVisibility() {
    if (!this.instance || !this.$table.hasClass('password-manager-access-table')) {
      return;
    }
    const accessType = this.$root.attr('data-access-type') || 'sent';
    const api = this.instance;
    const showSent = accessType === 'sent';
    api.column(2).visible(showSent); // employee
    api.column(3).visible(showSent); // email
    api.column(4).visible(!showSent); // login
    api.column(5).visible(!showSent); // password
  }

  /**
   * For password-manager table: bind delegated click on tbody to dispatch open-edit event with data-entry.
   */
  bindPasswordManagerRowClick() {
    if (!this.isPasswordManagerTable() || this._passwordManagerClickBound) {
      return;
    }
    this._passwordManagerClickBound = true;
    this.$root.on('click', 'tbody tr', (e) => {
      if ($(e.target).closest('.column-actions').length) {
        return;
      }
      const $tr = $(e.currentTarget);
      const entry = $tr.attr('data-entry');
      if (entry) {
        window.dispatchEvent(new CustomEvent('password-manager-open-edit', { detail: { entry } }));
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
        const label = $td.closest('table').data('sidebar-label') || 'Открыть';
        const isViewLabel = label === 'Просмотр';
        const iconUrl = isViewLabel ? arrowSwooshIconUrl : sidebarIconUrl;
        const iconStyle =
          'mask:url(' +
          iconUrl +
          ') center/contain no-repeat;' +
          '-webkit-mask:url(' +
          iconUrl +
          ') center/contain no-repeat;';
        const iconHtml =
          '<span class="table-sidebar-open-trigger__icon" style="' +
          iconStyle +
          '" aria-hidden="true"></span>';
        const labelHtml = '<span>' + label + '</span>';
        const contentHtml = isViewLabel ? labelHtml + iconHtml : iconHtml + labelHtml;
        const triggerClass =
          'table-sidebar-open-trigger' + (isViewLabel ? ' table-sidebar-open-trigger--icon-right' : '');
        const $trigger = $(
          '<span class="' +
            triggerClass +
            '" role="button" tabindex="0">' +
            '<span class="table-sidebar-open-trigger__inner">' +
            contentHtml +
            '</span>' +
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

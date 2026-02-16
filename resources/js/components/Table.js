import $ from 'jquery';
import debounce from '../utils/debounce';
import 'datatables.net-bs5';

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

    this.instance.on('draw.dt', () => this.truncateUserTags());

    $(window).on(
      'resize',
      debounce(() => this.truncateUserTags(), 150)
    );
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

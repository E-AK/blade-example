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
        if (!this.$table || this.$table.length === 0 || !Boolean(this.$table.data('options'))) {
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
}

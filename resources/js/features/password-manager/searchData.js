/**
 * Alpine-данные поиска в менеджере паролей (автодополнение, фильтры).
 * Один модуль — одна задача: состояние и запросы поиска.
 */

import debounce from '../../utils/debounce.js';

export function passwordManagerSearchData() {
  const fetchAutocompleteDebounced = debounce(function fetchAutocomplete() {
    const q = this.query.trim();
    if (!this.autocompleteUrl || q === '') {
      this.entries = [];
      this.total = 0;
      this.dropdownOpen = false;
      return;
    }
    this.loading = true;
    const folder = this.store?.selectedFolderName ?? '';
    const params = new URLSearchParams({ q, folder });
    window.axios
      .get(`${this.autocompleteUrl}?${params}`)
      .then((res) => {
        this.entries = res.data.entries || [];
        this.total = res.data.total ?? 0;
        this.dropdownOpen = true;
        this.hoverIndex = -1;
      })
      .catch(() => {
        this.entries = [];
        this.total = 0;
      })
      .finally(() => {
        this.loading = false;
      });
  }, 250);

  return {
    autocompleteUrl: '',
    query: '',
    dropdownOpen: false,
    entries: [],
    total: 0,
    loading: false,
    hoverIndex: -1,

    get store() {
      return Alpine.store('passwordManager');
    },

    init() {
      const el = this.$el.closest('[data-autocomplete-url]');
      if (el && el.dataset.autocompleteUrl) {
        this.autocompleteUrl = el.dataset.autocompleteUrl;
      }
    },

    get showDropdown() {
      return this.dropdownOpen && this.query.trim() !== '';
    },

    get folderName() {
      return this.store?.selectedFolderName ?? null;
    },

    get tagName() {
      return this.store?.selectedTag ?? null;
    },

    get searchDescriptionText() {
      return this.store?.searchDescription ?? '';
    },

    get showAllLabel() {
      return 'Показать все пароли, содержащие «' + (this.query || '') + '»';
    },

    fetchAutocomplete() {
      fetchAutocompleteDebounced.call(this);
    },

    onInput() {
      const q = this.query.trim();
      if (q === '') {
        this.dropdownOpen = false;
        this.entries = [];
        this.total = 0;
        if (this.store) this.store.searchDescription = '';
        return;
      }
      this.fetchAutocomplete();
    },

    onBlur() {
      setTimeout(() => {
        this.dropdownOpen = false;
      }, 180);
    },

    onShowAll() {
      if (!this.store) return;
      this.store.searchApplied = true;
      const input = this.$refs.searchInput;
      if (input) {
        input.dispatchEvent(new Event('input', { bubbles: true }));
      }
      this.dropdownOpen = false;
    },

    onAddEntryToSearch(entry) {
      const store = this.store;
      if (entry.tag && typeof entry.tag === 'string' && entry.tag.trim() !== '') {
        if (store) store.selectedTag = entry.tag.trim();
      }
      if (entry.name) {
        this.query = entry.name;
      }
      this.dropdownOpen = false;
      this.reloadTable();
    },

    clearFolder() {
      const store = this.store;
      if (store) {
        store.selectedFolderId = null;
        store.selectedFolderName = null;
        window.dispatchEvent(new CustomEvent('password-manager-clear-folder'));
      }
      this.reloadTable();
    },

    clearTag() {
      const store = this.store;
      if (store) store.selectedTag = null;
      this.reloadTable();
    },

    reloadTable() {
      const wrapper = document.getElementById('password-manager-table');
      const table = wrapper?.querySelector('table');
      if (table && window.$ && $(table).DataTable) {
        $(table).DataTable().ajax.reload();
      }
    },
  };
}

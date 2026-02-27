import Sortable from 'sortablejs';
import Alpine from 'alpinejs';

const DROP_BEFORE_CLASS = 'password-manager-folder-item--drop-before';
const DROP_AFTER_CLASS = 'password-manager-folder-item--drop-after';
const DROP_INTO_CLASS = 'password-manager-folder-item--drop-into';
const DROP_BEFORE_FORBIDDEN_CLASS = 'password-manager-folder-item--drop-before-forbidden';
const DROP_AFTER_FORBIDDEN_CLASS = 'password-manager-folder-item--drop-after-forbidden';
const DROP_INTO_FORBIDDEN_CLASS = 'password-manager-folder-item--drop-into-forbidden';

const ALL_DROP_INDICATOR_CLASSES = [
  DROP_BEFORE_CLASS,
  DROP_AFTER_CLASS,
  DROP_INTO_CLASS,
  DROP_BEFORE_FORBIDDEN_CLASS,
  DROP_AFTER_FORBIDDEN_CLASS,
  DROP_INTO_FORBIDDEN_CLASS,
];

function removeDropIndicatorClasses(el) {
  if (el) {
    ALL_DROP_INDICATOR_CLASSES.forEach((c) => el.classList.remove(c));
  }
}

function isDescendant(foldersFlat, folderId, ancestorId) {
  let current = foldersFlat.find((f) => f.id == folderId);
  while (current) {
    if (current.id == ancestorId) return true;
    current =
      current.parentId != null ? foldersFlat.find((f) => f.id == current.parentId) : null;
  }
  return false;
}

/**
 * Проверка: перенос в эту позицию запрещён (родительская папка в своего потомка).
 * @param {Array} foldersFlat - плоский список папок с parentId
 * @param {string} draggedId - id перетаскиваемой папки
 * @param {Element} relatedEl - элемент, относительно которого вставляем (before/after)
 */
function isDropForbidden(foldersFlat, draggedId, relatedEl) {
  if (!relatedEl || !foldersFlat.length) return false;
  const relatedFolder = foldersFlat.find((f) => f.id == relatedEl.dataset.id);
  if (!relatedFolder) return false;
  const relatedParentId = relatedFolder.parentId;
  if (relatedParentId == null) return false;
  return relatedParentId == draggedId || isDescendant(foldersFlat, relatedParentId, draggedId);
}

/**
 * Проверка: перенос «внутрь» папки запрещён (в себя или в своего потомка).
 */
function isDropIntoForbidden(foldersFlat, draggedId, relatedEl) {
  if (!relatedEl || !foldersFlat.length) return false;
  const targetId = relatedEl.dataset.id;
  return targetId == draggedId || isDescendant(foldersFlat, targetId, draggedId);
}

const SCROLL_EDGE_THRESHOLD = 40;
const SCROLL_STEP = 8;

/**
 * Автопрокрутка контейнера при перетаскивании возле верхней/нижней границы.
 * @param {HTMLElement} scrollEl - прокручиваемый элемент
 * @param {number} clientY - координата Y курсора
 */
function autoScrollIfNearEdge(scrollEl, clientY) {
  if (!scrollEl || !scrollEl.getBoundingClientRect) return;
  const rect = scrollEl.getBoundingClientRect();
  const topEdge = rect.top + SCROLL_EDGE_THRESHOLD;
  const bottomEdge = rect.bottom - SCROLL_EDGE_THRESHOLD;
  if (clientY < topEdge && scrollEl.scrollTop > 0) {
    scrollEl.scrollTop = Math.max(0, scrollEl.scrollTop - SCROLL_STEP);
  } else if (clientY > bottomEdge) {
    const maxScroll = scrollEl.scrollHeight - scrollEl.clientHeight;
    if (maxScroll > 0 && scrollEl.scrollTop < maxScroll) {
      scrollEl.scrollTop = Math.min(maxScroll, scrollEl.scrollTop + SCROLL_STEP);
    }
  }
}

/**
 * Инициализирует DnD для списка папок. Вызывается из Alpine x-init после отрисовки списка.
 * @param {HTMLElement} listEl - элемент <ul> со списком папок
 * @param {Array} foldersFlat - плоский список папок (id, parentId, ...) для проверки запрещённого переноса
 * @param {HTMLElement} [scrollEl] - прокручиваемый контейнер для автопрокрутки при перетаскивании у границ
 * @param {function(string)} [onDrag] - callback('start' | 'end') для виртуализации (временно рендерить все при перетаскивании)
 */
function initPasswordManagerSortable(listEl, foldersFlat = [], scrollEl = null, onDrag = null) {
  if (!listEl || listEl._sortable) {
    return;
  }

  let lastDropTarget = null;
  let lastValidDropTarget = null;
  let lastValidWillInsertAfter = null;
  let scrollListener = null;

  Sortable.create(listEl, {
    animation: 0,
    handle: '.password-manager-folder-item__handle',
    filter: '.password-manager-folder-item--no-drag',
    ghostClass: 'password-manager-folder-item--ghost',
    dragClass: 'password-manager-folder-item--drag',
    onStart(evt) {
      onDrag?.('start');
      evt.item.classList.add('password-manager-folder-item--dragging');
      if (scrollEl) {
        scrollListener = (e) => autoScrollIfNearEdge(scrollEl, e.clientY);
        document.addEventListener('mousemove', scrollListener);
      }
    },
    onMove(evt) {
      removeDropIndicatorClasses(lastDropTarget);
      lastDropTarget = null;
      lastValidDropTarget = null;
      lastValidWillInsertAfter = null;
      if (evt.related && !evt.related.classList.contains('password-manager-folder-item--trash')) {
        const draggedId = evt.dragged?.dataset?.id;
        const isParent = evt.related.classList.contains('password-manager-folder-item--parent');
        const dropInto = isParent && evt.willInsertAfter;

        if (dropInto) {
          const forbiddenInto = draggedId && isDropIntoForbidden(foldersFlat, draggedId, evt.related);
          lastDropTarget = evt.related;
          if (forbiddenInto) {
            evt.related.classList.add(DROP_INTO_FORBIDDEN_CLASS);
            return false;
          }
          lastValidDropTarget = evt.related;
          lastValidWillInsertAfter = true;
          evt.related.classList.add(DROP_INTO_CLASS);
        } else {
          const forbidden = draggedId && isDropForbidden(foldersFlat, draggedId, evt.related);
          lastDropTarget = evt.related;
          if (forbidden) {
            if (evt.willInsertAfter) {
              evt.related.classList.add(DROP_AFTER_FORBIDDEN_CLASS);
            } else {
              evt.related.classList.add(DROP_BEFORE_FORBIDDEN_CLASS);
            }
            return false;
          }
          lastValidDropTarget = evt.related;
          lastValidWillInsertAfter = evt.willInsertAfter;
          if (evt.willInsertAfter) {
            evt.related.classList.add(DROP_AFTER_CLASS);
          } else {
            evt.related.classList.add(DROP_BEFORE_CLASS);
          }
        }
      }
      return false;
    },
    onEnd(evt) {
      onDrag?.('end');
      if (scrollListener) {
        document.removeEventListener('mousemove', scrollListener);
        scrollListener = null;
      }
      evt.item.classList.remove('password-manager-folder-item--dragging');
      ALL_DROP_INDICATOR_CLASSES.forEach((cls) => {
        listEl.querySelectorAll('.' + cls).forEach((el) => el.classList.remove(cls));
      });
      if (lastValidDropTarget && evt.item) {
        const ref = lastValidWillInsertAfter
          ? lastValidDropTarget.nextElementSibling
          : lastValidDropTarget;
        if (ref) {
          listEl.insertBefore(evt.item, ref);
        } else {
          listEl.appendChild(evt.item);
        }
      }
      lastDropTarget = null;
      lastValidDropTarget = null;
      lastValidWillInsertAfter = null;
    },
  });
}

/**
 * Инициализирует DnD для списка тегов в сайдбаре «Управление тегами».
 * @param {HTMLElement} listEl - контейнер со строками тегов
 */
function initPasswordManagerTagsSortable(listEl) {
  if (!listEl || listEl._sortable) {
    return;
  }
  Sortable.create(listEl, {
    animation: 150,
    handle: '.password-manager-tags-sidebar__tag-handle',
    ghostClass: 'password-manager-tags-sidebar__tag-row--ghost',
    dragClass: 'password-manager-tags-sidebar__tag-row--drag',
  });
}

const FOLDERS_DATA_ID = 'password-manager-folders-data';
const ITEM_HEIGHT = 36;
const OVERSCAN = 8;
const VIRTUALIZE_THRESHOLD = 20;

/**
 * Alpine-компонент списка папок. Данные читаются из script#password-manager-folders-data.
 * Виртуализация: в DOM только папки в видимой области + overscan; при перетаскивании рендерятся все.
 */
function passwordManagerFoldersData() {
  const dataEl = document.getElementById(FOLDERS_DATA_ID);
  const foldersFlat = dataEl ? JSON.parse(dataEl.textContent) : [];
  return {
    foldersFlat,
    expandedIds: { '1': true },
    selectedId: null,
    scrollTop: 0,
    containerHeight: 0,
    isDragging: false,
    deleteModalOpen: false,
    folderToDelete: null,
    deleteTarget: 'delete_with',
    deleteModalSelectOpen: false,
    editingFolderId: null,
    editingFolderName: '',
    newSubfolderParentId: null,
    newSubfolderName: '',

    startNewSubfolder(payload) {
      if (!payload || payload.parentId == null) return;
      this.newSubfolderParentId = payload.parentId;
      this.newSubfolderName = '';
      this.expandedIds[payload.parentId] = true;
      this.expandedIds = { ...this.expandedIds };
    },

    cancelNewSubfolder() {
      this.newSubfolderParentId = null;
      this.newSubfolderName = '';
    },

    saveNewSubfolder() {
      const name = this.newSubfolderName?.trim() ?? '';
      if (name && this.newSubfolderParentId != null) {
        const parent = this.foldersFlat.find(
          (f) => String(f.id) === String(this.newSubfolderParentId)
        );
        if (parent) {
          const newId = 'new-' + Date.now();
          const depth = (parent.depth ?? 0) + 1;
          this.foldersFlat.push({
            id: newId,
            parentId: parent.id,
            name,
            depth,
            hasChildren: false,
            passwordsCount: 0,
          });
          this.expandedIds[this.newSubfolderParentId] = true;
          this.expandedIds = { ...this.expandedIds };
        }
      }
      this.cancelNewSubfolder();
    },

    startRename(payload) {
      if (!payload || !payload.id) return;
      this.editingFolderId = payload.id;
      this.editingFolderName = payload.name ?? '';
      this.$nextTick(() => {
        const el = this.$el.querySelector('[data-rename-input]');
        if (el) {
          el.focus();
          el.select();
        }
      });
    },

    cancelRename() {
      this.editingFolderId = null;
      this.editingFolderName = '';
    },

    saveRename() {
      if (!this.editingFolderId) return;
      const name = this.editingFolderName?.trim() ?? '';
      if (name) {
        const folder = this.foldersFlat.find((f) => String(f.id) === String(this.editingFolderId));
        if (folder) folder.name = name;
      }
      this.cancelRename();
    },

    openDeleteModal(folder) {
      this.folderToDelete = folder
        ? { id: folder.id, name: folder.name, passwordsCount: folder.passwordsCount ?? 0 }
        : null;
      this.deleteTarget = 'delete_with';
      this.deleteModalOpen = true;
    },

    closeDeleteModal() {
      this.deleteModalOpen = false;
      this.deleteModalSelectOpen = false;
      this.folderToDelete = null;
    },

    get deleteModalOptions() {
      const opts = [{ value: 'delete_with', label: 'Удалить вместе с папкой' }];
      if (!this.folderToDelete) return opts;
      this.foldersFlat.forEach((f) => {
        if (String(f.id) !== String(this.folderToDelete.id)) {
          opts.push({ value: String(f.id), label: f.name });
        }
      });
      return opts;
    },

    get deleteModalSelectedLabel() {
      const opt = this.deleteModalOptions.find((o) => o.value === this.deleteTarget);
      return opt ? opt.label : 'Выбор папки';
    },

    get deleteModalMessage() {
      if (!this.folderToDelete) return '';
      const n = this.folderToDelete.passwordsCount || 0;
      return 'Вы собираетесь удалить папку, в которой находится ' + n + ' паролей.';
    },

    get visibleFolders() {
      return this.foldersFlat.filter((item) => this.isVisible(item));
    },

    get virtualStartIndex() {
      const total = this.visibleFolders.length;
      if (total <= VIRTUALIZE_THRESHOLD || this.containerHeight <= 0) return 0;
      const start = Math.floor(this.scrollTop / ITEM_HEIGHT) - OVERSCAN;
      return Math.max(0, start);
    },

    get virtualEndIndex() {
      const total = this.visibleFolders.length;
      if (total <= VIRTUALIZE_THRESHOLD || this.containerHeight <= 0) return total;
      const visibleCount = Math.ceil(this.containerHeight / ITEM_HEIGHT);
      const end = this.virtualStartIndex + visibleCount + OVERSCAN * 2;
      return Math.min(total, end);
    },

    get renderedFolders() {
      if (this.isDragging || this.visibleFolders.length <= VIRTUALIZE_THRESHOLD) {
        return this.visibleFolders;
      }
      return this.visibleFolders.slice(this.virtualStartIndex, this.virtualEndIndex);
    },

    get topSpacerHeight() {
      if (this.isDragging || this.visibleFolders.length <= VIRTUALIZE_THRESHOLD) return 0;
      return this.virtualStartIndex * ITEM_HEIGHT;
    },

    get bottomSpacerHeight() {
      if (this.isDragging || this.visibleFolders.length <= VIRTUALIZE_THRESHOLD) return 0;
      const total = this.visibleFolders.length;
      const end = this.virtualEndIndex;
      return (total - end) * ITEM_HEIGHT;
    },

    isVisible(item) {
      if (item.depth === 0) return true;
      const parent = this.foldersFlat.find((f) => f.id === item.parentId);
      return parent && this.expandedIds[parent.id] && this.isVisible(parent);
    },

    toggleExpand(id) {
      this.expandedIds[id] = !this.expandedIds[id];
      this.expandedIds = { ...this.expandedIds };
    },

    select(id) {
      this.selectedId = id;
      const folder = this.foldersFlat.find((f) => String(f.id) === String(id));
      const store = Alpine.store('passwordManager');
      if (store) {
        store.selectedFolderId = id;
        store.selectedFolderName = folder ? folder.name : null;
      }
      window.dispatchEvent(new CustomEvent('password-manager-reload-table'));
    },

    _onScroll() {
      const scrollHost = this.$refs.foldersScroll;
      const scrollEl = scrollHost?.querySelector('.custom-scroll-inner') || scrollHost;
      if (scrollEl) {
        this.scrollTop = scrollEl.scrollTop;
        this.containerHeight = scrollEl.clientHeight;
      }
    },

    init() {
      const store = Alpine.store('passwordManager');
      if (store && store.selectedFolderId != null) {
        this.selectedId = store.selectedFolderId;
      }
      this.$nextTick(() => {
        const scrollHost = this.$refs.foldersScroll;
        const scrollEl = scrollHost?.querySelector('.custom-scroll-inner') || scrollHost;
        this._onScroll();
        if (!scrollHost?._folderScrollListenerAttached) {
          scrollHost._folderScrollListenerAttached = true;
          const attachScroll = () => {
            const inner = scrollHost?.querySelector('.custom-scroll-inner');
            const el = inner || scrollHost;
            this._onScroll();
            if (inner && !inner._folderScrollBound) {
              inner._folderScrollBound = true;
              inner.addEventListener('scroll', () => this._onScroll(), { passive: true });
            }
          };
          attachScroll();
          setTimeout(attachScroll, 200);
        }
        if (this.$refs.folderList) {
          initPasswordManagerSortable(
            this.$refs.folderList,
            this.foldersFlat,
            scrollEl,
            (event) => {
              this.isDragging = event === 'start';
            }
          );
        }
        const runScrollCheck = () => {
          requestAnimationFrame(() => {
            this._onScroll();
            setTimeout(() => this.updateFolderListHasScroll(), 50);
          });
        };
        runScrollCheck();
        const elToObserve = scrollHost || scrollEl;
        if (elToObserve && typeof ResizeObserver !== 'undefined') {
          this._scrollResizeObserver = new ResizeObserver(runScrollCheck);
          this._scrollResizeObserver.observe(elToObserve);
        }
        this._scrollCheckUnwatch = this.$watch('visibleFolders', () => runScrollCheck(), { deep: true });
      });
    },

    updateFolderListHasScroll() {
      const store = Alpine.store('passwordManager');
      if (!store) return;
      const host = this.$refs.foldersScroll;
      const scrollEl = host?.querySelector('.custom-scroll-inner') || host;
      store.folderListHasScroll = scrollEl ? scrollEl.scrollHeight > scrollEl.clientHeight : false;
    },
  };
}

function passwordManagerTagsSidebarData() {
  return {
    init() {
      this.$nextTick(() => {
        if (this.$refs.tagsList) {
          initPasswordManagerTagsSortable(this.$refs.tagsList);
        }
      });
    },
  };
}

let searchDebounceTimer = null;

function passwordManagerSearchData() {
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
    },

    onInput() {
      if (searchDebounceTimer) clearTimeout(searchDebounceTimer);
      const q = this.query.trim();
      if (q === '') {
        this.dropdownOpen = false;
        this.entries = [];
        this.total = 0;
        if (this.store) this.store.searchDescription = '';
        return;
      }
      searchDebounceTimer = setTimeout(() => this.fetchAutocomplete(), 250);
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

export default function initPasswordManagerFolders() {
  window.initPasswordManagerSortable = initPasswordManagerSortable;
  window.initPasswordManagerTagsSortable = initPasswordManagerTagsSortable;
  window.passwordManagerFolders = passwordManagerFoldersData;
  window.passwordManagerSearchData = passwordManagerSearchData;
  Alpine.data('passwordManagerFolders', passwordManagerFoldersData);
  Alpine.data('passwordManagerSearch', passwordManagerSearchData);
  Alpine.data('passwordManagerTagsSidebar', passwordManagerTagsSidebarData);
}

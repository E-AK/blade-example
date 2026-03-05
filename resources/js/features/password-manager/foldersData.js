/**
 * Alpine-данные списка папок менеджера паролей.
 * Один модуль — одна задача: состояние и методы дерева папок.
 */

import { initPasswordManagerSortable } from './sortable.js';

const FOLDERS_DATA_ID = 'password-manager-folders-data';

export function passwordManagerFoldersData() {
  const dataEl = document.getElementById(FOLDERS_DATA_ID);
  const foldersFlat = dataEl ? JSON.parse(dataEl.textContent) : [];
  return {
    foldersFlat,
    expandedIds: { '1': true },
    selectedId: null,
    deleteModalOpen: false,
    folderToDelete: null,
    deleteTarget: 'delete_with',
    deleteModalSelectOpen: false,
    editingFolderId: null,
    editingFolderName: '',
    newSubfolderParentId: null,
    newSubfolderName: '',
    newTopFolderName: '',

    saveNewTopFolder() {
      const name = this.newTopFolderName?.trim() ?? '';
      if (name) {
        const newId = 'new-' + Date.now();
        this.foldersFlat.push({
          id: newId,
          parentId: null,
          name,
          depth: 0,
          hasChildren: false,
          passwordsCount: 0,
        });
      }
      this.newTopFolderName = '';
      this.$dispatch('password-manager-new-folder-saved');
    },

    cancelNewTopFolder() {
      this.newTopFolderName = '';
      this.$dispatch('password-manager-new-folder-cancel');
    },

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

    handleFolderMenuAction(detail) {
      if (!detail || !detail.folderId) return;
      if (detail.action === 'create-subfolder') {
        this.startNewSubfolder({
          parentId: detail.folderId,
          parentDepth: parseInt(detail.folderDepth, 10) || 0,
        });
      } else if (detail.action === 'rename') {
        this.startRename({ id: detail.folderId, name: detail.folderName });
      } else if (detail.action === 'delete') {
        this.openDeleteModal({
          id: detail.folderId,
          name: detail.folderName,
          passwordsCount: parseInt(detail.passwordsCount, 10) || 0,
        });
      }
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

    init() {
      const store = Alpine.store('passwordManager');
      if (store && store.selectedFolderId != null) {
        this.selectedId = store.selectedFolderId;
      }
      this.$nextTick(() => {
        const scrollHost = this.$refs.foldersScroll;
        const scrollEl = scrollHost?.querySelector('.custom-scroll-inner') || scrollHost;
        if (!scrollHost?._folderScrollListenerAttached) {
          scrollHost._folderScrollListenerAttached = true;
          const inner = scrollHost?.querySelector('.custom-scroll-inner');
          const scrollElForListener = inner || scrollHost;
          if (scrollElForListener && !scrollElForListener._folderScrollBound) {
            scrollElForListener._folderScrollBound = true;
            scrollElForListener.addEventListener('scroll', () => this.updateFolderListHasScroll(), {
              passive: true,
            });
          }
        }
        if (this.$refs.folderList) {
          initPasswordManagerSortable(this.$refs.folderList, this.foldersFlat);
        }
        const runScrollCheck = () => {
          requestAnimationFrame(() => this.updateFolderListHasScroll());
        };
        runScrollCheck();
        const elToObserve = scrollHost || scrollEl;
        if (elToObserve && typeof ResizeObserver !== 'undefined') {
          this._scrollResizeObserver = new ResizeObserver(runScrollCheck);
          this._scrollResizeObserver.observe(elToObserve);
        }
        this._scrollCheckUnwatch = this.$watch('visibleFolders', runScrollCheck, { deep: true });
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

/**
 * Alpine store и глобальный слушатель для менеджера паролей.
 * Один модуль — одна ответственность: состояние и методы sidebar/редактирования.
 */

const initialState = {
  showTrashed: false,
  folderListHasScroll: false,
  addSidebarOpen: false,
  accessSidebarOpen: false,
  editEntry: null,
  editEntryId: null,
  formName: '',
  formUrl: '',
  formFolder: '',
  formTag: [],
  formLogin: '',
  formPassword: '',
  formEmployees: [],
  selectedFolderId: null,
  selectedFolderName: null,
  selectedTag: null,
  searchDescription: '',
  searchApplied: false,
  openAddSidebar() {
    this.editEntryId = null;
    this.editEntry = null;
    this.formName = '';
    this.formUrl = '';
    this.formFolder = '';
    this.formTag = [];
    this.formLogin = '';
    this.formPassword = '';
    this.formEmployees = [];
    this.addSidebarOpen = true;
  },
  openAccessSidebar() {
    this.accessSidebarOpen = true;
  },
  openEditSidebar(entryJson) {
    const e = typeof entryJson === 'string' ? JSON.parse(entryJson) : entryJson;
    this.editEntry = e;
    this.editEntryId = e.id;
    this.formName = e.name || '';
    this.formUrl = e.url || '';
    this.formFolder = e.folder || '';
    this.formTag = Array.isArray(e.tags) ? e.tags : (e.tag ? [e.tag] : []);
    this.formLogin = e.login || '';
    this.formPassword = '';
    this.formEmployees = Array.isArray(e.employees) ? e.employees : [];
    this.addSidebarOpen = true;
  },
};

/**
 * Регистрирует store и глобальные слушатели событий менеджера паролей.
 * @param {object} Alpine
 */
export function initPasswordManagerStore(Alpine) {
  if (!Alpine.store('passwordManager')) {
    Alpine.store('passwordManager', initialState);
  }
  window.addEventListener('password-manager-open-edit', (e) => {
    if (e.detail?.entry && Alpine.store('passwordManager')) {
      Alpine.store('passwordManager').openEditSidebar(e.detail.entry);
      Alpine.store('passwordManager').accessSidebarOpen = false;
    }
  });
  window.addEventListener('password-manager-open-add-sidebar', () => {
    if (Alpine.store('passwordManager')) {
      Alpine.store('passwordManager').openAddSidebar();
    }
  });
  window.addEventListener('password-manager-open-access-sidebar', () => {
    if (Alpine.store('passwordManager')) {
      Alpine.store('passwordManager').openAccessSidebar();
    }
  });
}

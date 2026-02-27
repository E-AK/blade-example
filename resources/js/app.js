import './bootstrap';
import $ from 'jquery';
import Alpine from 'alpinejs';

import initSidebar from './layout/sidebar';
import initSearch from './ui/search';
import initToast from './ui/toast';
import initTables from './components/initTables';
import initPasswordManagerFolders from './components/passwordManagerFolders';
import buttonToggle from './ui/buttonToggle';
import tooltip from './ui/tooltip';
import dropdown from './ui/dropdown';
import multiselect from './ui/multiselect';
import { initAll as initCustomScroll } from './ui/customScroll';

window.Alpine = Alpine;
if (!Alpine.store('passwordManager')) {
  Alpine.store('passwordManager', {
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
  });
}
window.addEventListener('password-manager-open-edit', (e) => {
  if (e.detail && e.detail.entry && Alpine.store('passwordManager')) {
    Alpine.store('passwordManager').openEditSidebar(e.detail.entry);
    Alpine.store('passwordManager').accessSidebarOpen = false;
  }
});
buttonToggle(Alpine);
tooltip(Alpine);
dropdown(Alpine);
multiselect(Alpine);
initPasswordManagerFolders();
Alpine.start();

window.$ = window.jQuery = $;

$(function () {
  initSidebar();
  initSearch();
  initToast();
  initTables();
  initCustomScroll('.data-table__scroll, .password-manager-sidebar__folders-scroll, [data-custom-scroll]');
});

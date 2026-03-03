/**
 * Точка входа фичи «Менеджер паролей»: папки, теги, поиск.
 * Регистрирует Alpine.data и экспортирует init для app.js.
 */

import Alpine from 'alpinejs';
import { initPasswordManagerSortable, initPasswordManagerTagsSortable } from './sortable.js';
import { passwordManagerFoldersData } from './foldersData.js';
import { passwordManagerTagsSidebarData } from './tagsSidebarData.js';
import { passwordManagerSearchData } from './searchData.js';

export { initPasswordManagerSortable, initPasswordManagerTagsSortable };
export { passwordManagerFoldersData, passwordManagerSearchData };

export default function initPasswordManagerFolders() {
  window.initPasswordManagerSortable = initPasswordManagerSortable;
  window.initPasswordManagerTagsSortable = initPasswordManagerTagsSortable;
  window.passwordManagerFolders = passwordManagerFoldersData;
  window.passwordManagerSearchData = passwordManagerSearchData;
  Alpine.data('passwordManagerFolders', passwordManagerFoldersData);
  Alpine.data('passwordManagerSearch', passwordManagerSearchData);
  Alpine.data('passwordManagerTagsSidebar', passwordManagerTagsSidebarData);
}

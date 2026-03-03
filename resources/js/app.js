import './bootstrap';
import $ from 'jquery';
import Alpine from 'alpinejs';

// layout
import initSidebar from './layout/sidebar';

// ui
import { initDataDispatch } from './ui/dataDispatch';
import initSearch from './ui/search';
import initToast from './ui/toast';
import buttonToggle from './ui/buttonToggle';
import tooltip from './ui/tooltip';
import dropdown from './ui/dropdown';
import multiselect from './ui/multiselect';
import { initAll as initCustomScroll } from './ui/customScroll';

// components
import initTables from './components/initTables';

// features
import initPasswordManagerFolders from './features/password-manager';

// stores
import { initPasswordManagerStore } from './stores/passwordManager';

window.Alpine = Alpine;
initPasswordManagerStore(Alpine);
initDataDispatch();
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

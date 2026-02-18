import './bootstrap';
import $ from 'jquery';
import Alpine from 'alpinejs';

import initSidebar from './layout/sidebar';
import initSelect from './ui/select';
import initSearch from './ui/search';
import initToast from './ui/toast';
import initTables from './components/initTables';
import buttonToggle from './ui/buttonToggle';
import multiselect from './ui/multiselect';

window.Alpine = Alpine;
buttonToggle(Alpine);
multiselect(Alpine);
Alpine.start();

window.$ = window.jQuery = $;

$(function () {
  initSidebar();
  initSelect();
  initSearch();
  initToast();
  initTables();
});

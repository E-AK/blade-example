import './bootstrap';
import $ from 'jquery';
import Alpine from 'alpinejs';

import initSidebar from './layout/sidebar';
import initSearch from './ui/search';
import initToast from './ui/toast';
import initTables from './components/initTables';
import buttonToggle from './ui/buttonToggle';
import tooltip from './ui/tooltip';
import dropdown from './ui/dropdown';

window.Alpine = Alpine;
buttonToggle(Alpine);
tooltip(Alpine);
dropdown(Alpine);
Alpine.start();

window.$ = window.jQuery = $;

$(function () {
  initSidebar();
  initSearch();
  initToast();
  initTables();
});
